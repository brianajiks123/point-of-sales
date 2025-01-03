<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $menu = "Expense";

        return view("expense.index", compact("menu"));
    }

    public function data()
    {
        $expenses = Expense::latest();

        return datatables()
            ->of($expenses)
            ->addIndexColumn()
            ->addColumn("created_at", function ($expense) {
                return indonesia_date($expense->created_at, false);
            })
            ->addColumn("amount", function ($expense) {
                return indonesia_money_format($expense->amount);
            })
            ->addColumn("action", function ($expense) {
                return "
                <div class='btn-group'>
                    <button class='btn btn-xs btn-warning mr-3' onclick='editExpense(`" . route("expense.update", $expense->id) . "`)'><i class='fa fa-pencil-alt'></i></button>
                    <button class='btn btn-xs btn-danger' onclick='deleteExpense(`" . route("expense.destroy", $expense->id) . "`)'><i class='fa fa-trash-alt'></i></button>
                </div>
                ";
            })
            ->rawColumns(["action"])
            ->make(true);
    }

    public function store(Request $request)
    {
        $expense = Expense::create($request->all());

        if ($expense) {
            return response()->json("Add expense successfully.", 201);
        }
    }

    public function show(string $id)
    {
        $expense = Expense::findOrFail($id);

        if ($expense) {
            return response()->json($expense);
        }
    }

    public function update(Request $request, string $id)
    {
        $expense = Expense::findOrFail($id);

        if ($expense) {
            $expense->description = $request->description;
            $expense->amount = $request->amount;
            $expense->update();

            return response()->json("Update expense successfully.");
        }
    }

    public function destroy(string $id)
    {
        $expense = Expense::findOrFail($id);

        if ($expense) {
            $expense->delete();

            return response()->json("Delete expense successfully.");
        }
    }
}
