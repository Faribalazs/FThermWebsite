<?php

namespace Database\Seeders;

use App\Models\Slide;
use Illuminate\Database\Seeder;

class SlideSeeder extends Seeder
{
    public function run(): void
    {
        $slides = [
            [
                'image'           => 'images/ftherm/slider/ac-installation-hero.webp',
                'title'           => [
                    'sr' => 'Kompletna rešenja za grejanje i hlađenje',
                    'en' => 'Complete heating and cooling solutions',
                    'hu' => 'Komplett hűtés-fűtés megoldások',
                ],
                'description'     => [
                    'sr' => 'Ugradnja klima uređaja, servis, čišćenje, toplotne pumpe i tehničke instalacije za domove i poslovne prostore.',
                    'en' => 'Air conditioning, service, cleaning, heat pumps and technical installations for homes and business spaces.',
                    'hu' => 'Klímaszerelés, szerviz, tisztítás, hőszivattyúk és műszaki rendszerek otthonoknak és vállalkozásoknak.',
                ],
                'button_text'     => [
                    'sr' => 'Zatražite ponudu',
                    'en' => 'Request a Quote',
                    'hu' => 'Ajánlatot kérek',
                ],
                'button_link'     => '#contact',
                'text_position_x' => 'left',
                'text_position_y' => 'center',
                'order'           => 1,
                'active'          => true,
            ],
            [
                'image'           => 'images/ftherm/slider/heat-pump-hero.webp',
                'title'           => [
                    'sr' => 'Toplotne pumpe i moderni sistemi',
                    'en' => 'Heat pumps and modern systems',
                    'hu' => 'Hőszivattyúk és modern rendszerek',
                ],
                'description'     => [
                    'sr' => 'Planiranje i izvođenje sistema koji kombinuju udobnost, pouzdanost i ekonomičan rad tokom cele godine.',
                    'en' => 'Planning and installation of systems built for comfort, reliability and efficient year-round operation.',
                    'hu' => 'Kényelmes, megbízható és takarékos működésre tervezett rendszerek tervezése és kivitelezése.',
                ],
                'button_text'     => [
                    'sr' => 'Zatražite ponudu',
                    'en' => 'Request a Quote',
                    'hu' => 'Ajánlatot kérek',
                ],
                'button_link'     => '#contact',
                'text_position_x' => 'left',
                'text_position_y' => 'center',
                'order'           => 2,
                'active'          => true,
            ],
            [
                'image'           => 'images/ftherm/slider/technical-systems-hero.webp',
                'title'           => [
                    'sr' => 'Precizne tehničke instalacije',
                    'en' => 'Precise technical installations',
                    'hu' => 'Precíz műszaki kivitelezés',
                ],
                'description'     => [
                    'sr' => 'Grejanje, vodoinstalacije, razvod, rashladna tehnika i održavanje izvedeni uredno i pregledno.',
                    'en' => 'Heating, plumbing, pipework, refrigeration and maintenance delivered cleanly and transparently.',
                    'hu' => 'Fűtés, vízszerelés, csövezés, hűtéstechnika és karbantartás rendezett kivitelezéssel.',
                ],
                'button_text'     => [
                    'sr' => 'Naše usluge',
                    'en' => 'Our Services',
                    'hu' => 'Szolgáltatásaink',
                ],
                'button_link'     => '#services',
                'text_position_x' => 'left',
                'text_position_y' => 'center',
                'order'           => 3,
                'active'          => true,
            ],
        ];

        foreach ($slides as $data) {
            Slide::updateOrCreate(
                ['order' => $data['order']],
                $data
            );
        }
    }
}
