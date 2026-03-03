<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    public function index()
    {
        $slides = Slide::orderBy('order')->paginate(20);
        return view('admin.slides.index', compact('slides'));
    }

    public function create()
    {
        return view('admin.slides.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image'           => 'required|image|max:4096',
            'title_sr'        => 'nullable|string|max:255',
            'title_en'        => 'nullable|string|max:255',
            'title_hu'        => 'nullable|string|max:255',
            'description_sr'  => 'nullable|string',
            'description_en'  => 'nullable|string',
            'description_hu'  => 'nullable|string',
            'button_text_sr'  => 'nullable|string|max:100',
            'button_text_en'  => 'nullable|string|max:100',
            'button_text_hu'  => 'nullable|string|max:100',
            'button_link'     => 'nullable|string|max:500',
            'text_position_x' => 'required|in:left,center,right',
            'text_position_y' => 'required|in:top,center,bottom',
            'order'           => 'required|integer',
            'active'          => 'boolean',
        ]);

        $imagePath = $request->file('image')->store('slides', 'public');

        Slide::create([
            'image'           => $imagePath,
            'title'           => ['sr' => $validated['title_sr'] ?? '', 'en' => $validated['title_en'] ?? '', 'hu' => $validated['title_hu'] ?? ''],
            'description'     => ['sr' => $validated['description_sr'] ?? '', 'en' => $validated['description_en'] ?? '', 'hu' => $validated['description_hu'] ?? ''],
            'button_text'     => ['sr' => $validated['button_text_sr'] ?? '', 'en' => $validated['button_text_en'] ?? '', 'hu' => $validated['button_text_hu'] ?? ''],
            'button_link'     => $validated['button_link'] ?? null,
            'text_position_x' => $validated['text_position_x'],
            'text_position_y' => $validated['text_position_y'],
            'order'           => $validated['order'],
            'active'          => $request->has('active'),
        ]);

        return redirect()->route('admin.slides.index')->with('success', 'Slajd uspešno kreiran.');
    }

    public function edit(Slide $slide)
    {
        return view('admin.slides.edit', compact('slide'));
    }

    public function update(Request $request, Slide $slide)
    {
        $validated = $request->validate([
            'image'           => 'nullable|image|max:4096',
            'title_sr'        => 'nullable|string|max:255',
            'title_en'        => 'nullable|string|max:255',
            'title_hu'        => 'nullable|string|max:255',
            'description_sr'  => 'nullable|string',
            'description_en'  => 'nullable|string',
            'description_hu'  => 'nullable|string',
            'button_text_sr'  => 'nullable|string|max:100',
            'button_text_en'  => 'nullable|string|max:100',
            'button_text_hu'  => 'nullable|string|max:100',
            'button_link'     => 'nullable|string|max:500',
            'text_position_x' => 'required|in:left,center,right',
            'text_position_y' => 'required|in:top,center,bottom',
            'order'           => 'required|integer',
            'active'          => 'boolean',
        ]);

        $data = [
            'title'           => ['sr' => $validated['title_sr'] ?? '', 'en' => $validated['title_en'] ?? '', 'hu' => $validated['title_hu'] ?? ''],
            'description'     => ['sr' => $validated['description_sr'] ?? '', 'en' => $validated['description_en'] ?? '', 'hu' => $validated['description_hu'] ?? ''],
            'button_text'     => ['sr' => $validated['button_text_sr'] ?? '', 'en' => $validated['button_text_en'] ?? '', 'hu' => $validated['button_text_hu'] ?? ''],
            'button_link'     => $validated['button_link'] ?? null,
            'text_position_x' => $validated['text_position_x'],
            'text_position_y' => $validated['text_position_y'],
            'order'           => $validated['order'],
            'active'          => $request->has('active'),
        ];

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($slide->image);
            $data['image'] = $request->file('image')->store('slides', 'public');
        }

        $slide->update($data);

        return redirect()->route('admin.slides.index')->with('success', 'Slajd uspešno ažuriran.');
    }

    public function destroy(Slide $slide)
    {
        Storage::disk('public')->delete($slide->image);
        $slide->delete();

        return redirect()->route('admin.slides.index')->with('success', 'Slajd obrisan.');
    }
}
