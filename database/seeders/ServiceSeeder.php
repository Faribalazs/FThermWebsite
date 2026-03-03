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
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13 10V3L4 14h7v7l9-11h-7z"/>',
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
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"/>',
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
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9.59 4.59A2 2 0 1111 8H2m10.59 11.41A2 2 0 1014 16H2m15.73-8.27A2 2 0 1119 12H2"/>',
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
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>',
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
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
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
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 2v2m0 16v2M4.93 4.93l1.41 1.41m11.32 11.32l1.41 1.41M2 12h2m16 0h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41M12 7a5 5 0 100 10A5 5 0 0012 7z"/>',
                'order' => 6,
                'active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
