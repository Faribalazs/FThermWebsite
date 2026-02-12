<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'title' => [
                    'en' => 'Air Conditioning Installation',
                    'sr' => 'Ugradnja klima uređaja',
                    'hu' => 'Légkondicionáló telepítés',
                ],
                'description' => [
                    'en' => 'Professional installation of air conditioning systems for residential and commercial spaces. We handle all types of AC units including split systems, multi-split systems, and VRF systems.',
                    'sr' => 'Profesionalna ugradnja klima uređaja za stambene i poslovne prostore. Radimo sa svim tipovima klima uređaja uključujući split sisteme, multi-split sisteme i VRF sisteme.',
                    'hu' => 'Légkondicionáló rendszerek szakszerű telepítése lakó- és kereskedelmi helyiségekbe. Minden típusú klímaberendezéssel foglalkozunk, beleértve a split rendszereket, multi-split rendszereket és VRF rendszereket.',
                ],
                'icon' => '❄️',
                'order' => 1,
                'active' => true,
            ],
            [
                'title' => [
                    'en' => 'Heating Systems',
                    'sr' => 'Sistem grejanja',
                    'hu' => 'Fűtési rendszerek',
                ],
                'description' => [
                    'en' => 'Complete heating solutions including boiler installation, radiator systems, underfloor heating, and heat pump systems. Energy-efficient solutions for your comfort.',
                    'sr' => 'Kompletna rešenja za grejanje uključujući ugradnju kotlova, radijatorskih sistema, podnog grejanja i toplotnih pumpi. Energetski efikasna rešenja za vašu udobnost.',
                    'hu' => 'Teljes fűtési megoldások, beleértve a kazántelepítést, radiátorrendszereket, padlófűtést és hőszivattyús rendszereket. Energiahatékony megoldások az Ön kényelmére.',
                ],
                'icon' => '🔥',
                'order' => 2,
                'active' => true,
            ],
            [
                'title' => [
                    'en' => 'Ventilation Systems',
                    'sr' => 'Ventilacioni sistemi',
                    'hu' => 'Szellőzőrendszerek',
                ],
                'description' => [
                    'en' => 'Design and installation of ventilation systems to ensure proper air circulation and quality. Includes mechanical ventilation, heat recovery ventilation, and exhaust systems.',
                    'sr' => 'Projektovanje i ugradnja ventilacionih sistema za obezbeđivanje pravilne cirkulacije i kvaliteta vazduha. Uključuje mehaničku ventilaciju, ventilaciju sa rekuperacijom toplote i odvod vazduha.',
                    'hu' => 'Szellőzőrendszerek tervezése és telepítése a megfelelő légcirkuláció és levegőminőség biztosítása érdekében. Mechanikus szellőzést, hővisszanyerős szellőzést és elszívórendszereket tartalmaz.',
                ],
                'icon' => '🌬️',
                'order' => 3,
                'active' => true,
            ],
            [
                'title' => [
                    'en' => 'Maintenance & Repair',
                    'sr' => 'Održavanje i popravka',
                    'hu' => 'Karbantartás és javítás',
                ],
                'description' => [
                    'en' => 'Regular maintenance and repair services for all HVAC systems. Preventive maintenance programs to extend equipment life and ensure optimal performance.',
                    'sr' => 'Redovno održavanje i popravka svih HVAC sistema. Programi preventivnog održavanja za produženje životnog veka opreme i obezbeđivanje optimalnih performansi.',
                    'hu' => 'Rendszeres karbantartási és javítási szolgáltatások minden HVAC rendszerhez. Megelőző karbantartási programok a berendezések élettartamának meghosszabbítására és az optimális teljesítmény biztosítására.',
                ],
                'icon' => '🔧',
                'order' => 4,
                'active' => true,
            ],
            [
                'title' => [
                    'en' => 'Energy Consulting',
                    'sr' => 'Energetsko savetovanje',
                    'hu' => 'Energetikai tanácsadás',
                ],
                'description' => [
                    'en' => 'Professional energy audits and consulting services to help you reduce energy consumption and costs. We provide recommendations for system upgrades and optimization.',
                    'sr' => 'Profesionalni energetski pregledi i savetodavne usluge koje vam pomažu da smanjite potrošnju energije i troškove. Pružamo preporuke za nadogradnju i optimizaciju sistema.',
                    'hu' => 'Professzionális energetikai auditok és tanácsadási szolgáltatások az energiafogyasztás és költségek csökkentése érdekében. Ajánlásokat nyújtunk a rendszerfrissítésekhez és optimalizáláshoz.',
                ],
                'icon' => '💡',
                'order' => 5,
                'active' => true,
            ],
            [
                'title' => [
                    'en' => 'Smart Climate Control',
                    'sr' => 'Pametna kontrola klime',
                    'hu' => 'Intelligens klímaszabályozás',
                ],
                'description' => [
                    'en' => 'Installation of smart thermostats and automation systems for intelligent climate control. Control your HVAC system remotely via smartphone or integrate with smart home systems.',
                    'sr' => 'Ugradnja pametnih termostata i automatskih sistema za inteligentnu kontrolu klime. Kontrolišite svoj HVAC sistem na daljinu putem pametnog telefona ili integrisanog sa sistemima pametne kuće.',
                    'hu' => 'Intelligens termosztátok és automatizálási rendszerek telepítése intelligens klímaszabályozáshoz. Vezérelje HVAC rendszerét távolról okostelefonon keresztül, vagy integrálja okos otthon rendszerekkel.',
                ],
                'icon' => '📱',
                'order' => 6,
                'active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
