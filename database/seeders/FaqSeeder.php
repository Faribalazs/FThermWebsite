<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $srItems = trans('ftherm.faq.items', [], 'sr');
        $enItems = trans('ftherm.faq.items', [], 'en');
        $huItems = trans('ftherm.faq.items', [], 'hu');

        foreach ($srItems as $index => $item) {
            Faq::updateOrCreate(
                ['order' => $index + 1],
                [
                    'question' => [
                        'sr' => $item['question'],
                        'en' => $enItems[$index]['question'] ?? $item['question'],
                        'hu' => $huItems[$index]['question'] ?? $item['question'],
                    ],
                    'answer' => [
                        'sr' => $item['answer'],
                        'en' => $enItems[$index]['answer'] ?? $item['answer'],
                        'hu' => $huItems[$index]['answer'] ?? $item['answer'],
                    ],
                    'active' => true,
                ]
            );
        }
    }
}
