<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index()
    {
        $staffMembers = User::role(['admin', 'staff'])
            ->withCount(['assignedOrders as active_order_count' => function ($query) {
                $query->whereNotIn('status', [Order::STATUS_DELIVERED]);
            }])
            ->get();

        $orders = Order::with(['user', 'package', 'assignedStaff'])
            ->whereNotIn('status', [Order::STATUS_DELIVERED])
            ->latest()
            ->paginate(20);

        return view('admin.assignments.index', compact('staffMembers', 'orders'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'assigned_staff_id' => ['nullable', 'exists:users,id'],
        ]);

        $order->update(['assigned_staff_id' => $validated['assigned_staff_id']]);

        return back()->with('status', 'Assignment updated.');
    }
}
