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
                'image'           => 'images/slider/slide1.jpg',
                'title'           => [
                    'sr' => 'Profesionalna HVAC Rešenja',
                    'en' => 'Professional HVAC Solutions',
                    'hu' => 'Professzionális HVAC Megoldások',
                ],
                'description'     => [
                    'sr' => 'Stručna montaža toplotnih pumpi i sistema grejanja za vaš dom i poslovni prostor.',
                    'en' => 'Expert installation of heat pumps and heating systems for your home and business.',
                    'hu' => 'Szakszerű hőszivattyú és fűtési rendszer telepítés otthonába és üzlethelyiségébe.',
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
                'image'           => 'images/slider/slide2.jpg',
                'title'           => [
                    'sr' => 'Energetski Efikasni Sistemi',
                    'en' => 'Energy Efficient Systems',
                    'hu' => 'Energiahatékony Rendszerek',
                ],
                'description'     => [
                    'sr' => 'Smanjite troškove energije uz naše moderne, ekološki prihvatljive HVAC sisteme.',
                    'en' => 'Reduce your energy costs with our modern, eco-friendly HVAC systems.',
                    'hu' => 'Csökkentse energiaköltségeit korszerű, környezetbarát HVAC rendszereinkkel.',
                ],
                'button_text'     => [
                    'sr' => 'Pogledajte proizvode',
                    'en' => 'View Products',
                    'hu' => 'Termékek megtekintése',
                ],
                'button_link'     => '/sr/shop',
                'text_position_x' => 'left',
                'text_position_y' => 'bottom',
                'order'           => 2,
                'active'          => true,
            ],
            [
                'image'           => 'images/slider/slide3.jpg',
                'title'           => [
                    'sr' => 'Servis i Održavanje',
                    'en' => 'Service & Maintenance',
                    'hu' => 'Szerviz és Karbantartás',
                ],
                'description'     => [
                    'sr' => 'Brz i pouzdan servis vaših uređaja od strane naših iskusnih tehničara.',
                    'en' => 'Fast and reliable service for your equipment by our experienced technicians.',
                    'hu' => 'Gyors és megbízható szerviz tapasztalt technikusainktól.',
                ],
                'button_text'     => [
                    'sr' => 'Naše usluge',
                    'en' => 'Our Services',
                    'hu' => 'Szolgáltatásaink',
                ],
                'button_link'     => '#services',
                'text_position_x' => 'right',
                'text_position_y' => 'bottom',
                'order'           => 3,
                'active'          => true,
            ],
        ];

        foreach ($slides as $data) {
            Slide::create($data);
        }
    }
}
