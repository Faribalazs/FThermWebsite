<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageTrustSection extends Model
{
    protected $fillable = ['key', 'eyebrow', 'title', 'intro', 'metrics', 'items'];

    protected function casts(): array
    {
        return ['eyebrow' => 'array', 'title' => 'array', 'intro' => 'array', 'metrics' => 'array', 'items' => 'array'];
    }

    public static function defaultContent(): array
    {
        $locales = ['sr', 'en', 'hu'];
        $localized = fn (string $field) => collect($locales)->mapWithKeys(
            fn (string $locale) => [$locale => trans("ftherm.trust.{$field}", [], $locale)]
        )->all();
        $metrics = [];
        for ($index = 0; $index < 3; $index++) {
            $metrics[] = [
                'value' => trans("ftherm.trust.metrics.{$index}.value", [], 'sr'),
                'label' => collect($locales)->mapWithKeys(fn (string $locale) => [
                    $locale => trans("ftherm.trust.metrics.{$index}.label", [], $locale),
                ])->all(),
            ];
        }
        $items = [];
        for ($index = 0; $index < 4; $index++) {
            $items[] = [
                'title' => collect($locales)->mapWithKeys(fn (string $locale) => [$locale => trans("ftherm.trust.items.{$index}.title", [], $locale)])->all(),
                'text' => collect($locales)->mapWithKeys(fn (string $locale) => [$locale => trans("ftherm.trust.items.{$index}.text", [], $locale)])->all(),
            ];
        }

        return ['key' => 'main', 'eyebrow' => $localized('eyebrow'), 'title' => $localized('title'), 'intro' => $localized('intro'), 'metrics' => $metrics, 'items' => $items];
    }
}
