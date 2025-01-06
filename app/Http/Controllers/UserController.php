<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $menu = "User";

        return view("user.index", compact("menu"));
    }

    public function data()
    {
        $users = User::isNotAdmin()->get();

        return datatables()
            ->of($users)
            ->addIndexColumn()
            ->addColumn("action", function ($user) {
                return "
                <div class='btn-group'>
                    <button class='btn btn-xs btn-warning mr-3' onclick='editUser(`" . route("user.update", $user->id) . "`)'><i class='fa fa-pencil-alt'></i></button>
                    <button class='btn btn-xs btn-danger' onclick='deleteUser(`" . route("user.destroy", $user->id) . "`)'><i class='fa fa-trash-alt'></i></button>
                </div>
                ";
            })
            ->rawColumns(["action"])
            ->make(true);
    }

    public function store(Request $request)
    {
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => $request->password,
            "current_team_id" => 2,  // cashier
            "profile_photo_path" => "admin/images/avatar5.png",
        ]);

        if ($user) {
            return response()->json("Add user successfully.", 201);
        }
    }

    public function show(string $id)
    {
        $user = User::findOrFail($id);

        if ($user) {
            return response()->json($user);
        }
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        if ($user) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->update();

            return response()->json("Update user successfully.");
        }
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if ($user) {
            $user->delete();

            return response()->json("Delete user successfully.");
        }
    }

    public function profile()
    {
        $menu = "Profile";

        return view("user.profile", compact("menu"));
    }

    public function updateProfile(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);

        $user->name = $request->name;

        if ($request->hasFile("profile_photo_path")) {
            $file_profile = $request->file("profile_photo_path");
            $profile_name = "profile-" . date("Y-m-dHis") . "." . $file_profile->getClientOriginalExtension();
            $file_profile->move(public_path("admin/images"), $profile_name);

            $user->profile_photo_path = "admin/images/" . $profile_name;
        }

        if ($request->has("new_password") && $request->new_password != "") {
            if ($request->has("curr_password") && $request->curr_password != "") {
                if (Hash::check($request->curr_password, $user->password)) {
                    $user->password = $request->new_password;
                } else {
                    return response()->json("Current password is not match!", 422);
                }
            }
        }

        $user->update();

        return response()->json($user);
    }
}
