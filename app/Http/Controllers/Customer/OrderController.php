<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        abort_unless(Auth::user()->canAccess('manage-orders'), 403);

        $orders = Auth::user()->businessOwner()->orders()->with('package')->latest()->get();
        return view('customer.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_unless(Auth::user()->canAccess('manage-orders'), 403);

        // Ensure user's business owns this order
        if ($order->user_id !== Auth::user()->businessOwner()->id) {
            abort(403);
        }

        $order->load(['package', 'deliverables', 'intakeDraft', 'messages.user']);
        
        return view('customer.orders.show', compact('order'));
    }
}
