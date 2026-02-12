<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageContent;
use Illuminate\Http\Request;

class HomepageContentController extends Controller
{
    public function index()
    {
        $contents = HomepageContent::all();
        return view('admin.homepage.index', compact('contents'));
    }

    public function edit(HomepageContent $homepage)
    {
        return view('admin.homepage.edit', compact('homepage'));
    }

    public function update(Request $request, HomepageContent $homepage)
    {
        $validated = $request->validate([
            'value_en' => 'required|string',
            'value_sr' => 'required|string',
            'value_hu' => 'required|string',
        ]);

        $homepage->update([
            'value' => [
                'en' => $validated['value_en'],
                'sr' => $validated['value_sr'],
                'hu' => $validated['value_hu'],
            ],
        ]);

        return redirect()->route('admin.homepage.index')->with('success', 'Sadržaj uspešno ažuriran');
    }
}
