<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function create(): View
    {
        return view('marketing.contact');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        Lead::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'source' => 'contact_form',
            'status' => 'new',
            'payload' => ['message' => $data['message']],
        ]);

        return redirect()
            ->route('contact')
            ->with('status', 'Thanks for reaching out — we\'ll get back to you shortly.');
    }
}
