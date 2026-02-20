<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'farkas.tibor@ftherm.rs'],
            [
                'name' => 'Farkas Tibor',
                'email' => 'farkas.tibor@ftherm.rs',
                'password' => Hash::make('ftherm'),
                'is_admin' => true,
                'role' => 'worker',
                'is_active' => true,
                'email_verified_at' => now(),
                'permissions' => array_keys(\App\Models\User::getAvailablePermissions()),
            ]
        );
    }
}
