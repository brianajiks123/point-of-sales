<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
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
                    <button class='btn btn-xs btn-warning mr-3' onclick='editProduct(`" . route("product.update", $product->id) . "`)'><i class='fa fa-pencil-alt'></i></button>
                    <button class='btn btn-xs btn-danger' onclick='deleteProduct(`" . route("product.destroy", $product->id) . "`)'><i class='fa fa-trash-alt'></i></button>
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
            $product->name = $request->name;
            $product->category_id = $request->category_id;
            $product->brand = $request->brand;
            $product->price = $request->price;
            $product->sell_price = $request->sell_price;
            $product->discount = $request->discount;
            $product->stock = $request->stock;
            $product->save();

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
        foreach ($request->product_id as $product_id) {
            $product = Product::findOrFail($product_id);
            
            if ($product) {
                $product->delete();
            }
        }

        return response()->json("Delete selected product successfully.");
    }
}
