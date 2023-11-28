<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'fullname' => 'Administrator',
            'email' => 'admin@admin.com',
            'role' => 'admin',
            'password' => Hash::make('123456')
        ]);

        DB::table('users')->insert([
            'fullname' => 'Juri',
            'email' => 'juri@juri.com',
            'role' => 'juri',
            'password' => Hash::make('123456')
        ]);
    }
}