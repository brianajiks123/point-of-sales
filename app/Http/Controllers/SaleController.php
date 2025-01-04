<?php

namespace App\Http\Controllers;

use App\Models\{
    Product,
    Sale,
    SaleDetail,
    Setting,
};
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    public function index()
    {
        $menu = "Sale";

        return view("sale.index", compact("menu"));
    }

    public function data()
    {
        $sales = Sale::latest()->get();

        return datatables()
            ->of($sales)
            ->addIndexColumn()
            ->addColumn("created_at", function ($sale) {
                return indonesia_date($sale->created_at, false);
            })
            ->addColumn("member_code", function ($sale) {
                return "<span class='badge badge-success' style='font-size: 14px;'>" . ($sale->member->member_code ?? "") . "</span>";
            })
            ->addColumn("total_item", function ($sale) {
                return $sale->total_item;
            })
            ->addColumn("total_price", function ($sale) {
                return indonesia_money_format($sale->total_price);
            })
            ->addColumn("discount", function ($sale) {
                return $sale->discount;
            })
            ->addColumn("total_pay", function ($sale) {
                return indonesia_money_format($sale->pay);
            })
            ->addColumn("cashier", function ($sale) {
                return $sale->user->name ?? "";
            })
            ->addColumn("action", function ($sale) {
                return "
                <div class='btn-group'>
                    <button class='btn btn-xs btn-info' onclick='showSaleDetail(`" . route("sale.show", $sale->id) . "`)'><i class='fa fa-eye'></i></button>
                    <button class='btn btn-xs btn-danger mx-2' onclick='deleteSale(`" . route("sale.destroy", $sale->id) . "`)'><i class='fa fa-trash-alt'></i></button>
                </div>
                ";
            })
            ->rawColumns(["member_code", "action"])
            ->make(true);
    }

    public function create()
    {
        $sale = new Sale;
        $sale->member_id = null;
        $sale->total_item = 0;
        $sale->total_price = 0;
        $sale->discount = 0;
        $sale->pay = 0;
        $sale->accepted = 0;
        $sale->user_id = Auth::user()->id;
        $sale->save();

        session(["sale_id" => $sale->id]);

        return redirect()->route("transaction.index");
    }

    public function store(Request $request)
    {
        $sale = Sale::findOrFail($request->sale_id);

        if ($sale) {
            $sale->member_id = $request->member_id;
            $sale->total_item = $request->total_amount_sale;
            $sale->total_price = $request->total_sale;
            $sale->discount = $request->discount;
            $sale->pay = $request->pay;
            $sale->accepted = $request->accepted;
            $sale->update();

            // Update Product Stock
            $details = SaleDetail::where("sale_id", $sale->id)->get();

            foreach ($details as $detail) {
                $product = Product::findOrFail($detail->product_id);

                if ($product) {
                    $product->stock -= $detail->amount;
                    $product->update();
                }
            }

            // session()->forget('sale_id');

            return redirect()->route("transaction.finish");
        }
    }

    public function finish()
    {
        $menu = "Sale Transaction";

        $setting = Setting::first();

        return view("sale.finish", compact("menu", "setting"));
    }

    public function show(string $id)
    {
        $details = SaleDetail::with("product")->where("sale_id", $id)->get();

        return datatables()
            ->of($details)
            ->addIndexColumn()
            ->addColumn("product_code", function ($detail) {
                return $detail->product->code;
            })
            ->addColumn("product_name", function ($detail) {
                return $detail->product->name;
            })
            ->addColumn("sale_price", function ($detail) {
                return indonesia_money_format($detail->sale_price);
            })
            ->addColumn("amount", function ($detail) {
                return $detail->amount;
            })
            ->addColumn("sub_total", function ($detail) {
                return indonesia_money_format($detail->sub_total);
            })
            ->make(true);
    }

    public function destroy(string $id)
    {
        // Addition of Product Amount
        $sale_details = SaleDetail::where("sale_id", $id)->get();

        if ($sale_details) {
            foreach ($sale_details as $detail) {
                $product = Product::findOrFail($detail->product_id);

                if ($product) {
                    $product->stock += $detail->amount;
                    $product->update();
                }
            }

            // Delete Sale Data
            $sale = Sale::findOrFail($id);

            if ($sale) {
                $sale->delete();

                return response()->json("Delete sale data successfully.");
            }
        }
    }

    // Print Note
    public function smallNote()
    {
        $title = "Small Note";

        $setting = Setting::first();

        $sale = Sale::findOrFail(session("sale_id"));

        if (!$sale) {
            abort(404);
        }

        $detail = SaleDetail::with("product")
            ->where("sale_id", session("sale_id"))
            ->get();

        return view("sale.small_note", compact("title", "setting", "sale", "detail"));
    }

    public function bigNote()
    {
        $title = "Big Note";

        $setting = Setting::first();

        $sale = Sale::findOrFail(session("sale_id"));

        if (!$sale) {
            abort(404);
        }

        $details = SaleDetail::with("product")
            ->where("sale_id", session("sale_id"))
            ->get();

        $pdf = Pdf::loadView("sale.big_note", compact("title", "setting", "sale", "details"));
        $pdf->setPaper(array(0, 0, 610, 540), "portrait");
        return $pdf->stream("Transaksi-"  . date("Y-m-d-his") . ".pdf");
    }
}
