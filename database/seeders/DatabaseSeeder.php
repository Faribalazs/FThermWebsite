<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            HomepageContentSeeder::class,
            ServiceSeeder::class,
            ProductCategorySeeder::class,
            ProductSeeder::class,
            WorkerSeeder::class,
            WarehouseSeeder::class,
            MaterialSeeder::class,
            CompanySettingsSeeder::class,
            ContactSeeder::class,
        ]);
    }
}
