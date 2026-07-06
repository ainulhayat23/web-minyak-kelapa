<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Membuat akun administrator Maloppo.
     */
    public function run(): void
    {
        User::firstOrCreate(
            [
                'email' => env('ADMIN_EMAIL'),
            ],
            [
                'name' => env('ADMIN_NAME', 'Admin Maloppo'),
                'email_verified_at' => now(),
                'password' => Hash::make(env('ADMIN_PASSWORD')),
            ]
        );
    }
}