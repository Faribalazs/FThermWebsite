# FTHERM modern multilingual website – Codex implementation brief

## 0) Main instruction for Codex

You are a senior web designer, frontend developer, UX writer and SEO specialist. Build or redesign the FTHERM website into a modern, trustworthy, fast, mobile-first company website for heating, cooling and technical installation services.

The website must feel premium but practical: clean layout, realistic service imagery, strong phone/contact calls-to-action, clear service categories, local trust, and multilingual copy in Hungarian, Serbian Latin and English.

Do not copy competitor websites or texts. Use the structure and conversion patterns common on modern HVAC websites, but write original FTHERM content.

## 1) Business context

Brand name: `FTHERM` / `FTherm` — use the existing logo/brand spelling if the repo already has one.

FTHERM is a heating, cooling and installation company. The company works with:

- air conditioning installation
- air conditioning service and repair
- air conditioning cleaning / deep cleaning / disinfection
- heating and cooling systems
- plumbing / water installation work
- cold rooms and refrigeration technology
- underfloor heating
- heat pumps
- wall heating
- radiators and complete heating systems

Target customers:

- private houses and flats
- apartments and family homes
- offices, cafés, shops and small businesses
- commercial and industrial spaces that need refrigeration or cold rooms
- customers who want energy-efficient heating/cooling solutions

Primary goals:

1. Generate phone calls and quote requests.
2. Show clearly what FTHERM does.
3. Build trust through clean design, practical explanations, process, references and FAQs.
4. Make the website usable in Hungarian, Serbian Latin and English.
5. Make the site fast and SEO-friendly.

Important language rule: Serbian content must be **Latin script**, not Cyrillic.

## 2) Technical approach

First inspect the existing project and follow its stack. Do not rewrite the whole project unnecessarily.

Expected stack if present:

- Laravel / Blade / Bagisto theme structure
- Tailwind CSS
- Vite or existing asset pipeline
- existing translation / locale system

Implementation rules:

- Use existing layouts, route naming, locale middleware and design tokens where possible.
- If the project uses Laravel translations, create language files such as:
  - `lang/hu/ftherm.php`
  - `lang/sr/ftherm.php`
  - `lang/en/ftherm.php`
- If the project uses JSON translations, create equivalent keys.
- If the project uses Vue components, keep the content in locale-aware data objects.
- Do not hard-code phone, email, address or social links if config/settings already exist. Use existing configuration; otherwise add clear `TODO` placeholders.
- Do not claim “24/7”, “licensed”, “authorized”, “certified”, “free survey”, “warranty”, “X years experience” unless this data already exists in the project or is provided by the owner.
- Do not remove existing shop/e-commerce functionality if this is inside the FTherm shop project. Add a modern service/company landing structure around it.

## 3) Design direction

Create a modern HVAC / building-services visual style:

### Visual feeling

- clean, technical, reliable, premium
- cold + warm contrast: cooling blue/cyan with heating orange accents
- realistic service photos, not generic fake vector cartoons
- spacious layout with strong cards and clear CTAs
- modern but not too futuristic; it should still feel like a real local service company

### Suggested color tokens

Use existing colors if already defined. If not, add a small FTHERM palette:

```css
--ftherm-navy: #071527;
--ftherm-dark: #0F172A;
--ftherm-blue: #0EA5E9;
--ftherm-cyan: #67E8F9;
--ftherm-orange: #F97316;
--ftherm-ice: #F0F9FF;
--ftherm-gray: #64748B;
--ftherm-border: #E2E8F0;
--ftherm-white: #FFFFFF;
```

### Typography

- Use the existing site font if there is one.
- If no strong typography exists, use a modern sans-serif such as Inter, Sora or Manrope.
- Headings should be strong and clear, not overly decorative.
- Body text must be readable on mobile.

### UI details

- Sticky header on desktop and mobile.
- Top mini bar with phone, email/location and language switcher.
- Large hero section with CTA buttons.
- Service cards with icons and short copy.
- Trust strip under the hero.
- “How we work” process section.
- Project/reference gallery.
- FAQ accordion.
- Contact section with phone, email, form and map placeholder.
- Floating mobile call button and/or WhatsApp/Viber button if contact data exists.
- Subtle animations only: fade-up, slight card lift, smooth scroll. Respect `prefers-reduced-motion`.

## 4) Website structure

Create these pages/sections. If the current project has only one page, create all sections on the homepage first, and make service cards link-ready for later detail pages.

### Required navigation

- Home
- Services
- About us
- References / Projects
- FAQ
- Contact
- Language switcher: HU / SR / EN

### Homepage sections

