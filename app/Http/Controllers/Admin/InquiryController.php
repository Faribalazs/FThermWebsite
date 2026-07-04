<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Setting;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index()
    {
        $inquiries = Inquiry::orderBy('created_at', 'desc')->paginate(15);
        $notificationEmail = Setting::where('key', 'inquiry_notification_email')->value('value');

        return view('admin.inquiries.index', compact('inquiries', 'notificationEmail'));
    }

    public function show(Inquiry $inquiry)
    {
        // Mark as read when viewed
        if (!$inquiry->is_read) {
            $inquiry->update(['is_read' => true]);
        }
        
        return view('admin.inquiries.show', compact('inquiry'));
    }

    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();
        return redirect()->route('admin.inquiries.index')->with('success', 'Upit uspešno obrisan');
    }

    public function updateNotificationEmail(Request $request)
    {
        $validated = $request->validate([
            'inquiry_notification_email' => 'nullable|email|max:255',
        ]);

        Setting::updateOrCreate(
            ['key' => 'inquiry_notification_email'],
            ['value' => $validated['inquiry_notification_email'] ?? '']
        );

        return back()->with('success', 'Email za obaveštenja je uspešno sačuvan.');
    }
}
