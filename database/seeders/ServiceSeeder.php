<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $legacyTitles = [
            'Air Conditioning Installation',
            'Heating Systems',
            'Ventilation Systems',
            'Maintenance & Repair',
            'Energy Consulting',
            'Smart Climate Control',
        ];

        Service::all()
            ->filter(fn (Service $service) => in_array($service->title['en'] ?? null, $legacyTitles, true))
            ->each(fn (Service $service) => $service->delete());

        $services = [
            [
                'slug' => 'air-conditioning-installation',
                'title' => [
                    'sr' => 'Ugradnja klima uređaja',
                    'en' => 'Air conditioning installation',
                    'hu' => 'Klímaszerelés',
                ],
                'description' => [
                    'sr' => 'Stručna montaža novih klima uređaja u stanovima, kućama, kancelarijama i poslovnim prostorima. Pomažemo i pri izboru odgovarajuće snage i pozicije uređaja.',
                    'en' => 'Professional installation of new air conditioning units in flats, houses, offices and commercial spaces. We also help choose the right capacity and location.',
                    'hu' => 'Új klímaberendezések szakszerű telepítése lakásokba, házakba, irodákba és üzlethelyiségekbe. Segítünk a megfelelő teljesítmény és elhelyezés kiválasztásában is.',
                ],
                'content' => [
                    'sr' => <<<'HTML'
<h2>Precizna montaža za pouzdan rad</h2>
<p>Dobra klima ne zavisi samo od brenda uređaja. Važni su snaga, pozicija unutrašnje i spoljne jedinice, odvod kondenzata, kvalitet spojeva i puštanje sistema u rad. FTHERM pre montaže sagledava prostor, navike korišćenja i tehničke uslove da bi uređaj radio tiho, efikasno i uredno.</p>
<h3>Šta obuhvata usluga</h3>
<ul><li>Procenu pozicije i kapaciteta uređaja prema prostoru.</li><li>Montažu unutrašnje i spoljne jedinice sa urednim cevnim i elektro vezama.</li><li>Vakumiranje, proveru spojeva i testiranje režima hlađenja i grejanja.</li><li>Kratko objašnjenje korišćenja i osnovnog održavanja.</li></ul>
<p>Posebno vodimo računa o estetici instalacije, čistom radnom prostoru i sigurnom pričvršćivanju opreme.</p>
HTML,
                    'en' => <<<'HTML'
<h2>Precise installation for reliable operation</h2>
<p>A good air-conditioning result is not only about the unit brand. Capacity, indoor and outdoor unit position, condensate drainage, connection quality and commissioning all matter. FTHERM reviews the space, usage habits and technical conditions before installation so the system can work quietly, efficiently and neatly.</p>
<h3>What the service includes</h3>
<ul><li>Position and capacity assessment for the room.</li><li>Indoor and outdoor unit mounting with tidy pipework and electrical connections.</li><li>Vacuuming, connection checks and cooling/heating test run.</li><li>Basic usage and maintenance guidance after handover.</li></ul>
<p>We pay special attention to clean work, safe fixing and an installation that looks appropriate in the space.</p>
HTML,
                    'hu' => <<<'HTML'
<h2>Pontos szerelés a megbízható működésért</h2>
<p>A jó klímaeredmény nem csak a készülék márkáján múlik. Fontos a teljesítmény, a beltéri és kültéri egység helye, a kondenzvíz elvezetése, a csatlakozások minősége és a beüzemelés. Az FTHERM a szerelés előtt felméri a helyiséget és a műszaki feltételeket.</p>
<h3>Mit tartalmaz a szolgáltatás</h3>
<ul><li>A megfelelő teljesítmény és elhelyezés áttekintése.</li><li>Beltéri és kültéri egység esztétikus felszerelése.</li><li>Csövezés, elektromos bekötés, vákuumolás és próbaüzem.</li><li>Rövid használati és karbantartási tanácsadás.</li></ul>
<p>A tiszta munkaterületre, biztonságos rögzítésre és rendezett kivitelezésre külön figyelünk.</p>
HTML,
                ],
                'image' => 'images/ftherm/service-pages/air-conditioning-installation.png',
                'image_alt' => [
                    'sr' => 'FTHERM tehničar montira unutrašnju jedinicu klima uređaja',
                    'en' => 'FTHERM technician installing an indoor air conditioner unit',
                    'hu' => 'FTHERM szakember beltéri klímaegységet szerel',
                ],
                'order' => 1,
                'active' => true,
            ],
            [
                'slug' => 'ac-service-repair',
                'title' => [
                    'sr' => 'Servis i popravka klima uređaja',
                    'en' => 'AC service and repair',
                    'hu' => 'Klímaszerviz és javítás',
                ],
                'description' => [
                    'sr' => 'Dijagnostika, održavanje i popravka postojećih klima uređaja. Cilj je pouzdan rad, bolja efikasnost i duži vek trajanja uređaja.',
                    'en' => 'Diagnostics, maintenance and repair of existing air conditioning systems. The goal is reliable operation, better efficiency and longer equipment life.',
                    'hu' => 'Hibakeresés, karbantartás és javítás meglévő klímaberendezéseknél. Célunk a megbízható működés, a jobb hatásfok és a hosszabb élettartam.',
                ],
                'content' => [
                    'sr' => <<<'HTML'
<h2>Servis koji vraća sistem u ritam</h2>
<p>Kada klima slabije hladi, čuje se drugačije, curi voda ili se često zaustavlja, problem treba rešiti pre većeg kvara. Redovna provera filtera, izmenjivača, ventilatora i protoka vazduha pomaže da uređaj radi stabilnije i ekonomičnije.</p>
<h3>Tipični radovi</h3>
<ul><li>Dijagnostika rada uređaja i pregled grešaka.</li><li>Kontrola filtera, isparivača, kondenzatora i ventilatora.</li><li>Provera odvoda kondenzata, spojeva i radnih parametara.</li><li>Popravka kvarova i savet za dalju upotrebu.</li></ul>
<p>Servis radimo uredno i jasno objašnjavamo šta je pronađeno, šta je urađeno i šta ima smisla pratiti ubuduće.</p>
HTML,
                    'en' => <<<'HTML'
<h2>Service that brings the system back into balance</h2>
<p>If an AC unit cools poorly, sounds different, leaks water or stops frequently, it is better to solve the issue before a larger failure appears. Regular checks of filters, coils, fans and airflow help the unit work more steadily and efficiently.</p>
<h3>Typical work</h3>
<ul><li>Diagnostics and error review.</li><li>Filter, evaporator, condenser and fan inspection.</li><li>Condensate drain, connection and operating parameter checks.</li><li>Fault repair and advice for further use.</li></ul>
<p>We explain what was found, what was done and what should be monitored later.</p>
HTML,
                    'hu' => <<<'HTML'
<h2>Szerviz, amely visszaállítja a rendszer egyensúlyát</h2>
<p>Ha a klíma gyengébben hűt, szokatlan hangot ad, csöpög vagy gyakran leáll, érdemes időben átvizsgálni. A szűrők, hőcserélők, ventilátorok és légáramlás ellenőrzése segíti a stabilabb és takarékosabb működést.</p>
<h3>Jellemző munkák</h3>
<ul><li>Hibakeresés és működési ellenőrzés.</li><li>Szűrők, hőcserélők és ventilátorok vizsgálata.</li><li>Kondenzvíz-elvezetés, csatlakozások és üzemi értékek ellenőrzése.</li><li>Javítás és használati tanácsadás.</li></ul>
<p>A munka végén érthetően összefoglaljuk, mit találtunk és mire érdemes figyelni.</p>
HTML,
                ],
                'image' => 'images/ftherm/service-pages/ac-service-repair.png',
                'image_alt' => [
                    'sr' => 'Servis klima uređaja sa dijagnostičkim alatom',
                    'en' => 'Air conditioner service with diagnostic tool',
                    'hu' => 'Klímaszerviz diagnosztikai eszközzel',
                ],
                'order' => 2,
                'active' => true,
            ],
            [
                'slug' => 'ac-cleaning-disinfection',
                'title' => [
                    'sr' => 'Čišćenje i dezinfekcija klime',
                    'en' => 'AC cleaning and disinfection',
                    'hu' => 'Klímatisztítás és fertőtlenítés',
                ],
                'description' => [
                    'sr' => 'Redovno čišćenje može doprineti svežijem vazduhu, tišem radu i efikasnijem hlađenju ili grejanju. Posebno je važno pre početka sezone.',
                    'en' => 'Regular cleaning can help provide fresher air, quieter operation and more efficient cooling or heating. It is especially useful before the season starts.',
                    'hu' => 'A rendszeres tisztítás frissebb levegőt, csendesebb működést és hatékonyabb hűtést-fűtést eredményezhet. Különösen fontos szezon előtt.',
                ],
                'content' => [
                    'sr' => <<<'HTML'
<h2>Čist uređaj, prijatniji vazduh</h2>
<p>Klima uređaj kroz sezonu stalno provlači vazduh iz prostora. Na filterima i unutrašnjim površinama mogu se zadržati prašina i nečistoće, što utiče na miris, protok vazduha i osećaj komfora.</p>
<h3>Kako radimo čišćenje</h3>
<ul><li>Skidanje i pranje filtera.</li><li>Čišćenje dostupnih delova unutrašnje jedinice.</li><li>Dezinfekcija prema stanju uređaja i prostoru.</li><li>Provera odvoda kondenzata i probni rad.</li></ul>
<p>Najbolje vreme za čišćenje je pre velikih vrućina ili pre intenzivne sezone grejanja, naročito u prostorima gde se klima koristi svakodnevno.</p>
HTML,
                    'en' => <<<'HTML'
<h2>A clean unit, more comfortable air</h2>
<p>During the season an air conditioner continuously circulates room air. Dust and dirt can collect on filters and internal surfaces, affecting odour, airflow and comfort.</p>
<h3>How we clean</h3>
<ul><li>Filter removal and washing.</li><li>Cleaning accessible parts of the indoor unit.</li><li>Disinfection according to the unit condition and room use.</li><li>Condensate drain check and test run.</li></ul>
<p>The best time for cleaning is before the hottest period or before intensive heating use, especially where the unit runs every day.</p>
HTML,
                    'hu' => <<<'HTML'
<h2>Tiszta készülék, kellemesebb levegő</h2>
<p>A klíma a szezon során folyamatosan keringeti a helyiség levegőjét. A szűrőkön és belső felületeken por és szennyeződés rakódhat le, ami hatással lehet a szagokra, a légáramlásra és a komfortérzetre.</p>
<h3>A tisztítás menete</h3>
<ul><li>Szűrők eltávolítása és mosása.</li><li>A beltéri egység hozzáférhető részeinek tisztítása.</li><li>Fertőtlenítés a készülék állapota szerint.</li><li>Kondenzvíz-elvezetés ellenőrzése és próbaüzem.</li></ul>
<p>A tisztítást érdemes a nagy meleg vagy az intenzív fűtési időszak előtt elvégezni.</p>
HTML,
                ],
                'image' => 'images/ftherm/service-pages/ac-cleaning-disinfection.png',
                'image_alt' => [
                    'sr' => 'Čišćenje unutrašnje jedinice klima uređaja',
                    'en' => 'Cleaning an indoor air conditioner unit',
                    'hu' => 'Beltéri klímaegység tisztítása',
                ],
                'order' => 3,
                'active' => true,
            ],
            [
                'slug' => 'heat-pumps',
                'title' => [
                    'sr' => 'Toplotne pumpe',
                    'en' => 'Heat pumps',
                    'hu' => 'Hőszivattyúk',
                ],
                'description' => [
                    'sr' => 'Savremena i energetski efikasna rešenja za grejanje i hlađenje kod nove gradnje ili modernizacije postojećih sistema.',
                    'en' => 'Modern, energy-efficient heating and cooling solutions for new buildings and upgrades of existing systems.',
                    'hu' => 'Korszerű, energiatakarékos fűtési és hűtési megoldások új építéshez és korszerűsítéshez.',
                ],
                'content' => [
                    'sr' => <<<'HTML'
<h2>Jedan sistem za grejanje i hlađenje</h2>
<p>Toplotna pumpa može obezbediti komfor tokom cele godine i često je dobro rešenje za objekte koji žele manju potrošnju energije i uredan sistem. Može se kombinovati sa podnim grejanjem, zidnim grejanjem, fan-coil jedinicama, radijatorima ili postojećim instalacijama ako su tehnički uslovi odgovarajući.</p>
<h3>FTHERM pristup</h3>
<ul><li>Pregled objekta, izolacije i postojećeg sistema.</li><li>Predlog tipa i kapaciteta toplotne pumpe.</li><li>Ugradnja spoljne jedinice, hidrauličnih veza i regulacije.</li><li>Puštanje u rad i objašnjenje režima korišćenja.</li></ul>
<p>Najbolji rezultat dolazi iz dobrog planiranja: zato pre preporuke gledamo realne potrebe prostora, temperaturne režime i način korišćenja objekta.</p>
HTML,
                    'en' => <<<'HTML'
<h2>One system for heating and cooling</h2>
<p>A heat pump can provide year-round comfort and is often a strong choice for buildings that need lower energy use and a tidy system. It can be combined with underfloor heating, wall heating, fan coils, radiators or existing installations when the technical conditions fit.</p>
<h3>FTHERM approach</h3>
<ul><li>Building, insulation and existing-system review.</li><li>Recommendation of heat pump type and capacity.</li><li>Outdoor unit, hydraulic connection and control installation.</li><li>Commissioning and user guidance.</li></ul>
<p>The best result comes from planning, so we review real room demand, temperature regimes and usage before recommending a system.</p>
HTML,
                    'hu' => <<<'HTML'
<h2>Egy rendszer fűtésre és hűtésre</h2>
<p>A hőszivattyú egész éves komfortot adhat, és jó megoldás lehet azoknak az épületeknek, ahol fontos a takarékosabb üzem és a rendezett gépészet. Padlófűtéssel, falfűtéssel, fan-coil egységekkel, radiátorokkal vagy meglévő rendszerekkel is kombinálható.</p>
<h3>FTHERM megközelítés</h3>
<ul><li>Az épület, szigetelés és meglévő rendszer áttekintése.</li><li>A hőszivattyú típusának és teljesítményének javaslata.</li><li>Kültéri egység, hidraulikai kapcsolatok és szabályozás szerelése.</li><li>Beüzemelés és használati tanácsadás.</li></ul>
<p>A jó eredmény alapja a pontos tervezés és a valós hőigény felmérése.</p>
HTML,
                ],
                'image' => 'images/ftherm/service-pages/heat-pumps.png',
                'image_alt' => [
                    'sr' => 'Spoljna jedinica toplotne pumpe pored moderne kuće',
                    'en' => 'Outdoor heat pump unit beside a modern house',
                    'hu' => 'Hőszivattyú kültéri egysége modern ház mellett',
                ],
                'order' => 4,
                'active' => true,
            ],
            [
                'slug' => 'underfloor-wall-heating',
                'title' => [
                    'sr' => 'Podno i zidno grejanje',
                    'en' => 'Underfloor and wall heating',
                    'hu' => 'Padló- és falfűtés',
                ],
                'description' => [
                    'sr' => 'Sistemi koji obezbeđuju udobnu i ravnomernu raspodelu toplote u kućama, stanovima i modernim objektima.',
                    'en' => 'Comfortable systems that provide even heat distribution in houses, apartments and modern buildings.',
                    'hu' => 'Komfortos, egyenletes hőelosztást biztosító rendszerek családi házakba, lakásokba és modern épületekbe.',
                ],
                'content' => [
                    'sr' => <<<'HTML'
<h2>Ravnomerna toplota bez vizuelnog opterećenja</h2>
<p>Podno i zidno grejanje daju prijatan osećaj jer se toplota raspoređuje preko velike površine. Sistem traži pažljivo planiranje, pravilne razmake cevi, dobru regulaciju i usklađenost sa završnim oblogama.</p>
<h3>Šta je važno</h3>
<ul><li>Pravilna priprema podloge i raspored grejnih krugova.</li><li>Uredna ugradnja razdelnika i regulacije.</li><li>Provera pritiska pre zatvaranja konstrukcije.</li><li>Usklađivanje sa toplotnom pumpom, kotlom ili drugim izvorom toplote.</li></ul>
<p>Ovakvi sistemi su posebno zanimljivi kod novogradnje i renoviranja gde se komfor planira dugoročno.</p>
HTML,
                    'en' => <<<'HTML'
<h2>Even heat without visual clutter</h2>
<p>Underfloor and wall heating feel comfortable because heat is distributed across a large surface. The system needs careful planning, correct pipe spacing, good controls and coordination with floor or wall finishes.</p>
<h3>What matters</h3>
<ul><li>Proper base preparation and circuit layout.</li><li>Tidy manifold and control installation.</li><li>Pressure testing before the structure is closed.</li><li>Coordination with heat pumps, boilers or other heat sources.</li></ul>
<p>These systems are especially useful in new builds and renovations where comfort is planned for the long term.</p>
HTML,
                    'hu' => <<<'HTML'
<h2>Egyenletes hő, látható gépészet nélkül</h2>
<p>A padló- és falfűtés nagy felületen adja le a hőt, ezért kényelmes hőérzetet biztosíthat. Fontos a csövek helyes kiosztása, a szabályozás és a burkolatokkal való összehangolás.</p>
<h3>Ami fontos</h3>
<ul><li>Megfelelő aljzat-előkészítés és körkiosztás.</li><li>Osztó-gyűjtő és szabályozás rendezett szerelése.</li><li>Nyomáspróba a szerkezet lezárása előtt.</li><li>Összehangolás hőszivattyúval, kazánnal vagy más hőforrással.</li></ul>
<p>Különösen új építésnél és felújításnál jó választás, ahol hosszú távú komfort a cél.</p>
HTML,
                ],
                'image' => 'images/ftherm/service-pages/underfloor-wall-heating.png',
                'image_alt' => [
                    'sr' => 'Cevne instalacije za podno grejanje',
                    'en' => 'Pipe installation for underfloor heating',
                    'hu' => 'Padlófűtés csőhálózatának szerelése',
                ],
                'order' => 5,
                'active' => true,
            ],
            [
                'slug' => 'radiators-heating-systems',
                'title' => [
                    'sr' => 'Radijatori i sistemi grejanja',
                    'en' => 'Radiators and heating systems',
                    'hu' => 'Radiátorok és fűtési rendszerek',
                ],
                'description' => [
                    'sr' => 'Montaža, zamena i održavanje radijatora, cevnih razvoda, razdelnika i sistema grejanja.',
                    'en' => 'Installation, replacement and maintenance of radiators, pipework, manifolds and heating systems.',
                    'hu' => 'Radiátorok, csövezés, osztó-gyűjtők és fűtési rendszerek szerelése, cseréje és karbantartása.',
                ],
                'content' => [
                    'sr' => <<<'HTML'
<h2>Stabilno grejanje u svakodnevnom radu</h2>
<p>Radijatorski sistemi i cevni razvodi moraju biti pravilno dimenzionisani, odzračeni i hidraulički usklađeni. Kada sistem nije izbalansiran, neke prostorije su previše tople, druge hladne, a potrošnja može biti veća nego što je potrebno.</p>
<h3>Radimo</h3>
<ul><li>Montažu i zamenu radijatora.</li><li>Izradu i popravku cevnih razvoda.</li><li>Ugradnju razdelnika, ventila i prateće opreme.</li><li>Proveru curenja, odzračivanje i savet za upotrebu.</li></ul>
<p>Cilj je sistem koji se lako koristi, ravnomerno greje i ostaje servisabilan.</p>
HTML,
                    'en' => <<<'HTML'
<h2>Stable heating for everyday use</h2>
<p>Radiator systems and pipework need correct sizing, air removal and hydraulic balance. When a system is not balanced, some rooms overheat, others remain cold, and energy use can rise.</p>
<h3>We handle</h3>
<ul><li>Radiator installation and replacement.</li><li>Pipework creation and repair.</li><li>Manifold, valve and accessory installation.</li><li>Leak checks, air bleeding and user guidance.</li></ul>
<p>The goal is a system that is easy to use, heats evenly and remains serviceable.</p>
HTML,
                    'hu' => <<<'HTML'
<h2>Stabil fűtés a mindennapokban</h2>
<p>A radiátoros rendszereknél fontos a megfelelő méretezés, légtelenítés és hidraulikai egyensúly. Ha a rendszer nincs beállítva, egyes helyiségek túl melegek, mások hidegek maradhatnak.</p>
<h3>Vállaljuk</h3>
<ul><li>Radiátorok szerelését és cseréjét.</li><li>Csőhálózat kialakítását és javítását.</li><li>Osztó-gyűjtők, szelepek és kiegészítők szerelését.</li><li>Szivárgásellenőrzést, légtelenítést és tanácsadást.</li></ul>
<p>A cél egy könnyen használható, egyenletesen fűtő és jól szervizelhető rendszer.</p>
HTML,
                ],
                'image' => 'images/ftherm/service-pages/radiators-heating-systems.png',
                'image_alt' => [
                    'sr' => 'Servis radijatora i sistema grejanja',
                    'en' => 'Radiator and heating system service',
                    'hu' => 'Radiátor és fűtési rendszer szerelése',
                ],
                'order' => 6,
                'active' => true,
            ],
            [
                'slug' => 'plumbing',
                'title' => [
                    'sr' => 'Vodoinstalacije',
                    'en' => 'Plumbing',
                    'hu' => 'Vízszerelés',
                ],
                'description' => [
                    'sr' => 'Pouzdana izrada i popravka vodovodnih instalacija, priključaka i drugih mašinskih radova.',
                    'en' => 'Reliable installation and repair of water pipes, connections and mechanical building-service works.',
                    'hu' => 'Vízvezetékek, csatlakozások, javítások és gépészeti munkák megbízható kivitelezése.',
                ],
                'content' => [
                    'sr' => <<<'HTML'
<h2>Vodoinstalacije koje ostaju uredne i dostupne</h2>
<p>Kod vodovodnih instalacija kvalitet se vidi u detaljima: pravilnom izboru materijala, sigurnim spojevima, jasnom rasporedu ventila i mogućnosti da se instalacija kasnije servisira bez nepotrebnog lomljenja.</p>
<h3>Usluga obuhvata</h3>
<ul><li>Izradu novih vodovodnih priključaka i razvoda.</li><li>Popravke, zamene delova i rešavanje curenja.</li><li>Ugradnju ventila, priključaka i opreme.</li><li>Proveru pritiska i funkcionalnosti instalacije.</li></ul>
<p>Rad prilagođavamo prostoru: kupatilu, kuhinji, tehničkoj prostoriji ili poslovnom objektu.</p>
HTML,
                    'en' => <<<'HTML'
<h2>Plumbing that stays tidy and accessible</h2>
<p>Plumbing quality is visible in the details: correct material choice, secure joints, clear valve layout and the ability to service the system later without unnecessary damage.</p>
<h3>The service includes</h3>
<ul><li>New water connections and pipework.</li><li>Repairs, part replacement and leak solving.</li><li>Valve, fitting and equipment installation.</li><li>Pressure and functionality checks.</li></ul>
<p>We adapt the work to the space, whether it is a bathroom, kitchen, technical room or business property.</p>
HTML,
                    'hu' => <<<'HTML'
<h2>Rendezett és hozzáférhető vízszerelés</h2>
<p>A vízvezetékek minősége a részletekben látszik: megfelelő anyagválasztás, biztonságos kötés, átgondolt szelepelhelyezés és későbbi szervizelhetőség.</p>
<h3>A szolgáltatás részei</h3>
<ul><li>Új vízcsatlakozások és csőhálózat kialakítása.</li><li>Javítások, alkatrészcserék és szivárgások megszüntetése.</li><li>Szelepek, idomok és berendezések szerelése.</li><li>Nyomás- és működésellenőrzés.</li></ul>
<p>A munkát a helyiséghez igazítjuk, legyen szó fürdőről, konyháról, gépészeti helyiségről vagy üzletről.</p>
HTML,
                ],
                'image' => 'images/ftherm/service-pages/plumbing.png',
                'image_alt' => [
                    'sr' => 'Vodoinstalaterski radovi na cevnom priključku',
                    'en' => 'Plumbing work on a pipe connection',
                    'hu' => 'Vízvezeték-csatlakozás szerelése',
                ],
                'order' => 7,
                'active' => true,
            ],
            [
                'slug' => 'cold-rooms-refrigeration',
                'title' => [
                    'sr' => 'Rashladne komore i rashladna tehnika',
                    'en' => 'Cold rooms and refrigeration systems',
                    'hu' => 'Hűtőkamrák és hűtéstechnika',
                ],
                'description' => [
                    'sr' => 'Projektovanje, izrada, servis i održavanje rashladnih komora i poslovnih/industrijskih sistema hlađenja.',
                    'en' => 'Design, installation, service and maintenance of cold rooms and commercial or industrial refrigeration systems.',
                    'hu' => 'Hűtőkamrák, üzleti és ipari hűtési megoldások kialakítása, szervize és karbantartása.',
                ],
                'content' => [
                    'sr' => <<<'HTML'
<h2>Rashladni sistemi za stabilnu temperaturu</h2>
<p>Kod rashladnih komora važni su stabilna temperatura, higijenski prostor, pouzdana oprema i redovno održavanje. Svaki zastoj može uticati na robu i poslovni proces, zato sistem treba planirati i servisirati pažljivo.</p>
<h3>Šta radimo</h3>
<ul><li>Planiranje i izradu rashladnih komora.</li><li>Ugradnju evaporatora, agregata, regulacije i izolovanih elemenata.</li><li>Servis i dijagnostiku poslovnih rashladnih sistema.</li><li>Preventivno održavanje i proveru radnih parametara.</li></ul>
<p>Rešenje prilagođavamo nameni prostora, temperaturi rada, opterećenju i režimu korišćenja.</p>
HTML,
                    'en' => <<<'HTML'
<h2>Refrigeration systems for stable temperature</h2>
<p>Cold rooms depend on stable temperature, a hygienic space, reliable equipment and regular maintenance. Downtime can affect goods and business processes, so the system needs careful planning and service.</p>
<h3>What we do</h3>
<ul><li>Cold room planning and construction.</li><li>Evaporator, condensing unit, control and insulated element installation.</li><li>Service and diagnostics for commercial refrigeration systems.</li><li>Preventive maintenance and operating-parameter checks.</li></ul>
<p>We adapt the solution to the room purpose, operating temperature, load and usage pattern.</p>
HTML,
                    'hu' => <<<'HTML'
<h2>Hűtéstechnika stabil hőmérséklethez</h2>
<p>A hűtőkamráknál fontos a stabil hőmérséklet, a higiénikus tér, a megbízható berendezés és a rendszeres karbantartás. Egy leállás árut és üzleti folyamatot is érinthet.</p>
<h3>Mit vállalunk</h3>
<ul><li>Hűtőkamrák tervezése és kialakítása.</li><li>Elpárologtató, aggregát, szabályozás és szigetelt elemek szerelése.</li><li>Üzleti hűtési rendszerek szervize és diagnosztikája.</li><li>Megelőző karbantartás és üzemi értékek ellenőrzése.</li></ul>
<p>A megoldást a helyiség céljához, hőmérsékletéhez, terheléséhez és használatához igazítjuk.</p>
HTML,
                ],
                'image' => 'images/ftherm/service-pages/cold-rooms-refrigeration.png',
                'image_alt' => [
                    'sr' => 'Servis rashladne komore i rashladne opreme',
                    'en' => 'Cold room and refrigeration equipment service',
                    'hu' => 'Hűtőkamra és hűtéstechnikai berendezés szervize',
                ],
                'order' => 8,
                'active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['slug' => $service['slug']],
                $service
            );
        }
    }
}
