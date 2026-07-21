<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(Auth::user()->canAccess('manage-crm'), 403);

        $status = $request->query('status');

        $business = Auth::user()->businessOwner();

        $contacts = $business->contacts()
            ->when($status, fn ($query) => $query->where('status', $status))
            ->with('followUps')
            ->latest()
            ->get();

        return view('customer.crm.index', compact('contacts', 'status'));
    }

    public function followUps()
    {
        abort_unless(Auth::user()->canAccess('manage-crm'), 403);

        $business = Auth::user()->businessOwner();

        $followUps = \App\Models\ContactFollowUp::whereHas('contact', function ($query) use ($business) {
            $query->where('user_id', $business->id);
        })->with('contact')->latest()->get();

        return view('customer.crm.follow-ups', compact('followUps'));
    }

    public function store(Request $request)
    {
        abort_unless(Auth::user()->canAccess('manage-crm'), 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'status' => ['required', 'in:lead,customer'],
            'source' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        Auth::user()->businessOwner()->contacts()->create($validated);

        return back()->with('status', 'Contact added.');
    }

    public function update(Request $request, Contact $contact)
    {
        abort_unless(Auth::user()->canAccess('manage-crm'), 403);
        $this->authorizeContact($contact);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'status' => ['required', 'in:lead,customer'],
            'source' => ['nullable', 'string', 'max:255'],
        ]);

        $contact->update($validated);

        return back()->with('status', 'Contact updated.');
    }

    public function destroy(Contact $contact)
    {
        abort_unless(Auth::user()->canAccess('manage-crm'), 403);
        $this->authorizeContact($contact);

        $contact->delete();

        return back()->with('status', 'Contact removed.');
    }

    public function storeFollowUp(Request $request, Contact $contact)
    {
        abort_unless(Auth::user()->canAccess('manage-crm'), 403);
        $this->authorizeContact($contact);

        $validated = $request->validate([
            'note' => ['required', 'string', 'max:2000'],
            'follow_up_date' => ['nullable', 'date'],
        ]);

        $contact->followUps()->create($validated);
        $contact->update(['last_contacted_at' => now()]);

        return back()->with('status', 'Follow-up logged.');
    }

    private function authorizeContact(Contact $contact): void
    {
        abort_unless($contact->user_id === Auth::user()->businessOwner()->id, 403);
    }
}
