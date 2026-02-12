<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => [
                    'en' => 'Air Conditioners',
                    'sr' => 'Klima uređaji',
                    'hu' => 'Légkondicionálók',
                ],
                'slug' => 'air-conditioners',
                'active' => true,
            ],
            [
                'name' => [
                    'en' => 'Heat Pumps',
                    'sr' => 'Toplotne pumpe',
                    'hu' => 'Hőszivattyúk',
                ],
                'slug' => 'heat-pumps',
                'active' => true,
            ],
            [
                'name' => [
                    'en' => 'Ventilation Systems',
                    'sr' => 'Ventilacioni sistemi',
                    'hu' => 'Szellőzőrendszerek',
                ],
                'slug' => 'ventilation-systems',
                'active' => true,
            ],
            [
                'name' => [
                    'en' => 'Boilers & Heating',
                    'sr' => 'Kotlovi i grejanje',
                    'hu' => 'Kazánok és fűtés',
                ],
                'slug' => 'boilers-heating',
                'active' => true,
            ],
            [
                'name' => [
                    'en' => 'Smart Thermostats',
                    'sr' => 'Pametni termostati',
                    'hu' => 'Intelligens termosztátok',
                ],
                'slug' => 'smart-thermostats',
                'active' => true,
            ],
            [
                'name' => [
                    'en' => 'Air Purifiers',
                    'sr' => 'Prečišćivači vazduha',
                    'hu' => 'Légtisztítók',
                ],
                'slug' => 'air-purifiers',
                'active' => true,
            ],
        ];

        foreach ($categories as $category) {
            ProductCategory::create($category);
        }
    }
}
