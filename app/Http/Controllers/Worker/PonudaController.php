<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\Ponuda;
use App\Models\PonudaSection;
use App\Models\PonudaItem;
use App\Models\InternalProduct;
use App\Models\ActivityLog;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PonudaController extends Controller
{
    public function index(Request $request)
    {
        $query = Ponuda::where('worker_id', auth('worker')->id())
            ->with(['sections.items.product']);

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

        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
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
        $products = InternalProduct::orderBy('name')->get();
        return view('worker.ponude.create', compact('products'));
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
                'status'            => 'draft',
            ]);

            foreach ($validated['sections'] as $sectionData) {
                $section = $ponuda->sections()->create([
                    'title'         => $sectionData['title'],
                    'hours_spent'   => $sectionData['hours_spent'] ?? null,
                    'service_price' => $sectionData['service_price'] ?? null,
                ]);

                if (!empty($sectionData['items'])) {
                    foreach ($sectionData['items'] as $itemData) {
                        if (empty($itemData['product_id'])) continue;
                        $product = InternalProduct::find($itemData['product_id']);
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
            $total = $ponuda->calculateTotal();
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
        if ($ponuda->worker_id !== auth('worker')->id()) {
            abort(403);
        }
        $ponuda->load(['sections.items.product']);
        return view('worker.ponude.show', compact('ponuda'));
    }

    public function edit(Ponuda $ponuda)
    {
        if ($ponuda->worker_id !== auth('worker')->id()) {
            abort(403);
        }
        $ponuda->load(['sections.items.product']);
        $products = InternalProduct::orderBy('name')->get();
        return view('worker.ponude.edit', compact('ponuda', 'products'));
    }

    public function update(Request $request, Ponuda $ponuda)
    {
        if ($ponuda->worker_id !== auth('worker')->id()) {
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
            ]);

            // Replace all sections/items
            $ponuda->sections()->each(fn($s) => $s->items()->delete());
            $ponuda->sections()->delete();

            foreach ($validated['sections'] as $sectionData) {
                $section = $ponuda->sections()->create([
                    'title'         => $sectionData['title'],
                    'hours_spent'   => $sectionData['hours_spent'] ?? null,
                    'service_price' => $sectionData['service_price'] ?? null,
                ]);

                if (!empty($sectionData['items'])) {
                    foreach ($sectionData['items'] as $itemData) {
                        if (empty($itemData['product_id'])) continue;
                        $product = InternalProduct::find($itemData['product_id']);
                        $section->items()->create([
                            'product_id'    => $itemData['product_id'],
                            'quantity'      => $itemData['quantity'] ?? 1,
                            'price_at_time' => $product->price,
                        ]);
                    }
                }
            }

            $ponuda->load('sections.items');
            $total = $ponuda->calculateTotal();
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
        if ($ponuda->worker_id !== auth('worker')->id()) {
            abort(403);
        }
        $ponuda->delete();
        return redirect()->route('worker.ponude.index')
            ->with('success', 'Ponuda obrisana.');
    }

    public function exportPdf(Ponuda $ponuda)
    {
        if ($ponuda->worker_id !== auth('worker')->id()) {
            abort(403);
        }

        $ponuda->load(['sections.items.product', 'worker']);

        $companyName = Setting::where('key', 'company_name')->value('value') ?? 'F-Therm d.o.o.';
        $companyPhone = Setting::where('key', 'company_phone')->value('value') ?? '';
        $companyEmail = Setting::where('key', 'company_email')->value('value') ?? '';
        $companyAddress = Setting::where('key', 'company_address')->value('value') ?? '';
        $companyPib = Setting::where('key', 'company_pib')->value('value') ?? '';
        $companyMaticniBroj = Setting::where('key', 'company_maticni_broj')->value('value') ?? '';
        $companySifraDelatnosti = Setting::where('key', 'company_sifra_delatnosti')->value('value') ?? '';
        $companyBankAccount = Setting::where('key', 'company_bank_account')->value('value') ?? '';
        $kmPrice = Setting::where('key', 'km_price')->value('value') ?? 0;

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
