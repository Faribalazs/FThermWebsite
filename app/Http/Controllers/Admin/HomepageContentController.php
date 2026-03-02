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

    public function create()
    {
        return view('admin.homepage.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|max:255|unique:homepage_contents,key',
            'value_en' => 'required|string',
            'value_sr' => 'required|string',
            'value_hu' => 'required|string',
        ]);

        HomepageContent::create([
            'key' => $validated['key'],
            'value' => [
                'en' => $validated['value_en'],
                'sr' => $validated['value_sr'],
                'hu' => $validated['value_hu'],
            ],
        ]);

        return redirect()->route('admin.homepage-contents.index')->with('success', 'Sekcija uspešno kreirana.');
    }

    public function edit(HomepageContent $homepage_content)
    {
        $homepage = $homepage_content;
        return view('admin.homepage.edit', compact('homepage'));
    }

    public function update(Request $request, HomepageContent $homepage_content)
    {
        $validated = $request->validate([
            'value_en' => 'required|string',
            'value_sr' => 'required|string',
            'value_hu' => 'required|string',
        ]);

        $homepage_content->update([
            'value' => [
                'en' => $validated['value_en'],
                'sr' => $validated['value_sr'],
                'hu' => $validated['value_hu'],
            ],
        ]);

        return redirect()->route('admin.homepage-contents.index')->with('success', 'Sadržaj uspešno ažuriran.');
    }

    public function destroy(HomepageContent $homepage_content)
    {
        $homepage_content->delete();

        return redirect()->route('admin.homepage-contents.index')->with('success', 'Sekcija uspešno obrisana.');
    }
}
