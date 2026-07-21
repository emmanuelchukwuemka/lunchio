<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    public function index()
    {
        $leads = Lead::with(['packageInterest', 'notes.user'])->latest()->paginate(20);

        return view('admin.leads.index', compact('leads'));
    }

    public function updateStatus(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:new,contacted,qualified,converted,lost'],
        ]);

        $lead->update(['status' => $validated['status']]);

        return back()->with('status', 'Lead status updated.');
    }

    public function storeNote(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'note' => ['required', 'string', 'max:2000'],
        ]);

        $lead->notes()->create([
            'user_id' => Auth::id(),
            'note' => $validated['note'],
        ]);

        return back()->with('status', 'Note added.');
    }
}
