<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\InternalProduct;
use App\Models\User;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first worker user as the creator
        $worker = User::where('role', 'worker')->first();
        
        if (!$worker) {
            // If no worker exists, get first user
            $worker = User::first();
        }

        $materials = [
            // Copper Pipes
            [
                'name' => 'Bakarna cev 1/4"',
                'unit' => 'm',
                'price' => 450.00,
                'low_stock_threshold' => 50,
            ],
            [
                'name' => 'Bakarna cev 3/8"',
                'unit' => 'm',
                'price' => 650.00,
                'low_stock_threshold' => 50,
            ],
            [
                'name' => 'Bakarna cev 1/2"',
                'unit' => 'm',
                'price' => 850.00,
                'low_stock_threshold' => 40,
            ],
            [
                'name' => 'Bakarna cev 5/8"',
                'unit' => 'm',
                'price' => 1100.00,
                'low_stock_threshold' => 30,
            ],
            [
                'name' => 'Bakarna cev 3/4"',
                'unit' => 'm',
                'price' => 1350.00,
                'low_stock_threshold' => 30,
            ],

            // Insulation
            [
                'name' => 'Izolacija za cev 1/4" (6mm)',
                'unit' => 'm',
                'price' => 120.00,
                'low_stock_threshold' => 100,
            ],
            [
                'name' => 'Izolacija za cev 3/8" (9mm)',
                'unit' => 'm',
                'price' => 150.00,
                'low_stock_threshold' => 100,
            ],
            [
                'name' => 'Izolacija za cev 1/2" (13mm)',
                'unit' => 'm',
                'price' => 200.00,
                'low_stock_threshold' => 80,
            ],

            // Fittings and Connectors
            [
                'name' => 'Konus 1/4"',
                'unit' => 'kom',
                'price' => 80.00,
                'low_stock_threshold' => 50,
            ],
            [
                'name' => 'Konus 3/8"',
                'unit' => 'kom',
                'price' => 100.00,
                'low_stock_threshold' => 50,
            ],
            [
                'name' => 'Konus 1/2"',
                'unit' => 'kom',
                'price' => 120.00,
                'low_stock_threshold' => 40,
            ],
            [
                'name' => 'Navrtak za bakar 1/4"',
                'unit' => 'kom',
                'price' => 60.00,
                'low_stock_threshold' => 60,
            ],
            [
                'name' => 'Navrtak za bakar 3/8"',
                'unit' => 'kom',
                'price' => 75.00,
                'low_stock_threshold' => 60,
            ],

            // Valves
            [
                'name' => 'Servisni ventil 1/4"',
                'unit' => 'kom',
                'price' => 850.00,
                'low_stock_threshold' => 10,
            ],
            [
                'name' => 'Servisni ventil 3/8"',
                'unit' => 'kom',
                'price' => 950.00,
                'low_stock_threshold' => 10,
            ],

            // Refrigerants
            [
                'name' => 'Freon R410A (11.3kg)',
                'unit' => 'kom',
                'price' => 18500.00,
                'low_stock_threshold' => 3,
            ],
            [
                'name' => 'Freon R32 (10kg)',
                'unit' => 'kom',
                'price' => 16000.00,
                'low_stock_threshold' => 3,
            ],

            // Installation Materials
            [
                'name' => 'PVC kanal 60x60mm',
                'unit' => 'm',
                'price' => 320.00,
                'low_stock_threshold' => 20,
            ],
            [
                'name' => 'Drenažna cev 16mm',
                'unit' => 'm',
                'price' => 85.00,
                'low_stock_threshold' => 50,
            ],
            [
                'name' => 'Nosač za spoljnu jedinicu',
                'unit' => 'kom',
                'price' => 2200.00,
                'low_stock_threshold' => 5,
            ],
        ];

        foreach ($materials as $material) {
            InternalProduct::firstOrCreate(
                ['name' => $material['name']],
                [
                    'unit' => $material['unit'],
                    'price' => $material['price'],
                    'low_stock_threshold' => $material['low_stock_threshold'],
                    'created_by' => $worker->id,
                ]
            );
        }
    }
}
