<?php

namespace App\Http\Controllers;

use App\Models\{
    Product,
    Purchase,
    PurchaseDetail,
    Supplier,
};
use Illuminate\Http\Request;

class PurchaseDetailController extends Controller
{
    public function index()
    {
        $menu = "Purchase Transaction";

        $product = Product::get();
        $supplier = Supplier::findOrFail(session("supplier_id"));
        $purchase_id = session("purchase_id");
        $discount = Purchase::findOrFail($purchase_id)->discount ?? 0;

        if (!$supplier) {
            abort(404);
        }

        return view("purchase_detail.index", compact("menu", "product", "supplier", "purchase_id", "discount"));
    }

    public function data(string $id)
    {
        $details = PurchaseDetail::with("product")
            ->where("purchase_id", $id)
            ->get();

        $total = 0;
        $total_amount = 0;

        $purchase_data = $details->map(function ($detail) use (&$total, &$total_amount) {
            // Format each row's data
            $row_data = [
                "product_code" => "<span class='badge badge-success' style='font-size: 14px;'>" . $detail->product->code . "</span>",
                "product_name" => $detail->product->name,
                "price" => indonesia_money_format($detail->purchase_price),
                "amount" => "<input type='number' data-id='" . $detail->id . "' class='form-control input-sm edit_amount' id='edit_amount_" . $detail->id . "' value='" . $detail->amount . "' min='1'>",
                "sub_total" => indonesia_money_format($detail->sub_total),
                "action" => "
                    <div class='btn-group'>
                        <button class='btn btn-xs btn-danger' onclick='deletePurchaseDetail(`" . route("purchase_detail.destroy", $detail->id) . "`)'>
                            <i class='fa fa-trash-alt'></i>
                        </button>
                    </div>
                "
            ];

            // Accumulate totals
            $total += $detail->purchase_price * $detail->amount;
            $total_amount += $detail->amount;

            return $row_data;
        });

        $purchase_data->push([
            "product_code" => "<input type='hidden' class='total' value='" . $total . "'> <input type='hidden' class='total_amount' value='" . $total_amount . "'>",
            "product_name" => "",
            "price" => "",
            "amount" => "",
            "sub_total" => "",
            "action" => "",
        ]);

        return datatables()
            ->of($purchase_data)
            ->addIndexColumn()
            ->rawColumns(["product_code", "amount", "action"])
            ->make(true);
    }

    public function store(Request $request)
    {
        $product = Product::where("id", $request->product_id)->first();

        if (!$product) {
            return response()->json("Failed to save purchase detail data.", 400);
        }

        $detail = PurchaseDetail::create([
            "purchase_id" => $request->purchase_id,
            "product_id" => $product->id,
            "purchase_price" => $product->price,
            "amount" => 1,
            "sub_total" => $product->price
        ]);

        if ($detail) {
            return response()->json("Add purchase detail data successfully.", 201);
        }
    }

    public function update(Request $request, string $id)
    {
        $detail = PurchaseDetail::findOrFail($id);

        if ($detail) {
            $detail->amount = $request->amount;
            $detail->sub_total = $detail->purchase_price * $request->amount;
            $detail->update();

            return response()->json("Update amount of purchase detail data successfully.");
        }
    }

    public function destroy(string $id)
    {
        $detail = PurchaseDetail::findOrFail($id);

        if ($detail) {
            $detail->delete();

            return response()->json("Delete purchase detail data successfully.");
        }
    }

    public function loadForm(int $discount, int $total)
    {
        $pay = $total - (($discount / 100) * $total);

        $data = [
            "total_rp" => indonesia_money_format($total),
            "pay" => $pay,
            "pay_rp" => indonesia_money_format($pay),
            "show_text" => ucwords(number_in_words($pay) . " Rupiah"),
        ];

        return response()->json($data);
    }
}
