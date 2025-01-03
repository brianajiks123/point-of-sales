<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $menu = "Category";

        return view("category.index", compact("menu"));
    }

    public function data()
    {
        $categories = Category::latest();

        return datatables()
            ->of($categories)
            ->addIndexColumn()
            ->addColumn("action", function ($category) {
                return "
                <div class='btn-group'>
                    <button class='btn btn-xs btn-warning mr-3' onclick='editCategory(`". route("category.update", $category->id) ."`)'><i class='fa fa-pencil-alt'></i></button>
                    <button class='btn btn-xs btn-danger' onclick='deleteCategory(`". route("category.destroy", $category->id) ."`)'><i class='fa fa-trash-alt'></i></button>
                </div>
                ";
            })
            ->rawColumns(["action"])
            ->make(true);
    }

    public function store(Request $request)
    {
        $category = Category::create($request->all());

        if ($category) {
            return response()->json("Add category successfully.", 201);
        }
    }

    public function show(string $id)
    {
        $category = Category::findOrFail($id);

        if ($category) {
            return response()->json($category);
        }
    }

    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        if ($category) {
            $category->name = $request->name;
            $category->update();

            return response()->json("Update category successfully.");
        }
    }

    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        if ($category) {
            $category->delete();

            return response()->json("Delete category successfully.");
        }
    }
}
