<?php

namespace App\Http\Controllers;

use App\Models\{
    Expense,
    Purchase,
    Sale,
};
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $menu = "Income Report";

        $first_date = date("Y-m-d", mktime(0, 0, 0, date("m"), 1, date("Y")));
        $last_date = date("Y-m-d");

        if (($request->has("f_date") && $request->f_date != "") && ($request->has("l_date") && $request->l_date != "")) {
            $validated = $request->validate([
                'f_date' => 'required|date_format:m/d/Y',
                'l_date' => 'required|date_format:m/d/Y|after_or_equal:f_date',
            ]);

            $first_date = Carbon::createFromFormat('m/d/Y', $validated['f_date'])->format('Y-m-d');
            $last_date = Carbon::createFromFormat('m/d/Y', $validated['l_date'])->format('Y-m-d');
        }

        return view("report.index", compact("menu", "first_date", "last_date"));
    }

    public function getData($first_date, $last_date)
    {
        $data = [];
        $total_income = 0;

        $current_date = Carbon::parse($first_date);
        $last_date = Carbon::parse($last_date);

        $counter = 1;

        while ($current_date <= Carbon::parse($last_date)) {
            $date = $current_date->format('Y-m-d');
            $current_date->addDay();

            $total_sale = Sale::whereDate('created_at', $date)->sum('pay');
            $total_purchase = Purchase::whereDate('created_at', $date)->sum('pay');
            $total_expense = Expense::whereDate('created_at', $date)->sum('amount');

            $income = $total_sale - $total_purchase - $total_expense;
            $total_income += $income;

            $row = [];
            $row["DT_RowIndex"] = $counter;
            $row["date"] = indonesia_date($date, false);
            $row["sale"] = indonesia_money_format($total_sale);
            $row["purchase"] = indonesia_money_format($total_purchase);
            $row["expense"] = indonesia_money_format($total_expense);
            $row["income"] = indonesia_money_format($income);

            $data[] = $row;

            $counter++;
        }

        $data[] = [
            "DT_RowIndex" => "",
            "date" => "",
            "sale" => "",
            "purchase" => "",
            "expense" => "Total Pendapatan",
            "income" => indonesia_money_format($total_income),
        ];

        $data_collection = collect($data);

        return $data_collection;
    }

    public function data($first_date, $last_date)
    {
        $data = $this->getData($first_date, $last_date);

        return datatables()
            ->of($data)
            ->make(true);
    }

    public function exportPdf($first_date, $last_date)
    {
        $data = $this->getData($first_date, $last_date);

        $pdf = Pdf::loadView("report.pdf", compact("data", "first_date", "last_date"));
        $pdf->setPaper("a4", "portrait");

        return $pdf->stream("Report-" . date("Y-m-d-his") . "_" . $first_date . "-" . $last_date . ".pdf");
    }
}
