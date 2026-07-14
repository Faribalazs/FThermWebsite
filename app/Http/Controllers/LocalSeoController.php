<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class LocalSeoController extends Controller
{
    public function airConditioning(string $locale): View
    {
        return $this->page('air-conditioning', $locale);
    }

    public function heatPumps(string $locale): View
    {
        return $this->page('heat-pumps', $locale);
    }

    private function page(string $type, string $locale): View
    {
        $pages = config('local-seo.pages');
        $page = $pages[$type][$locale] ?? $pages[$type]['sr'];
        $page['type'] = $type;

        return view('local-seo.show', compact('page'));
    }
}
