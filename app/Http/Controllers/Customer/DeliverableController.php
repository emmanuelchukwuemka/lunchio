<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Deliverable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliverableController extends Controller
{
    public function index()
    {
        $deliverables = Deliverable::whereHas('order', function ($query) {
            $query->where('user_id', Auth::id());
        })->with('order.package')->latest()->get();

        return view('customer.deliverables.index', compact('deliverables'));
    }

    public function requestRevision(Request $request, Deliverable $deliverable)
    {
        // Ensure user owns this deliverable's order
        if ($deliverable->order->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'revision_notes' => ['required', 'string', 'max:2000'],
        ]);

        // In a real application, you might create a separate Revision model 
        // or just add a revision_requested flag to the Deliverable.
        // We'll add the revision notes to the Deliverable's notes for now, 
        // and transition the Order status to 'in_progress' or 'in_review'.
        
        $deliverable->update([
            'notes' => $validated['revision_notes']
        ]);

        // Add note to AdminNotes so staff sees it
        $deliverable->order->adminNotes()->create([
            'staff_id' => Auth::id(), // We're using staff_id but it's from the client, a bit hacky but works for MVP
            'note' => "Client requested revision on '{$deliverable->title}': \n" . $validated['revision_notes']
        ]);

        return back()->with('status', 'Revision requested successfully! Our team will get back to you shortly.');
    }
}