1. Header / navigation
2. Hero
3. Trust badges / quick benefits
4. Services grid
5. Seasonal service highlight: AC cleaning before cooling/heating season
6. Heat pump / modern heating-cooling solutions section
7. How we work
8. About FTHERM
9. References / project gallery
10. Testimonials placeholder
11. FAQ
12. Final CTA
13. Footer

### Service categories

Each category should have a card, icon, image and CTA:

1. Air conditioning installation
2. Air conditioning service and repair
3. Air conditioning cleaning and disinfection
4. Heat pumps
5. Underfloor and wall heating
6. Radiators and heating systems
7. Plumbing / water installation
8. Cold rooms and refrigeration systems

## 5) Copywriting tone

Tone:

- professional
- clear
- local and trustworthy
- not too salesy
- practical and understandable for homeowners
- technical enough for business customers

Avoid:

- exaggerated promises
- fake statistics
- fake certifications
- copied competitor text
- overly long paragraphs

Prefer:

- short benefit-focused headings
- clear service descriptions
- concrete process explanations
- “request quote” and “call” CTA wording

## 6) Multilingual website copy

Use this copy as the base website content. Improve grammar only if needed, but keep the same meaning. Serbian must stay in Latin script.

---

# Hungarian copy

## SEO

Meta title: `FTHERM – Klímaszerelés, hőszivattyúk, fűtés-hűtés és vízszerelés`

Meta description: `FTHERM – professzionális klímaszerelés, klímaszerviz, klímatisztítás, hőszivattyúk, padló- és falfűtés, radiátorok, vízszerelés és hűtőkamrák lakossági és üzleti ügyfeleknek.`

Keywords to naturally include: `klímaszerelés`, `klímaszerviz`, `klímatisztítás`, `hőszivattyú telepítés`, `padlófűtés`, `falfűtés`, `radiátor`, `vízszerelés`, `hűtőkamra`, `fűtés-hűtés`.

## Header

Navigation:

- Főoldal
- Szolgáltatások
- Rólunk
- Referenciák
- Gyakori kérdések
- Kapcsolat

CTA buttons:

- Ajánlatot kérek
- Hívás most

## Hero

Eyebrow: `Hűtés • Fűtés • Vízszerelés`

Headline: `Komplett hűtés-fűtés megoldások egy kézben`

Subheadline: `Klímaszerelés, szerviz, tisztítás, hőszivattyúk, padló- és falfűtés, radiátorok, vízszerelés és hűtőkamrák – precízen, átláthatóan, hosszú távra tervezve.`

Primary CTA: `Ajánlatot kérek`

Secondary CTA: `Megnézem a szolgáltatásokat`

Hero badges:

- `Gyors egyeztetés`
- `Tiszta, precíz munkavégzés`
- `Lakossági és üzleti megoldások`
- `Energiatakarékos rendszerek`

## Trust strip

Title: `Miért választják az ügyfelek az FTHERM-et?`

Items:

1. `Átgondolt megoldások` – `Nem csak felszerelünk, hanem segítünk kiválasztani az adott térhez megfelelő rendszert.`
2. `Átlátható ajánlat` – `A munka előtt érthetően egyeztetjük a lehetőségeket, költségeket és határidőket.`
3. `Rendezett kivitelezés` – `Ügyelünk a tiszta munkaterületre, az esztétikus szerelésre és a biztonságos működésre.`
4. `Hosszú távú gondolkodás` – `Olyan rendszereket ajánlunk, amelyek kényelmet, megbízhatóságot és takarékos működést szolgálnak.`

## Services section

Title: `Szolgáltatásaink`

Intro: `A hűtéstől a fűtésig, a klímától a hőszivattyúig, a vízszereléstől a hűtőkamrákig – FTHERM megoldások otthonoknak és vállalkozásoknak.`

Services:

1. `Klímaszerelés`  
   `Új klímaberendezések szakszerű telepítése lakásokba, házakba, irodákba és üzlethelyiségekbe. Segítünk a megfelelő teljesítmény és elhelyezés kiválasztásában is.`

2. `Klímaszerviz és javítás`  
   `Hibakeresés, karbantartás és javítás meglévő klímaberendezéseknél. Célunk a megbízható működés, a jobb hatásfok és a hosszabb élettartam.`

3. `Klímatisztítás és fertőtlenítés`  
   `A rendszeres tisztítás frissebb levegőt, csendesebb működést és hatékonyabb hűtést-fűtést eredményezhet. Különösen fontos szezon előtt.`

4. `Hőszivattyúk`  
   `Korszerű, energiatakarékos fűtési és hűtési megoldások új építéshez és korszerűsítéshez. Segítünk a rendszer megtervezésében és kivitelezésében.`

