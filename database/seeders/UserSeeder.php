<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("users")->insert([
            "name" => "Admin",
            "email" => "testing@admin.pos.com",
            "email_verified_at" => now(),
            "password" => bcrypt(12345678),
            "current_team_id" => 1,
            "profile_photo_path" => "admin/images/avatar5.png",
            "created_at" => now(),
            "updated_at" => now()
        ]);
    }
}
