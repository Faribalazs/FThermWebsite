<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::where('created_by', Auth::guard('worker')->id())
            ->orderBy('type')
            ->orderBy('client_name')
            ->orderBy('company_name')
            ->get();

        return view('worker.contacts.index', compact('contacts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:fizicko_lice,pravno_lice',
            'client_name' => 'required_if:type,fizicko_lice|nullable|string|max:255',
            'client_address' => 'nullable|string|max:255',
            'client_phone' => 'nullable|string|max:50',
            'client_email' => 'nullable|email|max:255',
            'company_name' => 'required_if:type,pravno_lice|nullable|string|max:255',
            'pib' => 'nullable|string|max:20',
            'maticni_broj' => 'nullable|string|max:20',
            'company_address' => 'nullable|string|max:255',
        ]);

        $validated['created_by'] = Auth::guard('worker')->id();

        Contact::create($validated);

        return back()->with('success', 'Kontakt uspešno dodat!');
    }

    public function update(Request $request, Contact $contact)
    {
        if ($contact->created_by !== Auth::guard('worker')->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'type' => 'required|in:fizicko_lice,pravno_lice',
            'client_name' => 'required_if:type,fizicko_lice|nullable|string|max:255',
            'client_address' => 'nullable|string|max:255',
            'client_phone' => 'nullable|string|max:50',
            'client_email' => 'nullable|email|max:255',
            'company_name' => 'required_if:type,pravno_lice|nullable|string|max:255',
            'pib' => 'nullable|string|max:20',
            'maticni_broj' => 'nullable|string|max:20',
            'company_address' => 'nullable|string|max:255',
        ]);

        $contact->update($validated);

        return back()->with('success', 'Kontakt uspešno ažuriran!');
    }

    public function destroy(Contact $contact)
    {
        if ($contact->created_by !== Auth::guard('worker')->id()) {
            abort(403);
        }

        $contact->delete();

        return back()->with('success', 'Kontakt uspešno obrisan!');
    }

    /**
     * API endpoint to get contact data as JSON for auto-fill.
     */
    public function show(Contact $contact)
    {
        if ($contact->created_by !== Auth::guard('worker')->id()) {
            abort(403);
        }

        return response()->json($contact);
    }
}
