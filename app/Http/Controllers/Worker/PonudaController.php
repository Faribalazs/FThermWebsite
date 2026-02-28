<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\Ponuda;
use App\Models\PonudaSection;
use App\Models\PonudaItem;
use App\Models\InternalProduct;
use App\Models\ActivityLog;
use App\Models\Contact;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PonudaController extends Controller
{
    public function index(Request $request)
    {
        $query = Ponuda::where('worker_id', auth('worker')->id())
            ->withCount('sections');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('client_name', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sorting (whitelist to prevent column injection)
        $allowedSort = ['created_at', 'total_amount', 'location', 'status'];
        $sortBy = in_array($request->get('sort_by'), $allowedSort) ? $request->get('sort_by') : 'created_at';
        $sortOrder = $request->get('sort_order') === 'asc' ? 'asc' : 'desc';
        $query->orderBy($sortBy, $sortOrder);

        $ponude = $query->paginate(15)->withQueryString();

        $locations = Ponuda::where('worker_id', auth('worker')->id())
            ->distinct()
            ->pluck('location')
            ->sort()
            ->values();

        return view('worker.ponude.index', compact('ponude', 'locations'));
    }

    public function create()
    {
        $products = InternalProduct::select('id', 'name', 'unit', 'price')
            ->orderBy('name')->get();
        $contacts = \App\Models\Contact::where('created_by', auth('worker')->id())->orderBy('type')->orderBy('client_name')->orderBy('company_name')->get();
        return view('worker.ponude.create', compact('products', 'contacts'));
    }

    public function autosave(Request $request)
    {
        $draftId = $request->input('draft_id');
        $ponuda = null;

        if ($draftId) {
            $ponuda = Ponuda::where('id', $draftId)
                ->where('worker_id', auth('worker')->id())
                ->where('status', 'draft')
                ->first();
        }

        $attrs = [
            'worker_id'         => auth('worker')->id(),
            'client_type'       => $request->input('client_type') ?: 'fizicko_lice',
            'client_name'       => $request->input('client_name') ?: null,
            'client_address'    => $request->input('client_address') ?: null,
            'company_name'      => $request->input('company_name') ?: null,
            'pib'               => $request->input('pib') ?: null,
            'maticni_broj'      => $request->input('maticni_broj') ?: null,
            'company_address'   => $request->input('company_address') ?: null,
            'client_phone'      => $request->input('client_phone') ?: null,
            'client_email'      => $request->input('client_email') ?: null,
            'location'          => $request->input('location') ?: null,
            'km_to_destination' => $request->input('km_to_destination') ?: null,
            'hourly_rate'       => $request->input('hourly_rate') ?: null,
            'notes'             => $request->input('notes') ?: null,
            'status'            => 'draft',
        ];

        if ($ponuda) {
            $ponuda->update($attrs);
        } else {
            $ponuda = Ponuda::create($attrs);
        }

        // Batch-load all needed products (eliminates N+1 per item)
        $allProductIds = collect($request->input('sections', []))
            ->flatMap(fn($s) => collect($s['items'] ?? [])->pluck('product_id')->filter())
            ->unique()->values()->all();
        $productMap = $allProductIds ? InternalProduct::whereIn('id', $allProductIds)->select('id', 'price')->get()->keyBy('id') : collect();

        // Wipe and rebuild sections / items inside a transaction
        // (cascade FK on ponuda_items ensures items are deleted when sections are deleted)
        DB::transaction(function () use ($ponuda, $request, $productMap) {
            $ponuda->sections()->delete();

            foreach ($request->input('sections', []) as $sectionData) {
                // In autosave/draft context, keep sections even without a title
                // so that items (materials) are not lost while the user is still typing.
                $sectionTitle = trim($sectionData['title'] ?? '');
                if ($sectionTitle === '') {
                    $sectionTitle = 'Usluga'; // temporary placeholder
                }
                $section = $ponuda->sections()->create([
                    'title'         => $sectionTitle,
                    'hours_spent'   => $sectionData['hours_spent'] ?: null,
                    'service_price' => $sectionData['service_price'] ?: null,
                ]);
                foreach ($sectionData['items'] ?? [] as $itemData) {
                    if (empty($itemData['product_id'])) continue;
                    $product = $productMap->get($itemData['product_id']);
                    if (!$product) continue;
                    $section->items()->create([
                        'product_id'    => $itemData['product_id'],
                        'quantity'      => max(1, (int) ($itemData['quantity'] ?? 1)),
                        'price_at_time' => $product->price,
                    ]);
                }
            }
        });

        $ponuda->load('sections.items');
        $kmPrice = (float) (Setting::where('key', 'km_price')->value('value') ?? 0);
        $ponuda->update(['total_amount' => $ponuda->calculateTotal($kmPrice)]);

        return response()->json([
            'id'       => $ponuda->id,
            'saved_at' => now()->format('H:i:s'),
            'edit_url' => route('worker.ponude.edit', $ponuda),
        ]);
    }

    public function autosaveEdit(Request $request, Ponuda $ponuda)
    {
        if ((int)$ponuda->worker_id !== (int)auth('worker')->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $ponuda->update([
            'client_type'       => $request->input('client_type') ?: $ponuda->client_type,
            'client_name'       => $request->input('client_name') ?: null,
            'client_address'    => $request->input('client_address') ?: null,
            'company_name'      => $request->input('company_name') ?: null,
            'pib'               => $request->input('pib') ?: null,
            'maticni_broj'      => $request->input('maticni_broj') ?: null,
            'company_address'   => $request->input('company_address') ?: null,
            'client_phone'      => $request->input('client_phone') ?: null,
            'client_email'      => $request->input('client_email') ?: null,
            'location'          => $request->input('location') ?: null,
            'km_to_destination' => $request->input('km_to_destination') ?: null,
            'hourly_rate'       => $request->input('hourly_rate') ?: null,
            'notes'             => $request->input('notes') ?: null,
        ]);

        // Batch-load all needed products (eliminates N+1 per item)
        $allProductIds = collect($request->input('sections', []))
            ->flatMap(fn($s) => collect($s['items'] ?? [])->pluck('product_id')->filter())
            ->unique()->values()->all();
        $productMap = $allProductIds ? InternalProduct::whereIn('id', $allProductIds)->select('id', 'price')->get()->keyBy('id') : collect();

        // Wipe and rebuild sections / items inside a transaction
        // (cascade FK on ponuda_items ensures items are deleted when sections are deleted)
        DB::transaction(function () use ($ponuda, $request, $productMap) {
            $ponuda->sections()->delete();

            foreach ($request->input('sections', []) as $sectionData) {
                $sectionTitle = trim($sectionData['title'] ?? '');
                if ($sectionTitle === '') {
                    $sectionTitle = 'Usluga';
                }
                $section = $ponuda->sections()->create([
                    'title'         => $sectionTitle,
                    'hours_spent'   => $sectionData['hours_spent'] ?: null,
                    'service_price' => $sectionData['service_price'] ?: null,
                ]);
                foreach ($sectionData['items'] ?? [] as $itemData) {
                    if (empty($itemData['product_id'])) continue;
                    $product = $productMap->get($itemData['product_id']);
                    if (!$product) continue;
                    $section->items()->create([
                        'product_id'    => $itemData['product_id'],
                        'quantity'      => max(1, (int) ($itemData['quantity'] ?? 1)),
                        'price_at_time' => $product->price,
                    ]);
                }
            }
        });

        $ponuda->load('sections.items');
        $kmPrice = (float) (Setting::where('key', 'km_price')->value('value') ?? 0);
        $ponuda->update(['total_amount' => $ponuda->calculateTotal($kmPrice)]);

        return response()->json(['saved_at' => now()->format('H:i:s')]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_type'       => 'required|in:fizicko_lice,pravno_lice',
            'client_name'       => 'required_if:client_type,fizicko_lice|nullable|string|max:255',
            'client_address'    => 'nullable|string|max:255',
            'company_name'      => 'required_if:client_type,pravno_lice|nullable|string|max:255',
            'pib'               => 'nullable|string|max:20',
            'maticni_broj'      => 'nullable|string|max:20',
            'company_address'   => 'nullable|string|max:255',
            'client_phone'      => 'nullable|string|max:20',
            'client_email'      => 'nullable|email|max:255',
            'location'          => 'required|string|max:255',
            'km_to_destination' => 'nullable|numeric|min:0',
            'hourly_rate'       => 'nullable|numeric|min:0',
            'notes'             => 'nullable|string|max:2000',
            'sections'          => 'required|array|min:1',
            'sections.*.title'          => 'required|string|max:255',
            'sections.*.hours_spent'    => 'nullable|numeric|min:0',
            'sections.*.service_price'  => 'nullable|numeric|min:0',
            'sections.*.items'          => 'nullable|array',
            'sections.*.items.*.product_id' => 'nullable|exists:internal_products,id',
            'sections.*.items.*.quantity'   => 'nullable|integer|min:1',
        ], [
            'client_type.required'      => 'Tip klijenta je obavezan.',
            'client_type.in'            => 'Tip klijenta mora biti fizičko ili pravno lice.',
            'client_name.required_if'   => 'Ime i prezime klijenta je obavezno.',
            'company_name.required_if'  => 'Naziv firme je obavezan.',
            'client_email.email'        => 'Email adresa nije ispravna.',
            'location.required'         => 'Lokacija radova je obavezna.',
            'km_to_destination.numeric' => 'Kilometraža mora biti broj.',
            'hourly_rate.numeric'       => 'Cena po satu mora biti broj.',
            'sections.required'         => 'Dodajte barem jednu uslugu.',
            'sections.min'              => 'Dodajte barem jednu uslugu.',
            'sections.*.title.required' => 'Naziv usluge je obavezan.',
            'sections.*.hours_spent.numeric'   => 'Sati moraju biti broj.',
            'sections.*.service_price.numeric' => 'Cena usluge mora biti broj.',
            'sections.*.items.*.product_id.exists'  => 'Izabrani proizvod ne postoji.',
            'sections.*.items.*.quantity.integer'    => 'Količina mora biti ceo broj.',
            'sections.*.items.*.quantity.min'        => 'Količina mora biti najmanje 1.',
        ]);

        DB::beginTransaction();

        try {
            // Reuse existing draft if one was being autosaved
            $draftId = $request->input('draft_id');
            $ponuda = null;
            if ($draftId) {
                $ponuda = Ponuda::where('id', $draftId)
                    ->where('worker_id', auth('worker')->id())
                    ->where('status', 'draft')
                    ->first();
                if ($ponuda) {
                    $ponuda->load('sections.items');
                    foreach ($ponuda->sections as $section) {
                        $section->items()->delete();
                    }
                    $ponuda->sections()->delete();
                    $ponuda->update([
                        'client_type'       => $validated['client_type'],
                        'client_name'       => $validated['client_name'] ?? null,
                        'client_address'    => $validated['client_address'] ?? null,
                        'company_name'      => $validated['company_name'] ?? null,
                        'pib'               => $validated['pib'] ?? null,
                        'maticni_broj'      => $validated['maticni_broj'] ?? null,
                        'company_address'   => $validated['company_address'] ?? null,
                        'client_phone'      => $validated['client_phone'] ?? null,
                        'client_email'      => $validated['client_email'] ?? null,
                        'location'          => $validated['location'],
                        'km_to_destination' => $validated['km_to_destination'] ?? null,
                        'hourly_rate'       => $validated['hourly_rate'] ?? null,
                        'notes'             => $validated['notes'] ?? null,
                        'status'            => 'active',
                    ]);
                }
            }
            if (!$ponuda) {
                $ponuda = Ponuda::create([
                    'worker_id'         => auth('worker')->id(),
                    'client_type'       => $validated['client_type'],
                    'client_name'       => $validated['client_name'] ?? null,
                    'client_address'    => $validated['client_address'] ?? null,
                    'company_name'      => $validated['company_name'] ?? null,
                    'pib'               => $validated['pib'] ?? null,
                    'maticni_broj'      => $validated['maticni_broj'] ?? null,
                    'company_address'   => $validated['company_address'] ?? null,
                    'client_phone'      => $validated['client_phone'] ?? null,
                    'client_email'      => $validated['client_email'] ?? null,
                    'location'          => $validated['location'],
                    'km_to_destination' => $validated['km_to_destination'] ?? null,
                    'hourly_rate'       => $validated['hourly_rate'] ?? null,
                    'notes'             => $validated['notes'] ?? null,
                    'status'            => 'active',
                ]);
            }

            // Batch-load all needed products (eliminates N+1 per item)
            $allProductIds = collect($validated['sections'])
                ->flatMap(fn($s) => collect($s['items'] ?? [])->pluck('product_id')->filter())
                ->unique()->values()->all();
            $productMap = $allProductIds ? InternalProduct::whereIn('id', $allProductIds)->get()->keyBy('id') : collect();

            foreach ($validated['sections'] as $sectionData) {
                $section = $ponuda->sections()->create([
                    'title'         => $sectionData['title'],
                    'hours_spent'   => $sectionData['hours_spent'] ?? null,
                    'service_price' => $sectionData['service_price'] ?? null,
                ]);

                if (!empty($sectionData['items'])) {
                    foreach ($sectionData['items'] as $itemData) {
                        if (empty($itemData['product_id'])) continue;
                        $product = $productMap->get($itemData['product_id']);
                        if (!$product) continue;
                        $section->items()->create([
                            'product_id'    => $itemData['product_id'],
                            'quantity'      => $itemData['quantity'] ?? 1,
                            'price_at_time' => $product->price,
                        ]);
                        // NOTE: No inventory deduction — this is only an offer (ponuda)
                    }
                }
            }

            $ponuda->load('sections.items');
            $kmPrice = (float) (Setting::where('key', 'km_price')->value('value') ?? 0);
            $total = $ponuda->calculateTotal($kmPrice);
            $ponuda->update(['total_amount' => $total]);

            $clientDisplay = $validated['client_type'] === 'pravno_lice'
                ? $validated['company_name']
                : $validated['client_name'];

            ActivityLog::log(
                auth('worker')->id(),
                'create',
                'ponuda',
                $ponuda->id,
                "Kreirao ponudu za: {$clientDisplay}",
                [
                    'client_type'    => $validated['client_type'],
                    'client_display' => $clientDisplay,
                    'location'       => $validated['location'],
                    'total_amount'   => $total,
                ]
            );

            // Save client data as contact if checkbox was checked
            if ($request->has('save_as_contact')) {
                $contactData = [
                    'created_by' => auth('worker')->id(),
                    'type' => $validated['client_type'],
                    'client_name' => $validated['client_name'] ?? null,
                    'client_address' => $validated['client_address'] ?? null,
                    'client_phone' => $validated['client_phone'] ?? null,
                    'client_email' => $validated['client_email'] ?? null,
                ];

                if ($validated['client_type'] === 'pravno_lice') {
                    $contactData['company_name'] = $validated['company_name'] ?? null;
                    $contactData['pib'] = $validated['pib'] ?? null;
                    $contactData['maticni_broj'] = $validated['maticni_broj'] ?? null;
                    $contactData['company_address'] = $validated['company_address'] ?? null;
                }

                Contact::create($contactData);
            }

            DB::commit();

            return redirect()->route('worker.ponude.show', $ponuda)
                ->with('success', 'Ponuda uspešno kreirana.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Greška: ' . $e->getMessage());
        }
    }

    public function show(Ponuda $ponuda)
    {
        if ((int)$ponuda->worker_id !== (int)auth('worker')->id()) {
            abort(403);
        }
        $ponuda->load(['sections.items.product']);
        $kmPrice = Setting::where('key', 'km_price')->value('value') ?? 0;
        return view('worker.ponude.show', compact('ponuda', 'kmPrice'));
    }

    public function edit(Ponuda $ponuda)
    {
        if ((int)$ponuda->worker_id !== (int)auth('worker')->id()) {
            abort(403);
        }
        $ponuda->load(['sections.items.product']);
        $products = InternalProduct::select('id', 'name', 'unit', 'price')
            ->orderBy('name')->get();
        $contacts = \App\Models\Contact::where('created_by', auth('worker')->id())->orderBy('type')->orderBy('client_name')->orderBy('company_name')->get();
        return view('worker.ponude.edit', compact('ponuda', 'products', 'contacts'));
    }

    public function update(Request $request, Ponuda $ponuda)
    {
        if ((int)$ponuda->worker_id !== (int)auth('worker')->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'client_type'       => 'required|in:fizicko_lice,pravno_lice',
            'client_name'       => 'required_if:client_type,fizicko_lice|nullable|string|max:255',
            'client_address'    => 'nullable|string|max:255',
            'company_name'      => 'required_if:client_type,pravno_lice|nullable|string|max:255',
            'pib'               => 'nullable|string|max:20',
            'maticni_broj'      => 'nullable|string|max:20',
            'company_address'   => 'nullable|string|max:255',
            'client_phone'      => 'nullable|string|max:20',
            'client_email'      => 'nullable|email|max:255',
            'location'          => 'required|string|max:255',
            'km_to_destination' => 'nullable|numeric|min:0',
            'hourly_rate'       => 'nullable|numeric|min:0',
            'notes'             => 'nullable|string|max:2000',
            'sections'          => 'required|array|min:1',
            'sections.*.title'          => 'required|string|max:255',
            'sections.*.hours_spent'    => 'nullable|numeric|min:0',
            'sections.*.service_price'  => 'nullable|numeric|min:0',
            'sections.*.items'          => 'nullable|array',
            'sections.*.items.*.product_id' => 'nullable|exists:internal_products,id',
            'sections.*.items.*.quantity'   => 'nullable|integer|min:1',
        ], [
            'client_type.required'      => 'Tip klijenta je obavezan.',
            'client_type.in'            => 'Tip klijenta mora biti fizičko ili pravno lice.',
            'client_name.required_if'   => 'Ime i prezime klijenta je obavezno.',
            'company_name.required_if'  => 'Naziv firme je obavezan.',
            'client_email.email'        => 'Email adresa nije ispravna.',
            'location.required'         => 'Lokacija radova je obavezna.',
            'km_to_destination.numeric' => 'Kilometraža mora biti broj.',
            'hourly_rate.numeric'       => 'Cena po satu mora biti broj.',
            'sections.required'         => 'Dodajte barem jednu uslugu.',
            'sections.min'              => 'Dodajte barem jednu uslugu.',
            'sections.*.title.required' => 'Naziv usluge je obavezan.',
            'sections.*.hours_spent.numeric'   => 'Sati moraju biti broj.',
            'sections.*.service_price.numeric' => 'Cena usluge mora biti broj.',
            'sections.*.items.*.product_id.exists'  => 'Izabrani proizvod ne postoji.',
            'sections.*.items.*.quantity.integer'    => 'Količina mora biti ceo broj.',
            'sections.*.items.*.quantity.min'        => 'Količina mora biti najmanje 1.',
        ]);

        DB::beginTransaction();

        try {
            $ponuda->update([
                'client_type'       => $validated['client_type'],
                'client_name'       => $validated['client_name'] ?? null,
                'client_address'    => $validated['client_address'] ?? null,
                'company_name'      => $validated['company_name'] ?? null,
                'pib'               => $validated['pib'] ?? null,
                'maticni_broj'      => $validated['maticni_broj'] ?? null,
                'company_address'   => $validated['company_address'] ?? null,
                'client_phone'      => $validated['client_phone'] ?? null,
                'client_email'      => $validated['client_email'] ?? null,
                'location'          => $validated['location'],
                'km_to_destination' => $validated['km_to_destination'] ?? null,
                'hourly_rate'       => $validated['hourly_rate'] ?? null,
                'notes'             => $validated['notes'] ?? null,
                'status'            => 'active',
            ]);

            // Replace all sections/items
            $ponuda->sections()->each(fn($s) => $s->items()->delete());
            $ponuda->sections()->delete();

            // Batch-load all needed products (eliminates N+1 per item)
            $allProductIds = collect($validated['sections'])
                ->flatMap(fn($s) => collect($s['items'] ?? [])->pluck('product_id')->filter())
                ->unique()->values()->all();
            $productMap = $allProductIds ? InternalProduct::whereIn('id', $allProductIds)->get()->keyBy('id') : collect();

            foreach ($validated['sections'] as $sectionData) {
                $section = $ponuda->sections()->create([
                    'title'         => $sectionData['title'],
                    'hours_spent'   => $sectionData['hours_spent'] ?? null,
                    'service_price' => $sectionData['service_price'] ?? null,
                ]);

                if (!empty($sectionData['items'])) {
                    foreach ($sectionData['items'] as $itemData) {
                        if (empty($itemData['product_id'])) continue;
                        $product = $productMap->get($itemData['product_id']);
                        if (!$product) continue;
                        $section->items()->create([
                            'product_id'    => $itemData['product_id'],
                            'quantity'      => $itemData['quantity'] ?? 1,
                            'price_at_time' => $product->price,
                        ]);
                    }
                }
            }

            $ponuda->load('sections.items');
            $kmPrice = (float) (Setting::where('key', 'km_price')->value('value') ?? 0);
            $total = $ponuda->calculateTotal($kmPrice);
            $ponuda->update(['total_amount' => $total]);

            DB::commit();

            return redirect()->route('worker.ponude.show', $ponuda)
                ->with('success', 'Ponuda uspešno izmenjena.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Greška: ' . $e->getMessage());
        }
    }

    public function destroy(Ponuda $ponuda)
    {
        if ((int)$ponuda->worker_id !== (int)auth('worker')->id()) {
            abort(403);
        }
        $ponuda->delete();
        return redirect()->route('worker.ponude.index')
            ->with('success', 'Ponuda obrisana.');
    }

    public function exportPdf(Ponuda $ponuda)
    {
        if ((int)$ponuda->worker_id !== (int)auth('worker')->id()) {
            abort(403);
        }

        $ponuda->load(['sections.items.product', 'worker']);

        // Single query for all company settings
        $settings = Setting::whereIn('key', [
            'company_name', 'company_phone', 'company_email', 'company_address',
            'company_pib', 'company_maticni_broj', 'company_sifra_delatnosti', 'company_bank_account', 'km_price',
        ])->pluck('value', 'key');
        $companyName            = $settings->get('company_name', 'F-Therm d.o.o.');
        $companyPhone           = $settings->get('company_phone', '');
        $companyEmail           = $settings->get('company_email', '');
        $companyAddress         = $settings->get('company_address', '');
        $companyPib             = $settings->get('company_pib', '');
        $companyMaticniBroj     = $settings->get('company_maticni_broj', '');
        $companySifraDelatnosti = $settings->get('company_sifra_delatnosti', '');
        $companyBankAccount     = $settings->get('company_bank_account', '');
        $kmPrice                = $settings->get('km_price', 0);

        $pdf = Pdf::loadView('worker.ponude.pdf', compact(
            'ponuda', 'companyName', 'companyPhone', 'companyEmail', 'companyAddress',
            'companyPib', 'companyMaticniBroj', 'companySifraDelatnosti', 'companyBankAccount', 'kmPrice'
        ))
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true)
            ->setOption('defaultFont', 'DejaVu Sans')
            ->setPaper('a4');

        $clientName = $ponuda->client_type === 'pravno_lice'
            ? $ponuda->company_name
            : $ponuda->client_name;
        $fileName = 'Ponuda-' . str_replace(' ', '-', $clientName) . '-' . $ponuda->id . '.pdf';

        return $pdf->download($fileName);
    }
}
