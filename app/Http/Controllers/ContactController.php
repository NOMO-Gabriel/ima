<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Mail\ContactFormSubmitted;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Store a new contact form submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'formation' => 'nullable|string|max:100',
            'message' => 'required|string|max:2000',
        ]);

        // Create a new contact entry in the database
        $contact = Contact::create($validated);

        // Send notification email to admin
        try {
            Mail::to(config('mail.admin_address', 'info@icorp-education.cm'))
                ->send(new ContactFormSubmitted($contact));
        } catch (\Exception $e) {
            // Log email sending failure but don't stop the process
            logger('Failed to send contact form notification: ' . $e->getMessage());
        }

        // Redirect back with success message
        return back()->with('success', __('Votre message a été envoyé avec succès. Notre équipe vous contactera prochainement.'));
    }
}
