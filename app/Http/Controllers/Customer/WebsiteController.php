<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebsiteController extends Controller
{
    public function index()
    {
        abort_unless(Auth::user()->canAccess('manage-website'), 403);
        abort_unless(Auth::user()->hasPackageFeatureLike('Website'), 403, 'Your current package does not include a website.');

        $website = Auth::user()->businessOwner()->websites()->latest()->first();

        if (! $website || is_null($website->sent_at)) {
            return view('customer.website.none');
        }

        return $this->show($website);
    }

    public function show(Website $website)
    {
        abort_unless(auth()->user()->canAccess('manage-website'), 403);

        if ($website->user_id !== auth()->user()->businessOwner()->id && !auth()->user()->hasRole('admin')) {
            abort(403);
        }

        abort_if(is_null($website->sent_at) && !auth()->user()->hasRole(['admin', 'staff']), 404);

        $website->load(['branding', 'pages', 'features', 'domain', 'hosting', 'ecommerceSetting']);

        $latestOrder = auth()->user()->businessOwner()->orders()->latest()->first();

        return view('customer.website.show', compact('website', 'latestOrder'));
    }

    public function approve(Website $website)
    {
        abort_unless(auth()->user()->canAccess('manage-website'), 403);
        abort_unless($website->user_id === auth()->user()->businessOwner()->id, 403);

        $website->update(['approved_at' => now()]);

        return back()->with('status', 'Website approved!');
    }
}
