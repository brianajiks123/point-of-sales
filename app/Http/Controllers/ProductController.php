<?php

namespace App\Http\Controllers;

use App\Models\{
    Category,
    Product,
};
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $menu = "Product";

        $categories = Category::select("id", "name")->get();

        return view("product.index", compact("menu", "categories"));
    }

    public function data()
    {
        $products = Product::with('category')->latest()->get();

        return datatables()
            ->of($products)
            ->addIndexColumn()
            ->addColumn("select_all_product", function ($product) {
                return "<input type='checkbox' name='product_id[]' value='" . $product->id . "'>";
            })
            ->addColumn("code", function ($product) {
                return "<span class='badge badge-success' style='font-size: 14px;'>" . $product->code . "</span>";
            })
            ->addColumn("price", function ($product) {
                return indonesia_money_format($product->price);
            })
            ->addColumn("sell_price", function ($product) {
                return indonesia_money_format($product->sell_price);
            })
            ->addColumn('category', function ($product) {
                return $product->category ? $product->category->name : '';
            })
            ->addColumn("action", function ($product) {
                return "
                <div class='btn-group'>
                    <button type='button' class='btn btn-xs btn-warning mr-3' onclick='editProduct(`" . route("product.update", $product->id) . "`)'><i class='fa fa-pencil-alt'></i></button>
                    <button type='button' class='btn btn-xs btn-danger' onclick='deleteProduct(`" . route("product.destroy", $product->id) . "`)'><i class='fa fa-trash-alt'></i></button>
                </div>
                ";
            })
            ->rawColumns(["select_all_product", "code", "action"])
            ->make(true);
    }

    public function store(Request $request)
    {
        // Generate Product Code
        $product = Product::all();
        $product_code = !$product->isEmpty() ? Product::select("code")->latest()->first()->code : '';
        $new_code = ($product_code !== '') ? $product_code[5] + 1 : 1;
        $request["code"] = "P" . code_generator($new_code, 5);  # example result: P00001

        $product = Product::create($request->all());

        if ($product) {
            return response()->json("Add product successfully.", 201);
        }
    }

    public function show(string $id)
    {
        $product = Product::with('category')->findOrFail($id);
        $product->category_id = $product->category->id;
        $product->category_name = $product->category->name;

        if ($product) {
            return response()->json($product);
        }
    }

    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        if ($product) {
            $product->update($request->all());

            return response()->json("Update product successfully.");
        }
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        if ($product) {
            $product->delete();

            return response()->json("Delete product successfully.");
        }
    }

    public function deleteSelected(Request $request)
    {
        if ($request->has('product_id') && is_array($request->product_id)) {
            foreach ($request->product_id as $product_id) {
                $product = Product::findOrFail($product_id);

                if ($product) {
                    $product->delete();
                }
            }

            return response()->json(['message' => 'Selected products deleted successfully.']);
        }

        return response()->json(['error' => 'No products selected.'], 400);
    }

    public function printBarcode(Request $request)
    {
        if ($request->has('product_id') && is_array($request->product_id)) {
            $data_product = array();
            $data_product_id = $request->product_id;

            foreach ($data_product_id as $product_id) {
                $product = Product::findOrFail($product_id);
                $data_product[] = $product;
            }

            $pdf = Pdf::loadView('product.barcode', compact('data_product'));
            $pdf->setPaper("a4", "portrait");

            return $pdf->stream('product.pdf');
        }

        return response()->json(['error' => 'No products selected.'], 400);
    }
}
