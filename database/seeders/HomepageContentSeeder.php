<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HomepageContent;

class HomepageContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contents = [
            [
                'key' => 'hero_title',
                'value' => [
                    'en' => 'Modern Heating Solutions',
                    'sr' => 'Moderna Rešenja za Grejanje',
                    'hu' => 'Modern Fűtési Megoldások',
                ],
            ],
            [
                'key' => 'hero_subtitle',
                'value' => [
                    'en' => 'Professional installation of heat pumps and HVAC systems',
                    'sr' => 'Profesionalna ugradnja toplotnih pumpi i HVAC sistema',
                    'hu' => 'Hőszivattyúk és HVAC rendszerek szakszerű telepítése',
                ],
            ],
            [
                'key' => 'hero_cta',
                'value' => [
                    'en' => 'Request Offer',
                    'sr' => 'Zatražite Ponudu',
                    'hu' => 'Ajánlatkérés',
                ],
            ],
            [
                'key' => 'why_us_experience_title',
                'value' => [
                    'en' => 'Years of Experience',
                    'sr' => 'Godine Iskustva',
                    'hu' => 'Több év tapasztalat',
                ],
            ],
            [
                'key' => 'why_us_experience_text',
                'value' => [
                    'en' => 'Professional team with extensive HVAC expertise',
                    'sr' => 'Profesionalan tim sa velikim iskustvom u HVAC sistemima',
                    'hu' => 'Szakképzett csapat nagy HVAC tapasztalattal',
                ],
            ],
        ];

        foreach ($contents as $content) {
            HomepageContent::create($content);
        }
    }
}
