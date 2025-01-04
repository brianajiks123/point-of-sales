<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $menu = "Setting";

        return view("setting.index", compact("menu"));
    }

    public function show()
    {
        return Setting::first();
    }

    public function update(Request $request, string $id)
    {
        $setting = Setting::findOrFail($id);

        if ($setting) {
            $setting->company_name = $request->company_name;
            $setting->phone = $request->phone;
            $setting->address = $request->address;
            $setting->discount = $request->discount;
            $setting->note_type = $request->note_type;

            if ($request->hasFile("path_logo")) {
                $file_logo = $request->file("path_logo");
                $logo_name = "logo-" . date("Y-m-dHis") . "." . $file_logo->getClientOriginalExtension();
                $file_logo->move(public_path("admin/images"), $logo_name);

                $setting->path_logo = "admin/images/" . $logo_name;
            }

            if ($request->hasFile("path_card_member")) {
                $file_card_member = $request->file("path_card_member");
                $card_member_name = "card_member-" . date("Y-m-dHis") . "." . $file_card_member->getClientOriginalExtension();
                $file_card_member->move(public_path("admin/images"), $card_member_name);

                $setting->path_card_member = "admin/images/" . $card_member_name;
            }

            $setting->update();
        }
    }
}
