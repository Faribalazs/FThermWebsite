<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class CatalogSettingController extends Controller
{
    public function index()
    {
        return view('admin.catalog-settings.index', [
            'shopEnabled' => shop_enabled(),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'shop_enabled' => 'required|in:true,false',
        ]);

        Setting::updateOrCreate(
            ['key' => 'shop_enabled'],
            ['value' => $validated['shop_enabled']]
        );

        return back()->with('success', 'Podešavanja kataloga su uspešno sačuvana.');
    }
}
