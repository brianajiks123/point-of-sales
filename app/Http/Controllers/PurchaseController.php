<?php

namespace App\Http\Controllers;

use App\Models\{
    Purchase,
    Product,
    PurchaseDetail,
    Supplier,
};
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        $menu = "Purchase";

        $suppliers = Supplier::get();

        return view("purchase.index", compact("menu", "suppliers"));
    }

    public function data()
    {
        $purchases = Purchase::latest()->get();

        return datatables()
            ->of($purchases)
            ->addIndexColumn()
            ->addColumn("created_at", function ($purchase) {
                return indonesia_date($purchase->created_at, false);
            })
            ->addColumn("supplier", function ($purchase) {
                return $purchase->supplier->name;
            })
            ->addColumn("total_item", function ($purchase) {
                return $purchase->total_item;
            })
            ->addColumn("total_price", function ($purchase) {
                return indonesia_money_format($purchase->total_price);
            })
            ->addColumn("discount", function ($purchase) {
                return $purchase->discount;
            })
            ->addColumn("pay", function ($purchase) {
                return indonesia_money_format($purchase->pay);
            })
            ->addColumn("action", function ($purchase) {
                return "
                <div class='btn-group'>
                    <button class='btn btn-xs btn-info' onclick='showPurchase(`" . route("purchase.show", $purchase->id) . "`)'><i class='fa fa-eye'></i></button>
                    <button class='btn btn-xs btn-danger mx-2' onclick='deletePurchase(`" . route("purchase.destroy", $purchase->id) . "`)'><i class='fa fa-trash-alt'></i></button>
                </div>
                ";
            })
            ->rawColumns(["action"])
            ->make(true);
    }

    public function create(string $id)
    {
        $purchase = Purchase::create([
            "supplier_id" => $id,
            "total_item" => 0,
            "total_price" => 0,
            "discount" => 0,
            "pay" => 0
        ]);

        // Create Session
        session(["purchase_id" => $purchase->id]);
        session(["supplier_id" => $purchase->supplier_id]);

        return redirect()->route("purchase_detail.index");
    }

    public function store(Request $request)
    {
        $purchase = Purchase::findOrFail($request->purchase_id);

        if ($purchase) {
            $purchase->total_item = $request->total_amount_purchase;
            $purchase->total_price = $request->total_purchase;
            $purchase->discount = $request->discount;
            $purchase->pay = $request->pay;
            $purchase->update();

            // Update Product Stock
            $details = PurchaseDetail::where("purchase_id", $purchase->id)->get();

            foreach ($details as $detail) {
                $product = Product::findOrFail($detail->product_id);

                if ($product) {
                    $product->stock += $detail->amount;
                    $product->update();
                }
            }

            // session()->forget('purchase_id');
            // session()->forget('supplier_id');

            return redirect()->route("purchase.index");
        }
    }

    public function show(string $id)
    {
        $details = PurchaseDetail::with("product")->where("purchase_id", $id)->get();

        return datatables()
            ->of($details)
            ->addIndexColumn()
            ->addColumn("product_code", function ($detail) {
                return $detail->product->code;
            })
            ->addColumn("product_name", function ($detail) {
                return $detail->product->name;
            })
            ->addColumn("purchase_price", function ($detail) {
                return indonesia_money_format($detail->purchase_price);
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
        // Subtraction of Product Amount
        $purchase_details = PurchaseDetail::where("purchase_id", $id)->get();

        if ($purchase_details) {
            foreach ($purchase_details as $detail) {
                $product = Product::findOrFail($detail->product_id);

                if ($product) {
                    $product->stock -= $detail->amount;
                    $product->update();
                }
            }

            // Delete Purchase Data
            $purchase = Purchase::findOrFail($id);

            if ($purchase) {
                $purchase->delete();

                return response()->json("Delete purchase data successfully.");
            }
        }
    }
}