5. `Padló- és falfűtés`  
   `Komfortos, egyenletes hőelosztást biztosító rendszerek családi házakba, lakásokba és modern épületekbe.`

6. `Radiátorok és fűtési rendszerek`  
   `Radiátorok, csövezés, osztó-gyűjtők és fűtési rendszerek szerelése, cseréje és karbantartása.`

7. `Vízszerelés`  
   `Vízvezetékek, csatlakozások, javítások és gépészeti munkák megbízható kivitelezése.`

8. `Hűtőkamrák és hűtéstechnika`  
   `Hűtőkamrák, üzleti és ipari hűtési megoldások kialakítása, szervize és karbantartása.`

Card CTA: `Részletek`

## Seasonal AC cleaning section

Title: `Ne várja meg a kánikulát – készüljön fel időben`

Text: `A klímaberendezés a helyiség levegőjét keringeti, ezért a rendszeres tisztítás nemcsak a készüléknek, hanem a komfortérzetnek is fontos. A szezon előtti karbantartás segíthet megelőzni a kellemetlen szagokat, a gyengébb teljesítményt és a váratlan meghibásodásokat.`

Bullets:

- `Frissebb, tisztább levegő otthon vagy munkahelyen`
- `Hatékonyabb hűtés és fűtés`
- `Csendesebb, egyenletesebb működés`
- `Hosszabb készülék-élettartam`

CTA: `Klímatisztítást kérek`

## Heat pump section

Title: `Modern fűtés és hűtés hőszivattyúval`

Text: `A hőszivattyús rendszerek egész évben kényelmes megoldást nyújthatnak: télen fűtésre, nyáron hűtésre használhatók, és jól kombinálhatók padlófűtéssel, falfűtéssel, radiátorokkal vagy más épületgépészeti rendszerekkel.`

CTA: `Hőszivattyú megoldást kérek`

## Process section

Title: `Hogyan dolgozunk?`

Steps:

1. `Kapcsolatfelvétel` – `Elmondja, mire van szüksége, mi pedig egyeztetjük a következő lépést.`
2. `Felmérés vagy diagnosztika` – `Megnézzük a helyszínt, a készüléket vagy a rendszert, és felmérjük a lehetőségeket.`
3. `Ajánlat és időpont` – `Átlátható ajánlatot adunk, majd egyeztetjük a kivitelezés idejét.`
4. `Kivitelezés` – `Precízen, rendezett munkaterülettel és szakmai odafigyeléssel dolgozunk.`
5. `Átadás és tanácsadás` – `A munka végén elmagyarázzuk a használatot, karbantartást és a következő teendőket.`

## About section

Title: `FTHERM – megbízható partner a hűtésben és fűtésben`

Text: `Az FTHERM célja, hogy ügyfeleinek átgondolt, biztonságos és hosszú távon is kényelmes hűtési, fűtési és vízszerelési megoldásokat nyújtson. Legyen szó klímáról, hőszivattyúról, padlófűtésről, radiátorról, vízszerelésről vagy hűtőkamráról, a munkát mindig az adott helyszín igényeihez igazítjuk.`

## Project gallery section

Title: `Referenciák és munkáink`

Text: `Nézze meg korábbi kivitelezéseinket: klímaszerelés, hőszivattyús rendszerek, padlófűtés, vízszerelés és hűtéstechnikai munkák.`

Placeholder note for Codex: Add gallery cards with real project photos when available. Until then, use generated realistic placeholder images with clear alt text.

## Testimonials section

Title: `Ügyfeleink visszajelzései`

Placeholder text: `A valós ügyfélvéleményeket később ide kell feltölteni. Ne generálj hamis neveket vagy hamis értékeléseket.`

## FAQ

1. `Mikor érdemes klímatisztítást kérni?`  
   `Legjobb a hűtési szezon előtt, illetve fűtésre használt klímáknál a fűtési szezon előtt is. Rendszeres használat mellett évente legalább egyszer ajánlott ellenőriztetni és tisztíttatni.`

2. `Mekkora klíma kell egy helyiségbe?`  
   `Ez függ az alapterülettől, szigeteléstől, tájolástól, nyílászáróktól és a használattól. Pontos javaslatot felmérés vagy egyeztetés alapján lehet adni.`

3. `A hőszivattyú csak fűtésre jó?`  
   `Nem. Sok hőszivattyús rendszer fűtésre és hűtésre is használható, megfelelő hőleadó rendszerrel pedig egész éves komfortot biztosíthat.`

4. `Vállalnak hűtőkamrákat is?`  
   `Igen, FTHERM hűtéstechnikai és hűtőkamrás megoldásokkal is foglalkozik. A pontos igények alapján személyre szabott megoldást kell tervezni.`

