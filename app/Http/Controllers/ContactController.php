<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:50',
            'service_type' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        $inquiry = Inquiry::create($validated);

        $notificationEmail = Setting::where('key', 'inquiry_notification_email')->value('value');

        if ($notificationEmail) {
            try {
                Mail::send('emails.inquiry-notification', ['inquiry' => $inquiry], function ($message) use ($inquiry, $notificationEmail) {
                    $message->to($notificationEmail)
                        ->subject('Novi upit sa sajta - ' . $inquiry->name);

                    if ($inquiry->email) {
                        $message->replyTo($inquiry->email, $inquiry->name);
                    }
                });
            } catch (Throwable $exception) {
                Log::error('Failed to send inquiry notification email.', [
                    'inquiry_id' => $inquiry->id,
                    'recipient' => $notificationEmail,
                    'error' => $exception->getMessage(),
                ]);
            }
        }

        return back()
            ->with('success', __('ftherm.contact.success'))
            ->with('contact_success', __('ftherm.contact.success'));
    }
}
