<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Website;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function show(Website $website)
    {
        if ($website->user_id !== auth()->id() && !auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $website->load(['branding', 'pages', 'features', 'domain', 'hosting', 'ecommerceSetting']);

        return view('customer.website.show', compact('website'));
    }
}
