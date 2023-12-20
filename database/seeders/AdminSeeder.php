<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert admin details
        DB::table('users')->insert([
            'id' => 1,
            'first_name' => 'Dinesh',
            'last_name' => 'Baidya',
            'name' => 'Dinesh Baidya',
            'username' => 'Admin',
            'email' => 'dineshbaidya15@gmail.com',
            'password' => Hash::make('Admin@123'),
            'plain_pass' => 'Admin@123',
            'profile_pic' => '',
            'status' => 'active',
            'type' => 'admin',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
