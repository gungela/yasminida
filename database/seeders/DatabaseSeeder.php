<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        DB::table('users')->insert([
            'name' => 'superadmin',
            'alamat' => 'Bali',
            'gender' => 'perempuan',
            'role' => 'manager',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('password'), // Hashing password for security
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
