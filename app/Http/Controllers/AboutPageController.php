<?php

namespace App\Http\Controllers;

use App\Models\AboutPage;

class AboutPageController extends Controller
{
    public function show()
    {
        $aboutPage = AboutPage::firstOrCreate(
            ['key' => 'main'],
            AboutPage::defaultContent()
        );

        return view('about.show', compact('aboutPage'));
    }
}