5. `Kérhetek ajánlatot több szolgáltatásra egyszerre?`  
   `Igen. Klíma, fűtés, vízszerelés és hűtéstechnika esetén is érdemes egyben egyeztetni, hogy a rendszer átláthatóan és hatékonyan legyen megtervezve.`

## Final CTA

Title: `Kérjen ajánlatot FTHERM megoldásra`

Text: `Írja le röviden, mire van szüksége, és felvesszük Önnel a kapcsolatot. Klíma, fűtés, hűtés, vízszerelés vagy hűtőkamra – segítünk megtalálni a megfelelő megoldást.`

Buttons:

- `Ajánlatot kérek`
- `Hívás most`

---

# Serbian Latin copy

## SEO

Meta title: `FTHERM – Ugradnja klime, servis, toplotne pumpe, grejanje-hlađenje i vodoinstalacije`

Meta description: `FTHERM pruža profesionalne usluge ugradnje klima uređaja, servisa, čišćenja, toplotnih pumpi, podnog i zidnog grejanja, radijatora, vodoinstalacija i rashladnih komora za domove i poslovne prostore.`

Keywords to naturally include: `ugradnja klime`, `servis klima uređaja`, `čišćenje klime`, `toplotne pumpe`, `podno grejanje`, `zidno grejanje`, `radijatori`, `vodoinstalacije`, `rashladne komore`, `grejanje i hlađenje`.

## Header

Navigation:

- Početna
- Usluge
- O nama
- Reference
- Česta pitanja
- Kontakt

CTA buttons:

- Zatražite ponudu
- Pozovite nas

## Hero

Eyebrow: `Hlađenje • Grejanje • Vodoinstalacije`

Headline: `Kompletna rešenja za grejanje i hlađenje na jednom mestu`

Subheadline: `Ugradnja klima uređaja, servis, čišćenje, toplotne pumpe, podno i zidno grejanje, radijatori, vodoinstalacije i rashladne komore – precizno, pregledno i dugoročno pouzdano.`

Primary CTA: `Zatražite ponudu`

Secondary CTA: `Pogledajte usluge`

Hero badges:

- `Brz dogovor`
- `Čist i precizan rad`
- `Rešenja za domove i firme`
- `Energetski efikasni sistemi`

## Trust strip

Title: `Zašto klijenti biraju FTHERM?`

Items:

1. `Promišljena rešenja` – `Ne radimo samo montažu, već pomažemo da se izabere sistem koji odgovara prostoru i potrebama.`
2. `Jasna ponuda` – `Pre početka rada dogovaramo mogućnosti, troškove i rokove na razumljiv način.`
3. `Uredna izvedba` – `Vodimo računa o čistom radnom prostoru, estetskoj montaži i sigurnom radu sistema.`
4. `Dugoročno razmišljanje` – `Preporučujemo sisteme koji donose komfor, pouzdanost i ekonomičan rad.`

## Services section

Title: `Naše usluge`

Intro: `Od hlađenja do grejanja, od klima uređaja do toplotnih pumpi, od vodoinstalacija do rashladnih komora – FTHERM rešenja za domove i poslovne prostore.`

Services:

1. `Ugradnja klima uređaja`  
   `Stručna montaža novih klima uređaja u stanovima, kućama, kancelarijama i poslovnim prostorima. Pomažemo i pri izboru odgovarajuće snage i pozicije uređaja.`

2. `Servis i popravka klima uređaja`  
   `Dijagnostika, održavanje i popravka postojećih klima uređaja. Cilj je pouzdan rad, bolja efikasnost i duži vek trajanja uređaja.`

3. `Čišćenje i dezinfekcija klime`  
   `Redovno čišćenje može doprineti svežijem vazduhu, tišem radu i efikasnijem hlađenju ili grejanju. Posebno je važno pre početka sezone.`

4. `Toplotne pumpe`  
   `Savremena i energetski efikasna rešenja za grejanje i hlađenje kod nove gradnje ili modernizacije postojećih sistema.`

5. `Podno i zidno grejanje`  
   `Sistemi koji obezbeđuju udobnu i ravnomernu raspodelu toplote u kućama, stanovima i modernim objektima.`

6. `Radijatori i sistemi grejanja`  
   `Montaža, zamena i održavanje radijatora, cevnih razvoda, razdelnika i sistema grejanja.`

7. `Vodoinstalacije`  
   `Pouzdana izrada i popravka vodovodnih instalacija, priključaka i drugih mašinskih radova.`

8. `Rashladne komore i rashladna tehnika`  
   `Projektovanje, izrada, servis i održavanje rashladnih komora i poslovnih/industrijskih sistema hlađenja.`

