<?php

namespace App\Http\Controllers;

use App\Models\Service;

class ServicePageController extends Controller
{
    public function show(string $locale, Service $service)
    {
        abort_unless($service->active, 404);

        $relatedServices = Service::where('active', true)
            ->whereKeyNot($service->getKey())
            ->orderBy('order')
            ->take(4)
            ->get();

        return view('services.show', compact('service', 'relatedServices'));
    }
}
