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
        DB::table('users')->insert([
            [
            'name' => "admin",
            'email' => "admin@gmail.com",
            'address' => 'delhanes',
            'role' => 'admin',
            'password' => Hash::make('password123'),
            'is_admin' => false,

            ],
            [
                'name' => "UserAdmin",
                'email' => "UserAdmin@gmail.com",
                'address' => 'delhanes',
                'role' => 'user',
                'password' => Hash::make('password123'),
                'is_admin' => true,

            ]
        ]);
    }
}