Card CTA: `Detalji`

## Seasonal AC cleaning section

Title: `Ne čekajte velike vrućine – pripremite se na vreme`

Text: `Klima uređaj kruži vazduh iz prostorije, zato je redovno čišćenje važno i za uređaj i za osećaj komfora. Održavanje pre sezone može pomoći da se izbegnu neprijatni mirisi, slabiji učinak i neočekivani kvarovi.`

Bullets:

- `Svežiji i čistiji vazduh kod kuće ili na poslu`
- `Efikasnije hlađenje i grejanje`
- `Tiši i ravnomerniji rad`
- `Duži vek trajanja uređaja`

CTA: `Želim čišćenje klime`

## Heat pump section

Title: `Moderno grejanje i hlađenje pomoću toplotne pumpe`

Text: `Toplotne pumpe mogu pružiti komfor tokom cele godine: zimi za grejanje, leti za hlađenje, a mogu se kombinovati sa podnim grejanjem, zidnim grejanjem, radijatorima ili drugim mašinskim sistemima.`

CTA: `Želim rešenje sa toplotnom pumpom`

## Process section

Title: `Kako radimo?`

Steps:

1. `Kontakt` – `Kažete nam šta vam je potrebno, a mi dogovaramo sledeći korak.`
2. `Procena ili dijagnostika` – `Pregledamo prostor, uređaj ili sistem i procenjujemo mogućnosti.`
3. `Ponuda i termin` – `Dajemo jasnu ponudu i dogovaramo vreme izvođenja radova.`
4. `Izvođenje radova` – `Radimo precizno, uredno i sa stručnom pažnjom.`
5. `Predaja i savetovanje` – `Na kraju objašnjavamo upotrebu, održavanje i naredne korake.`

## About section

Title: `FTHERM – pouzdan partner za hlađenje i grejanje`

Text: `Cilj FTHERM-a je da klijentima pruži promišljena, sigurna i dugoročno udobna rešenja za hlađenje, grejanje i vodoinstalacije. Bilo da je u pitanju klima uređaj, toplotna pumpa, podno grejanje, radijator, vodoinstalacija ili rashladna komora, rad uvek prilagođavamo potrebama konkretnog prostora.`

## Project gallery section

Title: `Reference i naši radovi`

Text: `Pogledajte prethodne radove: ugradnja klima uređaja, sistemi sa toplotnim pumpama, podno grejanje, vodoinstalacije i rashladna tehnika.`

Placeholder note for Codex: Add real project photos when available. Do not generate fake customer reviews or fake company claims.

## Testimonials section

Title: `Utisci klijenata`

Placeholder text: `Stvarne recenzije klijenata treba dodati kasnije. Nemoj generisati lažna imena ili lažne ocene.`

## FAQ

1. `Kada je najbolje uraditi čišćenje klime?`  
   `Najbolje pre sezone hlađenja, a kod klima koje se koriste za grejanje i pre grejne sezone. Kod redovne upotrebe preporučuje se provera i čišćenje najmanje jednom godišnje.`

2. `Kolika klima je potrebna za prostoriju?`  
   `To zavisi od kvadrature, izolacije, orijentacije, prozora i načina korišćenja prostora. Tačan predlog se daje nakon procene ili dogovora.`

3. `Da li je toplotna pumpa samo za grejanje?`  
   `Ne. Mnogi sistemi sa toplotnom pumpom mogu se koristiti i za grejanje i za hlađenje, uz odgovarajući sistem predaje toplote.`

4. `Da li radite rashladne komore?`  
   `Da, FTHERM se bavi i rashladnom tehnikom i rashladnim komorama. Tačno rešenje se planira prema potrebama prostora i nameni.`

5. `Mogu li tražiti ponudu za više usluga odjednom?`  
   `Da. Kod klime, grejanja, vodoinstalacija i rashladne tehnike često je najbolje sve sagledati zajedno kako bi sistem bio pregledan i efikasan.`

## Final CTA

Title: `Zatražite ponudu za FTHERM rešenje`

Text: `Ukratko opišite šta vam je potrebno i kontaktiraćemo vas. Klima, grejanje, hlađenje, vodoinstalacije ili rashladna komora – pomoći ćemo da pronađete odgovarajuće rešenje.`

Buttons:

- `Zatražite ponudu`
- `Pozovite nas`

---

# English copy

## SEO

Meta title: `FTHERM – Air Conditioning, Heat Pumps, Heating-Cooling and Plumbing Services`

Meta description: `FTHERM provides professional air conditioning installation, AC service, AC cleaning, heat pumps, underfloor and wall heating, radiators, plumbing and cold room refrigeration solutions for homes and businesses.`

