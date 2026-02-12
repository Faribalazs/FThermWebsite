<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

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
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_sr' => 'required|string|max:255',
            'title_hu' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_sr' => 'required|string',
            'description_hu' => 'required|string',
            'icon' => 'nullable|string|max:255',
            'order' => 'required|integer',
            'active' => 'boolean',
        ]);

        Service::create([
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
            'icon' => $validated['icon'] ?? null,
            'order' => $validated['order'],
            'active' => $request->has('active'),
        ]);

        return redirect()->route('admin.services.index')->with('success', 'Service created successfully');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_sr' => 'required|string|max:255',
            'title_hu' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_sr' => 'required|string',
            'description_hu' => 'required|string',
            'icon' => 'nullable|string|max:255',
            'order' => 'required|integer',
            'active' => 'boolean',
        ]);

        $service->update([
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
            'icon' => $validated['icon'] ?? null,
            'order' => $validated['order'],
            'active' => $request->has('active'),
        ]);

        return redirect()->route('admin.services.index')->with('success', 'Service updated successfully');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully');
    }
}
