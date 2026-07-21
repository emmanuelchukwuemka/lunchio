<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Deliverable;
use App\Models\Website;
use App\Notifications\DeliverablesSent;
use App\Support\DeliverableChecklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'package', 'intakeDraft', 'assignedStaff'])
            ->latest()
            ->paginate(15);

        $staffMembers = \App\Models\User::role(['admin', 'staff'])
            ->withCount(['assignedOrders as active_order_count' => function ($query) {
                $query->whereNotIn('status', [Order::STATUS_DELIVERED]);
            }])
            ->get();

        return view('admin.orders.index', compact('orders', 'staffMembers'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'package', 'deliverables', 'statusLogs', 'intakeDraft', 'adminNotes.staff', 'payments', 'assignedStaff', 'messages.user', 'website.domain', 'website.hosting']);
        $staffMembers = \App\Models\User::role(['admin', 'staff'])->get();
        $checklist = DeliverableChecklist::forPackage($order->package?->slug);

        return view('admin.orders.show', compact('order', 'staffMembers', 'checklist'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:submitted,in_progress,in_review,approved,delivered'],
        ]);

        $fromStatus = $order->status;

        $order->update([
            'status' => $validated['status'],
            'delivered_at' => $validated['status'] === Order::STATUS_DELIVERED ? now() : $order->delivered_at,
        ]);

        $order->statusLogs()->create([
            'from_status' => $fromStatus,
            'to_status' => $validated['status'],
            'changed_by_user_id' => Auth::id(),
            'note' => $request->input('notes'),
        ]);

        $order->user->notify(new \App\Notifications\OrderStatusChanged($order, $fromStatus, $validated['status']));

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
            'type' => ['required', 'in:' . implode(',', Deliverable::TYPES)],
            'file' => ['required', 'file', 'max:51200'], // 50MB max
        ]);

        $title = $request->input('title');
        $type = $request->input('type');
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
            'type' => $type,
            'file_path' => $path,
            'original_filename' => $file->getClientOriginalName(),
            'version' => $version,
            'is_current' => true,
            'uploaded_by' => Auth::id(),
        ]);

        return back()->with('status', 'Deliverable uploaded successfully.');
    }

    public function destroyDeliverable(Order $order, Deliverable $deliverable)
    {
        abort_unless($deliverable->order_id === $order->id, 404);

        Storage::disk('public')->delete($deliverable->file_path);
        $deliverable->delete();

        return back()->with('status', 'Deliverable removed.');
    }

    public function manageWebsite(Request $request, Order $order)
    {
        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'url' => ['nullable', 'string', 'max:255'],
            'admin_login' => ['nullable', 'string', 'max:2000'],
            'status' => ['required', 'in:draft,in_progress,live'],
            'domain_name' => ['nullable', 'string', 'max:255'],
            'hosting_type' => ['nullable', 'string', 'max:255'],
        ]);

        $website = $order->website ?? new Website([
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'type' => 'Business Website',
        ]);

        $website->fill([
            'name' => $validated['name'] ?? $website->name ?? $order->business_name,
            'url' => $validated['url'] ?? null,
            'status' => $validated['status'],
        ]);

        if (! empty($validated['admin_login'])) {
            $website->admin_login = $validated['admin_login'];
        }

        $website->save();

        if (! empty($validated['domain_name'])) {
            $website->domain()->updateOrCreate([], [
                'type' => $website->domain?->type ?? 'register',
                'domain_name' => $validated['domain_name'],
            ]);
        }

        if (! empty($validated['hosting_type'])) {
            $website->hosting()->updateOrCreate([], [
                'hosting_type' => $validated['hosting_type'],
            ]);
        }

        return back()->with('status', 'Website details saved.');
    }

    public function sendToFounder(Order $order)
    {
        $order->deliverables()
            ->where('is_current', true)
            ->whereNull('sent_at')
            ->update(['sent_at' => now()]);

        if ($order->website && is_null($order->website->sent_at)) {
            $order->website->update(['sent_at' => now()]);
        }

        if ($order->status !== Order::STATUS_IN_REVIEW) {
            $fromStatus = $order->status;
            $order->update(['status' => Order::STATUS_IN_REVIEW]);

            $order->statusLogs()->create([
                'from_status' => $fromStatus,
                'to_status' => Order::STATUS_IN_REVIEW,
                'changed_by_user_id' => Auth::id(),
                'note' => 'Deliverables sent to founder for review.',
            ]);
        }

        $order->user->notify(new DeliverablesSent($order));

        return back()->with('status', 'Deliverables sent to founder for review!');
    }
}