Keywords to naturally include: `air conditioning installation`, `AC service`, `AC cleaning`, `heat pump installation`, `underfloor heating`, `wall heating`, `radiators`, `plumbing`, `cold rooms`, `heating and cooling`.

## Header

Navigation:

- Home
- Services
- About us
- References
- FAQ
- Contact

CTA buttons:

- Request a quote
- Call now

## Hero

Eyebrow: `Cooling • Heating • Plumbing`

Headline: `Complete heating and cooling solutions in one place`

Subheadline: `Air conditioning installation, service, cleaning, heat pumps, underfloor and wall heating, radiators, plumbing and cold rooms – delivered with precision, clarity and long-term reliability.`

Primary CTA: `Request a quote`

Secondary CTA: `View services`

Hero badges:

- `Fast consultation`
- `Clean and precise work`
- `Residential and business solutions`
- `Energy-efficient systems`

## Trust strip

Title: `Why customers choose FTHERM`

Items:

1. `Well-planned solutions` – `We do more than install equipment. We help choose the right system for the space and its real needs.`
2. `Clear quotation` – `Before work begins, we explain the options, costs and schedule in a simple and transparent way.`
3. `Clean execution` – `We care about a tidy work area, aesthetic installation and safe system operation.`
4. `Long-term thinking` – `We recommend systems built for comfort, reliability and efficient operation.`

## Services section

Title: `Our services`

Intro: `From cooling to heating, from air conditioners to heat pumps, from plumbing to cold rooms – FTHERM solutions for homes and businesses.`

Services:

1. `Air conditioning installation`  
   `Professional installation of new air conditioning units in flats, houses, offices and commercial spaces. We also help choose the right capacity and location.`

2. `AC service and repair`  
   `Diagnostics, maintenance and repair of existing air conditioning systems. The goal is reliable operation, better efficiency and longer equipment life.`

3. `AC cleaning and disinfection`  
   `Regular cleaning can help provide fresher air, quieter operation and more efficient cooling or heating. It is especially useful before the season starts.`

4. `Heat pumps`  
   `Modern, energy-efficient heating and cooling solutions for new buildings and upgrades of existing systems.`

5. `Underfloor and wall heating`  
   `Comfortable systems that provide even heat distribution in houses, apartments and modern buildings.`

6. `Radiators and heating systems`  
   `Installation, replacement and maintenance of radiators, pipework, manifolds and heating systems.`

7. `Plumbing`  
   `Reliable installation and repair of water pipes, connections and mechanical building-service works.`

8. `Cold rooms and refrigeration systems`  
   `Design, installation, service and maintenance of cold rooms and commercial or industrial refrigeration systems.`

Card CTA: `Details`

## Seasonal AC cleaning section

Title: `Do not wait for the heatwave – prepare in time`

Text: `An air conditioner circulates the air in the room, so regular cleaning matters both for the equipment and for everyday comfort. Pre-season maintenance can help prevent unpleasant odours, weaker performance and unexpected issues.`

Bullets:

- `Fresher, cleaner air at home or work`
- `More efficient cooling and heating`
- `Quieter and more balanced operation`
- `Longer equipment lifetime`

CTA: `Request AC cleaning`

## Heat pump section

Title: `Modern heating and cooling with heat pumps`

Text: `Heat pump systems can provide year-round comfort: heating in winter, cooling in summer, and they can be combined with underfloor heating, wall heating, radiators or other building-service systems.`

CTA: `Request a heat pump solution`

## Process section

Title: `How we work`

Steps:

1. `Contact` – `You tell us what you need, and we agree on the next step.`
2. `Survey or diagnostics` – `We inspect the space, device or system and evaluate the options.`
3. `Quote and schedule` – `We provide a clear quote and agree on the timing of the work.`
4. `Execution` – `We work precisely, cleanly and with professional attention to detail.`
5. `Handover and advice` – `At the end, we explain usage, maintenance and next steps.`

## About section

Title: `FTHERM – a reliable partner for heating and cooling`

Text: `FTHERM aims to provide well-planned, safe and long-lasting comfort solutions for cooling, heating and plumbing. Whether it is an air conditioner, heat pump, underfloor heating, radiator, plumbing system or cold room, the work is always adapted to the needs of the specific space.`

## Project gallery section

Title: `References and our work`

Text: `View previous work: air conditioning installation, heat pump systems, underfloor heating, plumbing and refrigeration projects.`

Placeholder note for Codex: Add real project photos when available. Do not generate fake customer reviews or fake company claims.

## Testimonials section

Title: `Customer feedback`

