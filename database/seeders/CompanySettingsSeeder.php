<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class CompanySettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'company_name' => 'Tibor Farkaš PR FTherm SZR',
            'company_address' => 'Nadežde Petrović 6 Subotica',
            'company_pib' => '110054333',
            'company_maticni_broj' => '64615327',
            'company_bank_account' => '165-7007689513-11',
            'company_phone' => '+381641391360',
            'company_email' => 'farkas.tibor@ftherm.rs',
            'company_sifra_delatnosti' => '4322',
            'km_price' => '50',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $this->command->info('Company settings seeded successfully!');
    }
}
