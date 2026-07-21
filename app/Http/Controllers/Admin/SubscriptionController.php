<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::with(['user', 'package'])->latest()->paginate(20);

        return view('admin.subscriptions.index', compact('subscriptions'));
    }

    public function cancel(Subscription $subscription)
    {
        $subscription->update([
            'status' => Subscription::STATUS_CANCELLED,
            'cancelled_at' => now(),
        ]);

        return back()->with('status', 'Subscription cancelled.');
    }
}
