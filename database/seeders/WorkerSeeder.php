<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class WorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $workers = [
            [
                'name' => 'Farkas Tibor',
                'email' => 'farkas.tibor@ftherm.rs',
                'password' => Hash::make('ftherm'),
                'is_admin' => false,
                'role' => 'worker',
                'is_active' => true,
                'email_verified_at' => now(),
                'permissions' => array_keys(\App\Models\User::getAvailablePermissions()),
            ],
            [
                'name' => 'Worker Two',
                'email' => 'worker2@ftherm.rs',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'role' => 'worker',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Worker Three',
                'email' => 'worker3@ftherm.rs',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'role' => 'worker',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
        ];

        foreach ($workers as $worker) {
            User::firstOrCreate(
                ['email' => $worker['email']],
                $worker
            );
        }
    }
}
