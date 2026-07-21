<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessController extends Controller
{
    public function index()
    {
        $business = Auth::user()->businessOwner();

        $latestOrder = $business->orders()->with(['package', 'intakeDraft'])->latest()->first();

        return view('customer.business.index', compact('business', 'latestOrder'));
    }
}
