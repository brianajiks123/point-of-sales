<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("settings")->insert([
            "company_name" => config("app.name"),
            "address" => "JL KONOHA",
            "phone" => "81111111111",
            "note_type" => 2,   // 1: small, 2: big
            "discount" => 10,
            "path_logo" => "admin/images/logo.png",
            "path_card_member" => "admin/images/card_member.png",
            "created_at" => now(),
            "updated_at" => now()
        ]);
    }
}
