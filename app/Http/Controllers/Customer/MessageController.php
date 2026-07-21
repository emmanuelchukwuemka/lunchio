<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        abort_unless(Auth::user()->canAccess('manage-orders'), 403);

        $business = Auth::user()->businessOwner();

        $orders = $business->orders()
            ->with(['package', 'messages.user'])
            ->latest()
            ->get();

        return view('customer.messages.index', compact('orders'));
    }
}
