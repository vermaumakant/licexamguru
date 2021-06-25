<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $check = User::count();
        if($check) {
            return;
        }
        DB::table('users')->insert([
            "name" => "Supper Admin",
            "email" => "umakant@achieveee.com",
            "mobile_no" => "7506163660",
            "status" => 1,
            "email_verified_at" => Date('Y-m-d H:i:s'),
            "password" => Hash::make(123456)
        ]);
    }
}