Placeholder text: `Real customer reviews should be added later. Do not generate fake names or fake ratings.`

## FAQ

1. `When should I request AC cleaning?`  
   `Ideally before the cooling season, and also before the heating season if the unit is used for heating. With regular use, inspection and cleaning are recommended at least once a year.`

2. `What size air conditioner do I need?`  
   `It depends on room size, insulation, orientation, windows and how the space is used. An accurate recommendation can be made after a survey or consultation.`

3. `Is a heat pump only for heating?`  
   `No. Many heat pump systems can be used for both heating and cooling when paired with the right heat distribution system.`

4. `Do you work with cold rooms?`  
   `Yes. FTHERM also works with refrigeration technology and cold rooms. The exact solution should be planned according to the space and intended use.`

5. `Can I request a quote for multiple services at once?`  
   `Yes. For air conditioning, heating, plumbing and refrigeration, it is often best to review the whole system together so the final solution is clear and efficient.`

## Final CTA

Title: `Request a quote for an FTHERM solution`

Text: `Briefly describe what you need and we will contact you. Air conditioning, heating, cooling, plumbing or cold rooms – we will help you find the right solution.`

Buttons:

- `Request a quote`
- `Call now`

---

## 7) Image and asset generation prompts

Use realistic, high-quality, non-branded images. Do not use fake logos on uniforms, vehicles or equipment. Avoid clearly identifiable faces unless stock/photo consent exists. Export in WebP and provide responsive sizes.

### Hero image

Filename: `hero-ftherm-technician-ac-installation.webp`

Alt HU: `FTHERM szakember klímaberendezést szerel egy modern otthonban`

Alt SR: `FTHERM majstor montira klima uređaj u modernom domu`

Alt EN: `FTHERM technician installing an air conditioner in a modern home`

Prompt:

`Realistic professional photography of an HVAC technician installing a sleek white wall-mounted air conditioner in a bright modern family living room, clean tools, protective floor cover, natural daylight, premium home interior, technical but friendly mood, no visible brand logos, no readable text, 35mm lens, high detail, realistic colors, 16:9 composition, space on left side for website headline.`

### AC cleaning image

Filename: `service-ac-cleaning.webp`

Prompt:

`Realistic close-up photo of an HVAC technician cleaning and disinfecting the indoor unit of a wall-mounted air conditioner, protective cover bag under the unit, clean white interior, professional tools, fresh and hygienic mood, no logos, no readable text, high detail, 4:3 composition.`

### Heat pump image

Filename: `service-heat-pump-modern-house.webp`

Prompt:

`Realistic photo of a modern air-to-water heat pump outdoor unit next to a clean European family house, subtle winter or early spring atmosphere, neat installation, insulated pipes, premium residential energy-efficient heating system, no logos, no readable text, 4:3 composition.`

### Underfloor heating image

Filename: `service-underfloor-heating-installation.webp`

Prompt:

`Realistic construction-site photo of underfloor heating pipes installed evenly on insulation panels in a modern house, technician checking the system, clean organized work, warm natural light, technical details visible, no logos, 4:3 composition.`

### Plumbing / manifold image

Filename: `service-plumbing-heating-manifold.webp`

Prompt:

`Realistic photo of a clean mechanical room with heating manifold, water pipes, valves and gauges, technician adjusting the system, modern building services installation, organized and professional, no logos, no readable labels, 4:3 composition.`

### Cold room / refrigeration image

Filename: `service-cold-room-refrigeration.webp`

Prompt:

`Realistic photo of a technician inspecting a clean commercial cold room with white insulated panels and refrigeration evaporator unit, professional refrigeration service, bright hygienic environment, no brand logos, no readable text, 4:3 composition.`

### Radiator image

Filename: `service-radiator-heating.webp`

Prompt:

`Realistic photo of a modern radiator installation in a clean home interior, technician checking valves and connections, neat pipework, warm comfortable atmosphere, no logos, no readable text, 4:3 composition.`

### Gallery placeholders

Create 6 gallery placeholders:

1. air conditioner installation in living room
2. outdoor AC unit mounted neatly on wall
3. heat pump beside a family house
4. underfloor heating pipe layout
5. heating manifold and plumbing system
6. commercial cold room service

All gallery images must have descriptive alt text in all three languages.

## 8) SEO implementation requirements

Add SEO for each language:

- localized meta title
- localized meta description
- canonical URL
- hreflang alternates for HU / SR / EN
- Open Graph title, description and image
- structured data for a local service business if the project already has business details
- service pages should have unique titles and descriptions

Suggested service page URL slugs:

Hungarian:

