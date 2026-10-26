<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'alma@gmail.com'],
            [
                'name' => 'Admin Alma',
                'password' => Hash::make(
                    (string) env('ADMIN_PASSWORD', 'tokoalma2026!')
                ),
                'role' => 'admin',
            ]
        );
    }
}