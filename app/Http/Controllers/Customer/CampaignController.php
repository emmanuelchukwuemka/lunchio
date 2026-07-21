<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    public function index()
    {
        abort_unless(Auth::user()->canAccess('manage-calendar'), 403);

        $campaigns = Auth::user()->businessOwner()->campaigns()->latest()->get();

        return view('customer.campaigns.index', compact('campaigns'));
    }

    public function store(Request $request)
    {
        abort_unless(Auth::user()->canAccess('manage-calendar'), 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'channel' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:planned,active,completed'],
            'description' => ['nullable', 'string', 'max:2000'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date'],
        ]);

        Auth::user()->businessOwner()->campaigns()->create($validated);

        return back()->with('status', 'Campaign created.');
    }

    public function update(Request $request, Campaign $campaign)
    {
        abort_unless(Auth::user()->canAccess('manage-calendar'), 403);
        abort_unless($campaign->user_id === Auth::user()->businessOwner()->id, 403);

        $validated = $request->validate([
            'status' => ['required', 'in:planned,active,completed'],
        ]);

        $campaign->update($validated);

        return back()->with('status', 'Campaign updated.');
    }

    public function destroy(Campaign $campaign)
    {
        abort_unless(Auth::user()->canAccess('manage-calendar'), 403);
        abort_unless($campaign->user_id === Auth::user()->businessOwner()->id, 403);

        $campaign->delete();

        return back()->with('status', 'Campaign removed.');
    }
}
