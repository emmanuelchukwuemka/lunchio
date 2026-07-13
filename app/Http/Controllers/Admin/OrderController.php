<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Deliverable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'package', 'intakeDraft'])
            ->latest()
            ->paginate(15);
            
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'package', 'deliverables', 'statusLogs', 'intakeDraft', 'adminNotes.staff', 'payments', 'assignedStaff']);
        $staffMembers = \App\Models\User::role(['admin', 'staff'])->get();

        return view('admin.orders.show', compact('order', 'staffMembers'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:submitted,in_progress,in_review,approved,delivered'],
        ]);

        $order->update(['status' => $validated['status']]);
        
        $order->statusLogs()->create([
            'status' => $validated['status'],
            'notes' => $request->input('notes'),
        ]);

        return back()->with('status', 'Order status updated successfully.');
    }

    public function assignStaff(Request $request, Order $order)
    {
        $validated = $request->validate([
            'assigned_staff_id' => ['nullable', 'exists:users,id'],
        ]);

        $order->update(['assigned_staff_id' => $validated['assigned_staff_id']]);

        return back()->with('status', 'Staff assignment updated.');
    }

    public function uploadDeliverable(Request $request, Order $order)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'file' => ['required', 'file', 'max:51200'], // 50MB max
        ]);

        $title = $request->input('title');
        $file = $request->file('file');

        // Check for existing deliverable with the same title
        $existing = $order->deliverables()->where('title', $title)->where('is_current', true)->first();
        $version = $existing ? $existing->version + 1 : 1;

        if ($existing) {
            $existing->update(['is_current' => false]);
        }

        $path = $file->store('deliverables/' . $order->id, 'public');

        $order->deliverables()->create([
            'title' => $title,
            'type' => \App\Models\Deliverable::TYPE_OTHER,
            'file_path' => $path,
            'original_filename' => $file->getClientOriginalName(),
            'version' => $version,
            'is_current' => true,
            'uploaded_by' => Auth::id(),
        ]);

        return back()->with('status', 'Deliverable uploaded successfully.');
    }
}
