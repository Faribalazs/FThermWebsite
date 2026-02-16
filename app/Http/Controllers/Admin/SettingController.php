<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $maintenanceMode = Setting::where('key', 'maintenance_mode')->value('value');
        return view('admin.settings.index', compact('maintenanceMode'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'maintenance_mode' => 'required|in:true,false',
        ]);

        Setting::updateOrCreate(
            ['key' => 'maintenance_mode'],
            ['value' => $validated['maintenance_mode']]
        );

        return back()->with('success', 'Settings updated successfully.');
    }
}
