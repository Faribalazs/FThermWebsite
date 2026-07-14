<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageTrustSection;
use Illuminate\Http\Request;

class HomepageTrustSectionController extends Controller
{
    private array $locales = ['sr', 'en', 'hu'];

    public function edit()
    {
        $trustSection = HomepageTrustSection::firstOrCreate(['key' => 'main'], HomepageTrustSection::defaultContent());

        return view('admin.homepage-trust-section.edit', compact('trustSection'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate($this->rules());
        $trustSection = HomepageTrustSection::firstOrCreate(['key' => 'main'], HomepageTrustSection::defaultContent());
        $data = ['eyebrow' => [], 'title' => [], 'intro' => [], 'metrics' => [], 'items' => []];
        foreach ($this->locales as $locale) {
            foreach (['eyebrow', 'title', 'intro'] as $field) {
                $data[$field][$locale] = $validated["{$field}_{$locale}"];
            }
        }
        for ($index = 0; $index < 3; $index++) {
            $metric = ['value' => $validated['metrics'][$index]['value'], 'label' => []];
            foreach ($this->locales as $locale) {
                $metric['label'][$locale] = $validated['metrics'][$index]["label_{$locale}"];
            }
            $data['metrics'][] = $metric;
        }
        for ($index = 0; $index < 4; $index++) {
            $item = ['title' => [], 'text' => []];
            foreach ($this->locales as $locale) {
                $item['title'][$locale] = $validated['items'][$index]["title_{$locale}"];
                $item['text'][$locale] = $validated['items'][$index]["text_{$locale}"];
            }
            $data['items'][] = $item;
        }
        $trustSection->update($data);

        return back()->with('success', 'Sekcija „Zašto klijenti biraju FTHERM?” je uspešno sačuvana.');
    }

    private function rules(): array
    {
        $rules = [];
        foreach ($this->locales as $locale) {
            $rules["eyebrow_{$locale}"] = 'required|string|max:255';
            $rules["title_{$locale}"] = 'required|string|max:255';
            $rules["intro_{$locale}"] = 'required|string|max:1000';
            for ($index = 0; $index < 3; $index++) {
                $rules["metrics.{$index}.label_{$locale}"] = 'required|string|max:255';
            }
            for ($index = 0; $index < 4; $index++) {
                $rules["items.{$index}.title_{$locale}"] = 'required|string|max:255';
                $rules["items.{$index}.text_{$locale}"] = 'required|string|max:1000';
            }
        }
        for ($index = 0; $index < 3; $index++) {
            $rules["metrics.{$index}.value"] = 'required|string|max:40';
        }

        return $rules;
    }
}
