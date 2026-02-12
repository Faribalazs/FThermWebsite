<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $airConditioners = ProductCategory::where('slug', 'air-conditioners')->first();
        $heatPumps = ProductCategory::where('slug', 'heat-pumps')->first();
        $ventilation = ProductCategory::where('slug', 'ventilation-systems')->first();
        $boilers = ProductCategory::where('slug', 'boilers-heating')->first();
        $thermostats = ProductCategory::where('slug', 'smart-thermostats')->first();
        $purifiers = ProductCategory::where('slug', 'air-purifiers')->first();

        $products = [
            // Air Conditioners
            [
                'category_id' => $airConditioners->id,
                'name' => [
                    'en' => 'Inverter Split AC 12000 BTU',
                    'sr' => 'Inverter Split klima 12000 BTU',
                    'hu' => 'Inverteres Split klíma 12000 BTU',
                ],
                'description' => [
                    'en' => 'High-efficiency inverter split air conditioner with advanced cooling and heating functions. Energy class A++, quiet operation, WiFi control ready.',
                    'sr' => 'Visoko efikasan inverter split klima uređaj sa naprednim funkcijama hlađenja i grejanja. Energetska klasa A++, tiha rada, WiFi kontrola spremna.',
                    'hu' => 'Nagy hatékonyságú inverteres split légkondicionáló fejlett hűtő- és fűtőfunkciókkal. Energiaosztály A++, csendes működés, WiFi vezérlésre kész.',
                ],
                'technical_specs' => [
                    'en' => 'Cooling capacity: 12000 BTU/h, Heating capacity: 13000 BTU/h, Energy class: A++, Noise level: 19 dB, R32 refrigerant, WiFi ready',
                    'sr' => 'Kapacitet hlađenja: 12000 BTU/h, Kapacitet grejanja: 13000 BTU/h, Energetska klasa: A++, Nivo buke: 19 dB, R32 rashladno sredstvo, WiFi spreman',
                    'hu' => 'Hűtési kapacitás: 12000 BTU/h, Fűtési kapacitás: 13000 BTU/h, Energiaosztály: A++, Zajszint: 19 dB, R32 hűtőközeg, WiFi kész',
                ],
                'slug' => 'inverter-split-ac-12000-btu',
                'price' => 599.00,
                'active' => true,
                'order' => 1,
            ],
            [
                'category_id' => $airConditioners->id,
                'name' => [
                    'en' => 'Multi-Split System 2x9000 BTU',
                    'sr' => 'Multi-Split sistem 2x9000 BTU',
                    'hu' => 'Multi-Split rendszer 2x9000 BTU',
                ],
                'description' => [
                    'en' => 'Dual zone multi-split air conditioning system with two indoor units. Perfect for apartments or offices. Independent temperature control for each room.',
                    'sr' => 'Dvo-zonski multi-split klima sistem sa dve unutrašnje jedinice. Savršeno za stanove ili kancelarije. Nezavisna kontrola temperature za svaku prostoriju.',
                    'hu' => 'Kétzónás multi-split légkondicionáló rendszer két beltéri egységgel. Tökéletes lakásokhoz vagy irodákhoz. Független hőmérséklet-szabályozás minden helyiségben.',
                ],
                'technical_specs' => [
                    'en' => '2 indoor units 9000 BTU each, Total capacity: 18000 BTU, Energy class: A++, Inverter technology, R32 refrigerant',
                    'sr' => '2 unutrašnje jedinice po 9000 BTU, Ukupan kapacitet: 18000 BTU, Energetska klasa: A++, Inverter tehnologija, R32 rashladno sredstvo',
                    'hu' => '2 beltéri egység egyenként 9000 BTU, Teljes kapacitás: 18000 BTU, Energiaosztály: A++, Inverter technológia, R32 hűtőközeg',
                ],
                'slug' => 'multi-split-system-2x9000-btu',
                'price' => 1299.00,
                'active' => true,
                'order' => 2,
            ],
            [
                'category_id' => $airConditioners->id,
                'name' => [
                    'en' => 'Portable AC 9000 BTU',
                    'sr' => 'Prenosivi klima uređaj 9000 BTU',
                    'hu' => 'Hordozható klíma 9000 BTU',
                ],
                'description' => [
                    'en' => 'Mobile air conditioner with dehumidifier function. Easy to move between rooms. No installation required, just plug and play.',
                    'sr' => 'Mobilni klima uređaj sa funkcijom odvlaživanja. Lako se prenosi između prostorija. Nije potrebna instalacija, samo priključite i koristite.',
                    'hu' => 'Mobil légkondicionáló párátlanító funkcióval. Könnyen mozgatható a szobák között. Telepítés nem szükséges, csak dugja be és használja.',
                ],
                'technical_specs' => [
                    'en' => 'Cooling capacity: 9000 BTU, Dehumidifying: 30L/day, Energy class: A, Noise level: 52 dB, Remote control included',
                    'sr' => 'Kapacitet hlađenja: 9000 BTU, Odvlaživanje: 30L/dan, Energetska klasa: A, Nivo buke: 52 dB, Daljinski upravljač uključen',
                    'hu' => 'Hűtési kapacitás: 9000 BTU, Párátlanítás: 30L/nap, Energiaosztály: A, Zajszint: 52 dB, Távirányító mellékelve',
                ],
                'slug' => 'portable-ac-9000-btu',
                'price' => 399.00,
                'active' => true,
                'order' => 3,
            ],

            // Heat Pumps
            [
                'category_id' => $heatPumps->id,
                'name' => [
                    'en' => 'Air-to-Water Heat Pump 12kW',
                    'sr' => 'Vazduh-voda toplotna pumpa 12kW',
                    'hu' => 'Levegő-víz hőszivattyú 12kW',
                ],
                'description' => [
                    'en' => 'High-efficiency air-to-water heat pump for heating and domestic hot water. Works efficiently even at -20°C outside temperature. Ideal for underfloor heating systems.',
                    'sr' => 'Visoko efikasna vazduh-voda toplotna pumpa za grejanje i toplu upotrebnu vodu. Efikasno radi čak i na -20°C spoljašnje temperature. Idealna za sisteme podnog grejanja.',
                    'hu' => 'Nagy hatékonyságú levegő-víz hőszivattyú fűtéshez és használati melegvízhez. Hatékonyan működik még -20°C külső hőmérsékleten is. Ideális padlófűtő rendszerekhez.',
                ],
                'technical_specs' => [
                    'en' => 'Heating capacity: 12kW, COP: 4.5, Working range: -20°C to +35°C, Energy class: A+++, R410A refrigerant, Smart control',
                    'sr' => 'Kapacitet grejanja: 12kW, COP: 4.5, Radni opseg: -20°C do +35°C, Energetska klasa: A+++, R410A rashladno sredstvo, Pametna kontrola',
                    'hu' => 'Fűtési teljesítmény: 12kW, COP: 4.5, Működési tartomány: -20°C-tól +35°C-ig, Energiaosztály: A+++, R410A hűtőközeg, Intelligens vezérlés',
                ],
                'slug' => 'air-to-water-heat-pump-12kw',
                'price' => 4500.00,
                'active' => true,
                'order' => 4,
            ],
            [
                'category_id' => $heatPumps->id,
                'name' => [
                    'en' => 'Ground Source Heat Pump 15kW',
                    'sr' => 'Geotermalna toplotna pumpa 15kW',
                    'hu' => 'Geotermikus hőszivattyú 15kW',
                ],
                'description' => [
                    'en' => 'Ground source heat pump with excellent efficiency. Uses stable ground temperature for heating and cooling. Low operating costs and minimal environmental impact.',
                    'sr' => 'Geotermalna toplotna pumpa sa odličnom efikasnošću. Koristi stabilnu temperaturu zemljišta za grejanje i hlađenje. Niski operativni troškovi i minimalan uticaj na životnu sredinu.',
                    'hu' => 'Geotermikus hőszivattyú kiváló hatékonysággal. Stabil talajhőmérsékletet használ fűtéshez és hűtéshez. Alacsony működési költségek és minimális környezeti hatás.',
                ],
                'technical_specs' => [
                    'en' => 'Heating capacity: 15kW, Cooling capacity: 12kW, COP: 5.2, Energy class: A+++, Reversible operation',
                    'sr' => 'Kapacitet grejanja: 15kW, Kapacitet hlađenja: 12kW, COP: 5.2, Energetska klasa: A+++, Reverzibilna izvedba',
                    'hu' => 'Fűtési teljesítmény: 15kW, Hűtési teljesítmény: 12kW, COP: 5.2, Energiaosztály: A+++, Reverzibilis működés',
                ],
                'slug' => 'ground-source-heat-pump-15kw',
                'price' => 8900.00,
                'active' => true,
                'order' => 5,
            ],

            // Ventilation Systems
            [
                'category_id' => $ventilation->id,
                'name' => [
                    'en' => 'Heat Recovery Ventilation Unit 300m³/h',
                    'sr' => 'Ventilaciona jedinica sa rekuperacijom 300m³/h',
                    'hu' => 'Hővisszanyerős szellőző egység 300m³/óra',
                ],
                'description' => [
                    'en' => 'Energy-efficient ventilation system with heat recovery. Recovers up to 95% of heat from exhaust air. Ensures fresh air while minimizing energy loss.',
                    'sr' => 'Energetski efikasan ventilacioni sistem sa rekuperacijom toplote. Vraća do 95% toplote iz izduvnog vazduha. Obezbeđuje svež vazduh uz minimalan gubitak energije.',
                    'hu' => 'Energiahatékony szellőzőrendszer hővisszanyeréssel. Az elszívott levegő hőjének akár 95%-át visszanyeri. Friss levegőt biztosít minimális energiaveszteséggel.',
                ],
                'technical_specs' => [
                    'en' => 'Airflow: 300m³/h, Heat recovery: 95%, Filters: F7/G4, Energy class: A+, Noise level: 28 dB, Smart control',
                    'sr' => 'Protok vazduha: 300m³/h, Rekuperacija toplote: 95%, Filteri: F7/G4, Energetska klasa: A+, Nivo buke: 28 dB, Pametna kontrola',
                    'hu' => 'Légáramlás: 300m³/óra, Hővisszanyerés: 95%, Szűrők: F7/G4, Energiaosztály: A+, Zajszint: 28 dB, Intelligens vezérlés',
                ],
                'slug' => 'heat-recovery-ventilation-300m3h',
                'price' => 1890.00,
                'active' => true,
                'order' => 6,
            ],

            // Boilers & Heating
            [
                'category_id' => $boilers->id,
                'name' => [
                    'en' => 'Condensing Gas Boiler 24kW',
                    'sr' => 'Kondenzacioni gasni kotao 24kW',
                    'hu' => 'Kondenzációs gázkazán 24kW',
                ],
                'description' => [
                    'en' => 'Modern condensing gas boiler with high efficiency. Suitable for heating and hot water preparation. Low emissions and quiet operation.',
                    'sr' => 'Moderan kondenzacioni gasni kotao sa visokom efikasnošću. Pogodan za grejanje i pripremu tople vode. Niske emisije i tiha rada.',
                    'hu' => 'Modern kondenzációs gázkazán magas hatásfokkal. Alkalmas fűtéshez és melegvíz-előállításhoz. Alacsony károsanyag-kibocsátás és csendes működés.',
                ],
                'technical_specs' => [
                    'en' => 'Power: 24kW, Efficiency: 98%, Gas type: Natural gas/LPG, Energy class: A, Modulating burner, Digital display',
                    'sr' => 'Snaga: 24kW, Efikasnost: 98%, Tip gasa: Zemni gas/TNG, Energetska klasa: A, Modulišuća goriva, Digitalni displej',
                    'hu' => 'Teljesítmény: 24kW, Hatásfok: 98%, Gáztípus: Földgáz/PB gáz, Energiaosztály: A, Moduláló égő, Digitális kijelző',
                ],
                'slug' => 'condensing-gas-boiler-24kw',
                'price' => 1650.00,
                'active' => true,
                'order' => 7,
            ],

            // Smart Thermostats
            [
                'category_id' => $thermostats->id,
                'name' => [
                    'en' => 'WiFi Smart Thermostat Pro',
                    'sr' => 'WiFi Pametni termostat Pro',
                    'hu' => 'WiFi Intelligens termosztát Pro',
                ],
                'description' => [
                    'en' => 'Advanced smart thermostat with WiFi connectivity, learning algorithms, and energy monitoring. Control via smartphone app from anywhere. Compatible with Alexa and Google Home.',
                    'sr' => 'Napredni pametni termostat sa WiFi konektivnošću, algoritmima učenja i praćenjem energije. Kontrola putem mobilne aplikacije sa bilo kog mesta. Kompatibilan sa Alexa i Google Home.',
                    'hu' => 'Fejlett intelligens termosztát WiFi-kapcsolattal, tanuló algoritmusokkal és energiamonitorozással. Vezérlés okostelefonos alkalmazással bárhonnan. Kompatibilis Alexa-val és Google Home-mal.',
                ],
                'technical_specs' => [
                    'en' => 'Display: Color touchscreen, Connectivity: WiFi 2.4GHz, Control: Smartphone app, Voice control, Learning mode, Energy reports',
                    'sr' => 'Displej: Ekran osetljiv na dodir u boji, Povezivanje: WiFi 2.4GHz, Kontrola: Mobilna aplikacija, Glasovna kontrola, Režim učenja, Izveštaji o energiji',
                    'hu' => 'Kijelző: Színes érintőképernyő, Kapcsolat: WiFi 2.4GHz, Vezérlés: Okostelefon alkalmazás, Hangvezérlés, Tanuló mód, Energiajelentések',
                ],
                'slug' => 'wifi-smart-thermostat-pro',
                'price' => 249.00,
                'active' => true,
                'order' => 8,
            ],

            // Air Purifiers
            [
                'category_id' => $purifiers->id,
                'name' => [
                    'en' => 'HEPA Air Purifier 500m³/h',
                    'sr' => 'HEPA prečišćivač vazduha 500m³/h',
                    'hu' => 'HEPA légtisztító 500m³/óra',
                ],
                'description' => [
                    'en' => 'Professional air purifier with True HEPA H13 filter, activated carbon, and UV-C sterilization. Removes 99.97% of particles, allergens, bacteria, and viruses. Perfect for homes and offices.',
                    'sr' => 'Profesionalni prečišćivač vazduha sa True HEPA H13 filterom, aktivnim ugljem i UV-C sterilizacijom. Uklanja 99,97% čestica, alergena, bakterija i virusa. Savršeno za domove i kancelarije.',
                    'hu' => 'Professzionális légtisztító True HEPA H13 szűrővel, aktív szénnel és UV-C sterilizációval. 99,97%-ban eltávolítja a részecskéket, allergéneket, baktériumokat és vírusokat. Tökéletes otthonokhoz és irodákhoz.',
                ],
                'technical_specs' => [
                    'en' => 'Coverage area: 60m², CADR: 500m³/h, Filters: Pre-filter + HEPA H13 + Activated Carbon + UV-C, Noise: 22-54 dB, Air quality sensor',
                    'sr' => 'Pokrivenost: 60m², CADR: 500m³/h, Filteri: Predfilter + HEPA H13 + Aktivni ugalj + UV-C, Buka: 22-54 dB, Senzor kvaliteta vazduha',
                    'hu' => 'Lefedett terület: 60m², CADR: 500m³/óra, Szűrők: Előszűrő + HEPA H13 + Aktív szén + UV-C, Zaj: 22-54 dB, Levegőminőség érzékelő',
                ],
                'slug' => 'hepa-air-purifier-500m3h',
                'price' => 459.00,
                'active' => true,
                'order' => 9,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
