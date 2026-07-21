<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $orders = Order::whereHas('messages')
            ->with(['user', 'package', 'assignedStaff', 'messages.user'])
            ->latest()
            ->paginate(20);

        return view('admin.messages.index', compact('orders'));
    }
}
