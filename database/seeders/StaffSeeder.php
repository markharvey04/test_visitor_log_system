<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Receptionist
        DB::table('staff')->insert([
            'RoleID' => 1, 
            'DeptID' => 1, 
            'Username' => 'reception',
            'Name' => 'Maria Receptionist',
            'password' => Hash::make('password123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Security
        DB::table('staff')->insert([
            'RoleID' => 2, 
            'DeptID' => 1, 
            'Username' => 'security',
            'Name' => 'Officer John',
            'password' => Hash::make('password123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Admin
        DB::table('staff')->insert([
            'RoleID' => 3, 
            'DeptID' => 3, 
            'Username' => 'admin',
            'Name' => 'System Admin',
            'password' => Hash::make('password123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}