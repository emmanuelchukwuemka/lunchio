<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Website;
use App\Models\WebsiteDomain;
use App\Models\WebsiteHosting;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function index()
    {
        $websites = Website::with(['user', 'domain'])->latest()->paginate(20);

        return view('admin.websites.index', compact('websites'));
    }

    public function show(Website $website)
    {
        $website->load(['user', 'order', 'branding', 'pages', 'features', 'domain', 'hosting', 'ecommerceSetting']);

        return view('admin.websites.show', compact('website'));
    }

    public function update(Request $request, Website $website)
    {
        $validated = $request->validate([
            'url' => ['nullable', 'string', 'max:255'],
            'admin_login' => ['nullable', 'string', 'max:2000'],
            'status' => ['required', 'in:draft,in_progress,live'],
            'domain_name' => ['nullable', 'string', 'max:255'],
            'hosting_type' => ['nullable', 'string', 'max:255'],
        ]);

        $website->url = $validated['url'] ?? null;
        $website->status = $validated['status'];

        if (! empty($validated['admin_login'])) {
            $website->admin_login = $validated['admin_login'];
        }

        $website->save();

        if ($request->filled('domain_name')) {
            $website->domain()->updateOrCreate([], [
                'type' => $website->domain?->type ?? 'register',
                'domain_name' => $validated['domain_name'],
            ]);
        }

        if ($request->filled('hosting_type')) {
            $website->hosting()->updateOrCreate([], [
                'hosting_type' => $validated['hosting_type'],
            ]);
        }

        return back()->with('status', 'Website updated successfully.');
    }
}
