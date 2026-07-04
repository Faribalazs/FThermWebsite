<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('order')->paginate(20);

        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.faqs.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateFaq($request);

        Faq::create($this->faqData($validated, $request));

        return redirect()->route('admin.faqs.index')->with('success', 'Pitanje je uspešno kreirano.');
    }

    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $validated = $this->validateFaq($request);

        $faq->update($this->faqData($validated, $request));

        return redirect()->route('admin.faqs.edit', $faq)->with('success', 'Pitanje je uspešno ažurirano.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('admin.faqs.index')->with('success', 'Pitanje je uspešno obrisano.');
    }

    private function validateFaq(Request $request): array
    {
        return $request->validate([
            'question_sr' => 'required|string|max:255',
            'question_en' => 'required|string|max:255',
            'question_hu' => 'required|string|max:255',
            'answer_sr' => 'required|string',
            'answer_en' => 'required|string',
            'answer_hu' => 'required|string',
            'order' => 'required|integer',
            'active' => 'boolean',
        ]);
    }

    private function faqData(array $validated, Request $request): array
    {
        return [
            'question' => [
                'sr' => $validated['question_sr'],
                'en' => $validated['question_en'],
                'hu' => $validated['question_hu'],
            ],
            'answer' => [
                'sr' => $validated['answer_sr'],
                'en' => $validated['answer_en'],
                'hu' => $validated['answer_hu'],
            ],
            'order' => $validated['order'],
            'active' => $request->boolean('active'),
        ];
    }
}
