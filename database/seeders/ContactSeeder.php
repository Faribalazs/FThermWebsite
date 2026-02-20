<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;
use App\Models\User;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $worker = User::where('role', 'worker')->first();

        if (!$worker) {
            $worker = User::first();
        }

        Contact::updateOrCreate(
            [
                'created_by' => $worker->id,
                'type' => 'fizicko_lice',
                'client_name' => 'Petar Petrović',
            ],
            [
                'client_address' => 'Nikole Tesle 15, Novi Sad',
                'client_phone' => '+381641234567',
                'client_email' => 'petar.petrovic@example.com',
            ]
        );

        Contact::updateOrCreate(
            [
                'created_by' => $worker->id,
                'type' => 'pravno_lice',
                'company_name' => 'TechBuild DOO',
            ],
            [
                'client_name' => 'Marko Marković',
                'client_address' => 'Bulevar Oslobođenja 42, Subotica',
                'client_phone' => '+381637654321',
                'client_email' => 'marko@techbuild.rs',
                'company_address' => 'Bulevar Oslobođenja 42, Subotica',
                'pib' => '112233445',
                'maticni_broj' => '12345678',
            ]
        );

        $this->command->info('Test contacts seeded successfully!');
    }
}
