<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $check = Admin::count();
        if($check) {
            return;
        }
        DB::table('admins')->insert([
            "name" => "Supper Admin",
            "email" => "umakant@achieveee.com",
            "mobile_no" => "7506163660",
            "roles" => json_encode(["admin"]),
            'admin_type' => 'admin',
            "status" => 1,
            "email_verified_at" => Date('Y-m-d H:i:s'),
            "password" => Hash::make(123456)
        ]);
        DB::table('admins')->insert([
            "name" => "Teacher",
            "email" => "umakant.verma@vamaship.com",
            "mobile_no" => "7506163661",
            "roles" => json_encode(["teacher"]),
            'admin_type' => 'teacher',
            "status" => 1,
            "email_verified_at" => Date('Y-m-d H:i:s'),
            "password" => Hash::make(123456)
        ]);
    }
}
