<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutPage extends Model
{
    protected $fillable = [
        'key',
        'eyebrow',
        'title',
        'intro',
        'body',
        'secondary_title',
        'secondary_body',
        'values_title',
        'values',
        'stats',
        'hero_image',
        'hero_image_alt',
        'secondary_image',
        'secondary_image_alt',
        'seo_title',
        'seo_description',
    ];

    protected $casts = [
        'eyebrow' => 'array',
        'title' => 'array',
        'intro' => 'array',
        'body' => 'array',
        'secondary_title' => 'array',
        'secondary_body' => 'array',
        'values_title' => 'array',
        'values' => 'array',
        'stats' => 'array',
        'hero_image_alt' => 'array',
        'secondary_image_alt' => 'array',
        'seo_title' => 'array',
        'seo_description' => 'array',
    ];

    public static function defaultContent(): array
    {
        return [
            'key' => 'main',
            'eyebrow' => [
                'sr' => 'FTHERM tim',
                'en' => 'FTHERM team',
                'hu' => 'FTHERM csapat',
            ],
            'title' => [
                'sr' => 'Pouzdana tehnička rešenja za komfor koji traje',
                'en' => 'Reliable technical solutions for comfort that lasts',
                'hu' => 'Megbízható műszaki megoldások tartós komfortra',
            ],
            'intro' => [
                'sr' => 'FTHERM povezuje hlađenje, grejanje, vodoinstalacije i rashladnu tehniku u jasna, uredno izvedena rešenja za domove i poslovne prostore.',
                'en' => 'FTHERM brings cooling, heating, plumbing and refrigeration together into clear, neatly delivered solutions for homes and business spaces.',
                'hu' => 'Az FTHERM a hűtést, fűtést, vízszerelést és hűtéstechnikát átlátható, rendezett megoldásokká kapcsolja össze otthonok és üzleti terek számára.',
            ],
            'body' => [
                'sr' => '<p>Naš pristup počinje razumevanjem prostora, navika korišćenja i tehničkih ograničenja. Umesto brzih, površnih rešenja, biramo sisteme koji imaju smisla za konkretan objekat, budžet i dugoročno održavanje.</p><p>Radimo sa klima uređajima, toplotnim pumpama, podnim i zidnim grejanjem, radijatorima, vodoinstalacijama i rashladnim komorama. Svaki posao vodimo kroz jasnu komunikaciju, preciznu pripremu i završnu proveru sistema.</p>',
                'en' => '<p>Our approach starts with understanding the space, how it is used and the technical limits of the installation. Instead of quick surface-level fixes, we choose systems that make sense for the building, the budget and long-term maintenance.</p><p>We work with air conditioning, heat pumps, underfloor and wall heating, radiators, plumbing and cold rooms. Every project is managed through clear communication, precise preparation and a final system check.</p>',
                'hu' => '<p>A munkát mindig a helyszín, a használati szokások és a műszaki korlátok megértésével kezdjük. Gyors, felszínes megoldások helyett olyan rendszereket választunk, amelyek az adott épülethez, költségkerethez és hosszú távú karbantartáshoz illeszkednek.</p><p>Klímákkal, hőszivattyúkkal, padló- és falfűtéssel, radiátorokkal, vízszereléssel és hűtőkamrákkal dolgozunk. Minden projektet érthető kommunikációval, pontos előkészítéssel és végső rendszerellenőrzéssel zárunk.</p>',
            ],
            'secondary_title' => [
                'sr' => 'Preciznost se vidi u detaljima',
                'en' => 'Precision is visible in the details',
                'hu' => 'A precizitás a részletekben látszik',
            ],
            'secondary_body' => [
                'sr' => 'Uredne instalacije, pravilno dimenzionisani sistemi i čisto završeni radovi čine razliku između privremenog rešenja i komfora na koji možete da se oslonite godinama.',
                'en' => 'Tidy installations, correctly sized systems and clean finishing make the difference between a temporary fix and comfort you can rely on for years.',
                'hu' => 'A rendezett szerelés, a jól méretezett rendszerek és a tiszta kivitelezés választja el az ideiglenes megoldást az éveken át megbízható komforttól.',
            ],
            'values_title' => [
                'sr' => 'Kako FTHERM radi',
                'en' => 'How FTHERM works',
                'hu' => 'Hogyan dolgozik az FTHERM',
            ],
            'values' => [
                [
                    'title' => [
                        'sr' => 'Jasan dogovor',
                        'en' => 'Clear agreement',
                        'hu' => 'Átlátható egyeztetés',
                    ],
                    'text' => [
                        'sr' => 'Pre početka rada definišemo obim, mogućnosti, rokove i naredne korake.',
                        'en' => 'Before work begins, we define the scope, options, timeline and next steps.',
                        'hu' => 'A munka előtt rögzítjük a feladatot, a lehetőségeket, a határidőket és a következő lépéseket.',
                    ],
                ],
                [
                    'title' => [
                        'sr' => 'Tehnička logika',
                        'en' => 'Technical logic',
                        'hu' => 'Műszaki logika',
                    ],
                    'text' => [
                        'sr' => 'Sistem biramo prema prostoru, opterećenju, načinu korišćenja i dugoročnoj ekonomičnosti.',
                        'en' => 'We choose the system according to the space, load, usage pattern and long-term efficiency.',
                        'hu' => 'A rendszert a tér, a terhelés, a használat és a hosszú távú gazdaságosság alapján választjuk ki.',
                    ],
                ],
                [
                    'title' => [
                        'sr' => 'Uredna izvedba',
                        'en' => 'Tidy execution',
                        'hu' => 'Rendezett kivitelezés',
                    ],
                    'text' => [
                        'sr' => 'Vodimo računa o estetici, bezbednosti, čistom radnom prostoru i završnoj proveri.',
                        'en' => 'We care about aesthetics, safety, a clean work area and the final system check.',
                        'hu' => 'Ügyelünk az esztétikára, biztonságra, tiszta munkaterületre és a végső ellenőrzésre.',
                    ],
                ],
                [
                    'title' => [
                        'sr' => 'Podrška posle radova',
                        'en' => 'Support after the work',
                        'hu' => 'Támogatás a munka után',
                    ],
                    'text' => [
                        'sr' => 'Objašnjavamo korišćenje, održavanje i kada je najbolje planirati sledeću proveru.',
                        'en' => 'We explain usage, maintenance and when to plan the next inspection.',
                        'hu' => 'Elmagyarázzuk a használatot, karbantartást és a következő ellenőrzés idejét.',
                    ],
                ],
            ],
            'stats' => [
                [
                    'value' => '01',
                    'label' => [
                        'sr' => 'Analiza prostora',
                        'en' => 'Space analysis',
                        'hu' => 'Helyszíni elemzés',
                    ],
                ],
                [
                    'value' => '02',
                    'label' => [
                        'sr' => 'Precizna ponuda',
                        'en' => 'Precise quote',
                        'hu' => 'Pontos ajánlat',
                    ],
                ],
                [
                    'value' => '03',
                    'label' => [
                        'sr' => 'Čista izvedba',
                        'en' => 'Clean execution',
                        'hu' => 'Tiszta kivitelezés',
                    ],
                ],
            ],
            'hero_image' => 'images/ftherm/about/ftherm-about-hero-team.png',
            'hero_image_alt' => [
                'sr' => 'FTHERM tehničari proveravaju instalaciju grejanja i hlađenja',
                'en' => 'FTHERM technicians checking a heating and cooling installation',
                'hu' => 'FTHERM technikusok fűtési és hűtési rendszert ellenőriznek',
            ],
            'secondary_image' => 'images/ftherm/about/ftherm-about-technical-detail.png',
            'secondary_image_alt' => [
                'sr' => 'Uredno izvedeni tehnički detalji instalacije grejanja',
                'en' => 'Neatly finished technical details of a heating installation',
                'hu' => 'Rendezett fűtési rendszer műszaki részletei',
            ],
            'seo_title' => [
                'sr' => 'O nama - FTHERM',
                'en' => 'About us - FTHERM',
                'hu' => 'Rólunk - FTHERM',
            ],
            'seo_description' => [
                'sr' => 'Upoznajte FTHERM, tim za hlađenje, grejanje, vodoinstalacije, toplotne pumpe i rashladnu tehniku za domove i poslovne prostore.',
                'en' => 'Meet FTHERM, a team for cooling, heating, plumbing, heat pumps and refrigeration technology for homes and business spaces.',
                'hu' => 'Ismerje meg az FTHERM-et: hűtés, fűtés, vízszerelés, hőszivattyúk és hűtéstechnika otthonoknak és üzleti tereknek.',
            ],
        ];
    }
}
