<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutPageController extends Controller
{
    private array $locales = ['sr', 'en', 'hu'];

    public function edit()
    {
        $aboutPage = AboutPage::firstOrCreate(
            ['key' => 'main'],
            AboutPage::defaultContent()
        );

        return view('admin.about-page.edit', compact('aboutPage'));
    }

    public function update(Request $request)
    {
        $aboutPage = AboutPage::firstOrCreate(
            ['key' => 'main'],
            AboutPage::defaultContent()
        );

        $request->validate($this->rules());
        $data = $this->pageData($request);

        if ($request->hasFile('hero_image')) {
            $this->deleteStoredImage($aboutPage->hero_image);
            $data['hero_image'] = $request->file('hero_image')->store('about-page', 'public');
        }

        if ($request->hasFile('secondary_image')) {
            $this->deleteStoredImage($aboutPage->secondary_image);
            $data['secondary_image'] = $request->file('secondary_image')->store('about-page', 'public');
        }

        $aboutPage->update($data);

        return redirect()->route('admin.about-page.edit')->with('success', 'O nama stranica je uspešno ažurirana.');
    }

    private function rules(): array
    {
        $rules = [
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:8192',
            'secondary_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:8192',
        ];

        foreach ($this->locales as $locale) {
            $rules["eyebrow_{$locale}"] = 'required|string|max:255';
            $rules["title_{$locale}"] = 'required|string|max:255';
            $rules["intro_{$locale}"] = 'required|string';
            $rules["body_{$locale}"] = 'required|string';
            $rules["secondary_title_{$locale}"] = 'required|string|max:255';
            $rules["secondary_body_{$locale}"] = 'required|string';
            $rules["values_title_{$locale}"] = 'required|string|max:255';
            $rules["hero_image_alt_{$locale}"] = 'nullable|string|max:255';
            $rules["secondary_image_alt_{$locale}"] = 'nullable|string|max:255';
            $rules["seo_title_{$locale}"] = 'nullable|string|max:255';
            $rules["seo_description_{$locale}"] = 'nullable|string|max:500';

            for ($index = 0; $index < 4; $index++) {
                $rules["values.{$index}.title_{$locale}"] = 'required|string|max:255';
                $rules["values.{$index}.text_{$locale}"] = 'required|string';
            }

            for ($index = 0; $index < 3; $index++) {
                $rules["stats.{$index}.label_{$locale}"] = 'required|string|max:255';
            }
        }

        for ($index = 0; $index < 3; $index++) {
            $rules["stats.{$index}.value"] = 'required|string|max:40';
        }

        return $rules;
    }

    private function pageData(Request $request): array
    {
        $data = [
            'key' => 'main',
            'values' => [],
            'stats' => [],
        ];

        foreach ([
            'eyebrow',
            'title',
            'intro',
            'body',
            'secondary_title',
            'secondary_body',
            'values_title',
            'hero_image_alt',
            'secondary_image_alt',
            'seo_title',
            'seo_description',
        ] as $field) {
            $data[$field] = $this->localizedInput($request, $field);
        }

        for ($index = 0; $index < 4; $index++) {
            $value = ['title' => [], 'text' => []];

            foreach ($this->locales as $locale) {
                $value['title'][$locale] = $request->input("values.{$index}.title_{$locale}");
                $value['text'][$locale] = $request->input("values.{$index}.text_{$locale}");
            }

            $data['values'][] = $value;
        }

        for ($index = 0; $index < 3; $index++) {
            $stat = [
                'value' => $request->input("stats.{$index}.value"),
                'label' => [],
            ];

            foreach ($this->locales as $locale) {
                $stat['label'][$locale] = $request->input("stats.{$index}.label_{$locale}");
            }

            $data['stats'][] = $stat;
        }

        return $data;
    }

    private function localizedInput(Request $request, string $field): array
    {
        $values = [];

        foreach ($this->locales as $locale) {
            $values[$locale] = $request->input("{$field}_{$locale}", '');
        }

        return $values;
    }

    private function deleteStoredImage(?string $image): void
    {
        if ($image && !str_starts_with($image, 'images/')) {
            Storage::disk('public')->delete($image);
        }
    }
}
