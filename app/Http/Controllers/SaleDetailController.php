<?php

namespace App\Http\Controllers;

use App\Models\{
    Member,
    Product,
    Sale,
    SaleDetail,
    Setting,
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleDetailController extends Controller
{
    public function index()
    {
        $menu = "Sale Transaction";

        $products = Product::latest()->get();
        $members = Member::latest()->get();
        $discount = Setting::first()->discount ?? 0;

        // Check Transaction Session
        if ($sale_id = session("sale_id")) {
            $sale = Sale::findOrFail($sale_id);
            $member = $sale->member ?? new Member;

            return view("sale_detail.index", compact("menu", "products", "members", "discount", "sale_id", "sale", "member"));
        }

        // Admin Only
        if (Auth::user()->current_team_id == 1) {
            return redirect()->route("transaction.new");
        } else {
            return redirect("/");
        }
    }

    public function data(string $id)
    {
        $details = SaleDetail::with("product")
            ->where("sale_id", $id)
            ->get();

        $total = 0;
        $total_amount = 0;

        $sale_data = $details->map(function ($detail) use (&$total, &$total_amount) {
            // Format each row's data
            $row_data = [
                "product_code" => "<span class='badge badge-success' style='font-size: 14px;'>" . $detail->product->code . "</span>",
                "product_name" => $detail->product->name,
                "sale_price" => indonesia_money_format($detail->sale_price),
                "amount" => "<input type='number' data-id='" . $detail->id . "' class='form-control input-sm edit_amount' id='edit_amount_" . $detail->id . "' value='" . $detail->amount . "' min='1'>",
                "sub_total" => indonesia_money_format($detail->sub_total),
                "action" => "
                    <div class='btn-group'>
                        <button class='btn btn-xs btn-danger' onclick='deleteSaleDetail(`" . route("transaction.destroy", $detail->id) . "`)'>
                            <i class='fa fa-trash-alt'></i>
                        </button>
                    </div>
                "
            ];

            // Accumulate totals
            $total += $detail->sale_price * $detail->amount;
            $total_amount += $detail->amount;

            return $row_data;
        });

        $sale_data->push([
            "product_code" => "<input type='hidden' class='total' value='" . $total . "'> <input type='hidden' class='total_amount' value='" . $total_amount . "'>",
            "product_name" => "",
            "sale_price" => "",
            "amount" => "",
            "sub_total" => "",
            "action" => "",
        ]);

        return datatables()
            ->of($sale_data)
            ->addIndexColumn()
            ->rawColumns(["product_code", "amount", "action"])
            ->make(true);
    }

    public function store(Request $request)
    {
        $product = Product::where("id", $request->product_id)->first();

        if (!$product) {
            return response()->json("Failed to save sale detail data.", 400);
        }

        $detail = new SaleDetail();
        $detail->sale_id = $request->sale_id;
        $detail->product_id = $product->id;
        $detail->sale_price = $product->price;
        $detail->amount = 1;
        $detail->sub_total = $product->price;
        $detail->save();

        return response()->json("Add sale detail data successfully.", 201);
    }

    public function update(Request $request, string $id)
    {
        $detail = SaleDetail::findOrFail($id);

        if ($detail) {
            $detail->amount = $request->amount;
            $detail->sub_total = $detail->sale_price * $request->amount;
            $detail->update();

            return response()->json("Update amount of sale detail data successfully.");
        }
    }

    public function destroy(string $id)
    {
        $detail = SaleDetail::findOrFail($id);

        if ($detail) {
            $detail->delete();

            return response()->json("Delete sale detail data successfully.");
        }
    }

    public function loadForm(int $discount, int $total, int $accepted)
    {
        $pay = $total - (($discount / 100) * $total);
        $pay_back = ($accepted != 0) ? ($accepted - $pay) : 0;

        $data = [
            "total_rp" => indonesia_money_format($total),
            "pay" => $pay,
            "pay_rp" => indonesia_money_format($pay),
            "show_text" => ucwords(number_in_words($pay) . " Rupiah"),
            "back_rp" => indonesia_money_format($pay_back),
            "back_show_text" => ucwords(number_in_words($pay_back) . " Rupiah"),
        ];

        return response()->json($data);
    }
}
