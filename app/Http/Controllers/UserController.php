<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
            "profile_photo_path" => "/images/avatar5.png",
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
}
