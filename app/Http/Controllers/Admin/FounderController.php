<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class FounderController extends Controller
{
    public function index()
    {
        $founders = User::role('customer')
            ->whereNull('owner_id')
            ->withCount(['teamMembers', 'orders'])
            ->with(['orders' => function ($query) {
                $query->latest()->limit(1)->with('package');
            }])
            ->latest()
            ->paginate(20);

        return view('admin.founders.index', compact('founders'));
    }

    public function businesses()
    {
        $founders = User::role('customer')
            ->whereNull('owner_id')
            ->with(['orders' => function ($query) {
                $query->latest()->limit(1)->with(['package', 'intakeDraft']);
            }])
            ->latest()
            ->paginate(20);

        return view('admin.founders.businesses', compact('founders'));
    }
}
