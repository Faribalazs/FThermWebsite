<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('order')->paginate(15);

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateService($request);
        $data = $this->serviceData($validated);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        Service::create($data);

        return redirect()->route('admin.services.index')->with('success', 'Usluga je uspešno kreirana.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $this->validateService($request, $service);
        $data = $this->serviceData($validated, $service);

        if ($request->hasFile('image')) {
            $this->deleteStoredImage($service);
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($data);

        return redirect()->route('admin.services.edit', $service)->with('success', 'Usluga je uspešno ažurirana.');
    }

    public function destroy(Service $service)
    {
        $this->deleteStoredImage($service);
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Usluga je uspešno obrisana.');
    }

    private function validateService(Request $request, ?Service $service = null): array
    {
        return $request->validate([
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('services', 'slug')->ignore($service),
            ],
            'title_en' => 'required|string|max:255',
            'title_sr' => 'required|string|max:255',
            'title_hu' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_sr' => 'required|string',
            'description_hu' => 'required|string',
            'content_en' => 'nullable|string',
            'content_sr' => 'nullable|string',
            'content_hu' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:8192',
            'image_alt_en' => 'nullable|string|max:255',
            'image_alt_sr' => 'nullable|string|max:255',
            'image_alt_hu' => 'nullable|string|max:255',
            'order' => 'required|integer',
            'active' => 'boolean',
        ]);
    }

    private function serviceData(array $validated, ?Service $service = null): array
    {
        $baseSlug = $validated['slug'] ?: $validated['title_en'] ?: $validated['title_sr'];

        return [
            'slug' => $this->uniqueSlug($baseSlug, $service),
            'title' => [
                'en' => $validated['title_en'],
                'sr' => $validated['title_sr'],
                'hu' => $validated['title_hu'],
            ],
            'description' => [
                'en' => $validated['description_en'],
                'sr' => $validated['description_sr'],
                'hu' => $validated['description_hu'],
            ],
            'content' => [
                'en' => $validated['content_en'] ?? '',
                'sr' => $validated['content_sr'] ?? '',
                'hu' => $validated['content_hu'] ?? '',
            ],
            'image_alt' => [
                'en' => $validated['image_alt_en'] ?? $validated['title_en'],
                'sr' => $validated['image_alt_sr'] ?? $validated['title_sr'],
                'hu' => $validated['image_alt_hu'] ?? $validated['title_hu'],
            ],
            'order' => $validated['order'],
            'active' => request()->boolean('active'),
        ];
    }

    private function uniqueSlug(string $value, ?Service $service = null): string
    {
        $slug = Str::slug($value) ?: 'service';
        $baseSlug = $slug;
        $count = 2;

        while (Service::where('slug', $slug)
            ->when($service, fn ($query) => $query->whereKeyNot($service->getKey()))
            ->exists()) {
            $slug = $baseSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    private function deleteStoredImage(Service $service): void
    {
        if ($service->image && !str_starts_with($service->image, 'images/')) {
            Storage::disk('public')->delete($service->image);
        }
    }
}
