<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LandingController extends Controller
{
    public function index()
    {
        return view('landing.index');
    }

    public function templates()
    {
        return view('landing.templates');
    }

    public function handleDemoRequest(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'business_name' => 'required|string|max:255',
            'target_url' => 'nullable|string'
        ]);

        try {
            $adminEmail = config('app.admin_email');
            $senderEmail = config('mail.from.address');
            $appName = config('app.name');

            $messageContent = "New Demo Request Received for {$appName}:\n\n" .
                             "Email: {$validated['email']}\n" .
                             "Business Name: {$validated['business_name']}\n" .
                             "Requested Demo: {$validated['target_url']}\n\n" .
                             "Timestamp: " . now()->format('Y-m-d H:i:s');

            Mail::raw($messageContent, function ($message) use ($adminEmail, $appName) {
                $message->to($adminEmail)
                        ->subject("New Lead: Demo Request from {$appName}");
            });

            return response()->json(['success' => true, 'message' => 'Request submitted successfully.']);
        } catch (\Exception $e) {
            \Log::error('Mail Error: ' . $e->getMessage());
            // We still return success to the user so they can see the demo, 
            // but log the error for the developer.
            return response()->json(['success' => true, 'message' => 'Request processed (Mail logged).']);
        }
    }
}
