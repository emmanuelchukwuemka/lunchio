<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Package;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GetStartedController extends Controller
{
    public function create(): View
    {
        $packages = Package::where('active', true)->orderBy('sort_order')->get();

        return view('marketing.get-started', compact('packages'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'package_interest_id' => ['nullable', 'exists:packages,id'],
        ]);

        Lead::create($data + [
            'source' => 'get_started',
            'status' => 'new',
        ]);

        return redirect()
            ->route('register')
            ->with('status', 'Thanks! Create your account below to continue your launch.');
    }
}
