<?php

namespace App\Http\Controllers;

use App\Models\{
    Member,
    Setting,
};
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $menu = "Member";

        return view("member.index", compact("menu"));
    }

    public function data()
    {
        $members = Member::latest();

        return datatables()
            ->of($members)
            ->addIndexColumn()
            ->addColumn("select_all_member", function ($member) {
                return "<input type='checkbox' name='member_id[]' value='" . $member->id . "'>";
            })
            ->addColumn("member_code", function ($member) {
                return "<span class='badge badge-success' style='font-size: 14px;'>" . $member->member_code . "</span>";
            })
            ->addColumn("action", function ($member) {
                return "
                    <div class='btn-group'>
                        <button type='button' class='btn btn-xs btn-warning mr-3' onclick='editMember(`" . route("member.update", $member->id) . "`)'><i class='fa fa-pencil-alt'></i></button>
                        <button type='button' class='btn btn-xs btn-danger' onclick='deleteMember(`" . route("member.destroy", $member->id) . "`)'><i class='fa fa-trash-alt'></i></button>
                    </div>
                ";
            })
            ->rawColumns(["select_all_member", "member_code", "action"])
            ->make(true);
    }

    public function store(Request $request)
    {
        $latest_member = Member::latest()->first();
        $member_code = $latest_member ? ($latest_member->member_code + 1) : 1;

        Member::create([
            'member_code' => code_generator($member_code, 5),
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return response()->json('Add member successfully.', 201);
    }

    public function show(string $id)
    {
        $member = Member::findOrFail($id);

        return response()->json($member);
    }

    public function update(Request $request, string $id)
    {
        $member = Member::findOrFail($id);

        if ($member) {
            $member->update($request->all());

            return response()->json("Update member successfully.");
        }
    }

    public function destroy(string $id)
    {
        $member = Member::findOrFail($id);

        if ($member) {
            $member->delete();

            return response()->json("Delete member successfully.");
        }
    }

    public function deleteSelected(Request $request)
    {
        if ($request->has('member_id') && is_array($request->member_id)) {
            foreach ($request->member_id as $member_id) {
                $member = Member::findOrFail($member_id);

                if ($member) {
                    $member->delete();
                }
            }

            return response()->json(['message' => 'Selected members deleted successfully.']);
        }

        return response()->json(['error' => 'No members selected.'], 400);
    }

    public function printMember(Request $request)
    {
        if ($request->has('member_id') && is_array($request->member_id)) {
            $data_member = array();
            $data_member_id = $request->member_id;

            foreach ($data_member_id as $member_id) {
                $member = Member::findOrFail($member_id);
                $data_member[] = $member;
            }

            $setting = Setting::first();

            $pdf = Pdf::loadView('member.print', compact('data_member', "setting"));
            $pdf->setPaper(array(0, 0, 566.93, 850.39), "portrait");

            return $pdf->stream('member.pdf');
        }

        return response()->json(['error' => 'No members selected.'], 400);
    }
}
