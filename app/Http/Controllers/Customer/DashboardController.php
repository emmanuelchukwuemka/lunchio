<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $business = Auth::user()->businessOwner();

        // Eager load package and intake draft
        $orders = $business->orders()->with(['package', 'intakeDraft'])->latest()->get();

        return view('dashboard', compact('orders'));
    }
}
