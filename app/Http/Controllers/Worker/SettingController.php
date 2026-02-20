<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Warehouse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function index()
    {
        $kmPrice = Setting::where('key', 'km_price')->value('value') ?? '0';
        $companyName = Setting::where('key', 'company_name')->value('value') ?? '';
        $companyPib = Setting::where('key', 'company_pib')->value('value') ?? '';
        $companyMaticniBroj = Setting::where('key', 'company_maticni_broj')->value('value') ?? '';
        $companySifraDelatnosti = Setting::where('key', 'company_sifra_delatnosti')->value('value') ?? '';
        $companyPhone = Setting::where('key', 'company_phone')->value('value') ?? '';
        $companyEmail = Setting::where('key', 'company_email')->value('value') ?? '';
        $companyAddress = Setting::where('key', 'company_address')->value('value') ?? '';
        $companyBankAccount = Setting::where('key', 'company_bank_account')->value('value') ?? '';
        $invoiceCounterStart = Setting::where('key', 'invoice_counter_start')->value('value') ?? '1';
        
        // Load active warehouses
        $warehouses = Warehouse::where('is_active', true)->orderBy('name')->get();
        $currentUser = Auth::guard('worker')->user();
        
        return view('worker.settings.index', compact(
            'kmPrice',
            'companyName',
            'companyPib',
            'companyMaticniBroj',
            'companySifraDelatnosti',
            'companyPhone',
            'companyEmail',
            'companyAddress',
            'companyBankAccount',
            'invoiceCounterStart',
            'warehouses',
            'currentUser'
        ));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'km_price' => 'required|numeric|min:0',
            'company_name' => 'required|string|max:255',
            'company_pib' => 'required|string|max:50',
            'company_maticni_broj' => 'required|string|max:50',
            'company_sifra_delatnosti' => 'required|string|max:50',
            'company_phone' => 'required|string|max:50',
            'company_email' => 'required|email|max:255',
            'company_address' => 'required|string|max:500',
            'company_bank_account' => 'required|string|max:100',
            'invoice_counter_start' => 'required|integer|min:1',
            'primary_warehouse_id' => 'nullable|exists:warehouses,id',
        ]);

        $settings = [
            'km_price' => $validated['km_price'],
            'company_name' => $validated['company_name'],
            'company_pib' => $validated['company_pib'],
            'company_maticni_broj' => $validated['company_maticni_broj'],
            'company_sifra_delatnosti' => $validated['company_sifra_delatnosti'],
            'company_phone' => $validated['company_phone'],
            'company_email' => $validated['company_email'],
            'company_address' => $validated['company_address'],
            'company_bank_account' => $validated['company_bank_account'],
            'invoice_counter_start' => $validated['invoice_counter_start'],
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
        
        // Update user's primary warehouse
        $userId = Auth::guard('worker')->id();
        if ($userId) {
            User::where('id', $userId)->update(['primary_warehouse_id' => $validated['primary_warehouse_id']]);
        }

        return back()->with('success', 'Podešavanja uspešno ažurirana!');
    }
}