- `/hu/szolgaltatasok/klimaszereles`
- `/hu/szolgaltatasok/klimaszerviz`
- `/hu/szolgaltatasok/klimatisztitas`
- `/hu/szolgaltatasok/hoszivattyuk`
- `/hu/szolgaltatasok/padlo-es-falfutes`
- `/hu/szolgaltatasok/radiatorok`
- `/hu/szolgaltatasok/vizszereles`
- `/hu/szolgaltatasok/hutokamrak`

Serbian Latin:

- `/sr/usluge/ugradnja-klime`
- `/sr/usluge/servis-klima-uredjaja`
- `/sr/usluge/ciscenje-klime`
- `/sr/usluge/toplotne-pumpe`
- `/sr/usluge/podno-i-zidno-grejanje`
- `/sr/usluge/radijatori`
- `/sr/usluge/vodoinstalacije`
- `/sr/usluge/rashladne-komore`

English:

- `/en/services/air-conditioning-installation`
- `/en/services/ac-service`
- `/en/services/ac-cleaning`
- `/en/services/heat-pumps`
- `/en/services/underfloor-and-wall-heating`
- `/en/services/radiators`
- `/en/services/plumbing`
- `/en/services/cold-rooms`

If the current project already uses a different locale/slug structure, follow the existing structure instead.

## 9) Components to create or update

Create reusable components where possible:

- `FthermTopBar`
- `FthermHeader`
- `LanguageSwitcher`
- `HeroSection`
- `TrustStrip`
- `ServiceCard`
- `ServicesGrid`
- `SeasonalMaintenanceSection`
- `HeatPumpHighlight`
- `ProcessSteps`
- `AboutSection`
- `ProjectGallery`
- `TestimonialsPlaceholder`
- `FaqAccordion`
- `ContactCta`
- `Footer`
- `FloatingContactButtons`

For Laravel Blade, create partials/components in the project’s existing theme structure. For Vue/React, create equivalent components inside the existing component directory.

## 10) Contact form requirements

Create or update a simple quote request form:

Fields:

- name
- phone
- email
- service type dropdown
- city / location
- message
- preferred contact method
- privacy consent checkbox

Service type dropdown values should be localized:

- Air conditioning installation
- AC service / repair
- AC cleaning
- Heat pump
- Underfloor / wall heating
- Radiators / heating system
- Plumbing
- Cold room / refrigeration
- Other

Validation:

- name required
- phone or email required
- message required
- consent required

After submit:

- show localized success message
- do not expose technical errors to the user
- protect with CSRF and spam protection if available

Success messages:

HU: `Köszönjük! Megkaptuk az üzenetét, hamarosan felvesszük Önnel a kapcsolatot.`

SR: `Hvala! Primili smo vašu poruku i uskoro ćemo vas kontaktirati.`

EN: `Thank you! We received your message and will contact you soon.`

## 11) Accessibility and performance

- Fully responsive from 360px to large desktop.
- Use semantic HTML.
- Buttons and links must have accessible labels.
- Language switcher must be keyboard accessible.
- FAQ accordion must support keyboard navigation and ARIA attributes.
- Images must have width/height to avoid layout shift.
- Lazy load below-the-fold images.
- Use WebP/AVIF where possible.
- Keep hero image optimized.
- Avoid heavy animation libraries unless already used in the project.
- Respect `prefers-reduced-motion`.
- Ensure high contrast for text and CTA buttons.

## 12) Footer

Footer columns:

1. Brand summary
2. Services
3. Contact
4. Languages / legal links

Footer brand copy:

HU: `FTHERM – hűtés, fűtés, vízszerelés és hűtéstechnika egy kézben.`

SR: `FTHERM – hlađenje, grejanje, vodoinstalacije i rashladna tehnika na jednom mestu.`

EN: `FTHERM – cooling, heating, plumbing and refrigeration technology in one place.`

Legal links:

- Privacy policy
- Terms of use
- Cookie settings, if available

## 13) Acceptance criteria

The implementation is complete when:

- Homepage is fully redesigned and responsive.
- All key services are visible without the user needing to search.
- There are strong CTAs in the hero, header, service section and final CTA.
- Phone CTA is clickable on mobile if phone number exists.
- HU / SR / EN content works and Serbian is Latin script.
- SEO meta tags are localized.
- Images are optimized and have localized alt texts.
- Form validation works.
- Layout does not break on mobile.
- No fake reviews, fake certificates or fake “24/7” claims are added.
- Existing project routes, shop functionality and admin functionality remain intact.
- Code is clean, componentized and follows existing project conventions.

## 14) Final reminder for Codex

Implement this as a polished, production-ready website section/theme, not as a rough prototype. The result should make FTHERM look like a reliable modern HVAC/building-services company that can handle both residential and business technical work.
