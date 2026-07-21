<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AnalyticsController extends Controller
{
    public function index()
    {
        abort_unless(Auth::user()->canAccess('view-billing'), 403);

        $business = Auth::user()->businessOwner();

        $totalSpent = $business->payments()->where('status', Payment::STATUS_SUCCESS)->sum('amount');
        $totalOrders = $business->orders()->count();
        $activeSubscriptions = $business->subscriptions()->where('status', 'active')->count();

        $spendByMonth = collect(range(5, 0))->map(function ($monthsAgo) use ($business) {
            $month = Carbon::today()->subMonths($monthsAgo);

            return [
                'label' => $month->format('M Y'),
                'amount' => (float) $business->payments()
                    ->where('status', Payment::STATUS_SUCCESS)
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->sum('amount'),
            ];
        });

        $contactFunnel = [
            'leads' => $business->contacts()->where('status', 'lead')->count(),
            'customers' => $business->contacts()->where('status', 'customer')->count(),
        ];

        return view('customer.analytics.index', compact(
            'totalSpent',
            'totalOrders',
            'activeSubscriptions',
            'spendByMonth',
            'contactFunnel'
        ));
    }
}
