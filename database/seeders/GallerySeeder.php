<?php

namespace Database\Seeders;

use App\Models\GalleryAlbum;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $album = GalleryAlbum::create([
            'title' => [
                'sr' => 'Montaža toplotnih pumpi 2025',
                'en' => 'Heat Pump Installations 2025',
                'hu' => 'Hőszivattyú telepítések 2025',
            ],
            'description' => [
                'sr' => 'Galerija fotografija sa naših projekata montaže toplotnih pumpi tokom 2025. godine. Prikazujemo stambene i komercijalne instalacije širom regiona.',
                'en' => 'Photo gallery from our heat pump installation projects during 2025. Featuring residential and commercial installations across the region.',
                'hu' => 'Fotógaléria a hőszivattyú telepítési projektjeinkről 2025-ben. Lakóépületi és kereskedelmi telepítések a régióban.',
            ],
            'slug'   => 'montaza-toplotnih-pumpi-2025',
            'active' => true,
            'order'  => 1,
        ]);
    }
}
