<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $menu = "Supplier";

        return view("supplier.index", compact("menu"));
    }

    public function data()
    {
        $suppliers = Supplier::latest();

        return datatables()
            ->of($suppliers)
            ->addIndexColumn()
            ->addColumn("action", function ($supplier) {
                return "
                <div class='btn-group'>
                    <button class='btn btn-xs btn-warning mr-3' onclick='editSupplier(`". route("supplier.update", $supplier->id) ."`)'><i class='fa fa-pencil-alt'></i></button>
                    <button class='btn btn-xs btn-danger' onclick='deleteSupplier(`". route("supplier.destroy", $supplier->id) ."`)'><i class='fa fa-trash-alt'></i></button>
                </div>
                ";
            })
            ->rawColumns(["action"])
            ->make(true);
    }

    public function store(Request $request)
    {
        $supplier = Supplier::create($request->all());

        if ($supplier) {
            return response()->json("Add supplier successfully.", 201);
        }
    }

    public function show(string $id)
    {
        $supplier = Supplier::findOrFail($id);

        if ($supplier) {
            return response()->json($supplier);
        }
    }

    public function update(Request $request, string $id)
    {
        $supplier = Supplier::findOrFail($id);

        if ($supplier) {
            $supplier->name = $request->name;
            $supplier->phone = $request->phone;
            $supplier->address = $request->address;
            $supplier->update();

            return response()->json("Update supplier successfully.");
        }
    }

    public function destroy(string $id)
    {
        $supplier = Supplier::findOrFail($id);

        if ($supplier) {
            $supplier->delete();

            return response()->json("Delete supplier successfully.");
        }
    }
}
