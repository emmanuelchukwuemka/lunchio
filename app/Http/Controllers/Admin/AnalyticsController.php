<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Order;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Support\Carbon;

class AnalyticsController extends Controller
{
    public function index()
    {
        $totalRevenue = Payment::where('status', Payment::STATUS_SUCCESS)->sum('amount');
        $totalOrders = Order::count();
        $avgOrderValue = $totalOrders > 0
            ? Payment::where('status', Payment::STATUS_SUCCESS)->avg('amount')
            : 0;
        $activeSubscriptions = Subscription::where('status', Subscription::STATUS_ACTIVE)->count();

        $totalLeads = Lead::count();
        $convertedLeads = Lead::where('status', 'converted')->count();
        $conversionRate = $totalLeads > 0 ? round(($convertedLeads / $totalLeads) * 100, 1) : 0;

        // Orders per day, last 30 days
        $ordersByDay = collect(range(29, 0))->map(function ($daysAgo) {
            $date = Carbon::today()->subDays($daysAgo);
            return [
                'label' => $date->format('M d'),
                'count' => Order::whereDate('created_at', $date)->count(),
            ];
        });

        // Revenue per month, last 6 months
        $revenueByMonth = collect(range(5, 0))->map(function ($monthsAgo) {
            $month = Carbon::today()->subMonths($monthsAgo);
            return [
                'label' => $month->format('M Y'),
                'amount' => (float) Payment::where('status', Payment::STATUS_SUCCESS)
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->sum('amount'),
            ];
        });

        // Package popularity
        $packagePopularity = Package::withCount('orders')
            ->orderByDesc('orders_count')
            ->get(['id', 'name', 'slug']);

        // Lead funnel
        $leadFunnel = collect(['new', 'contacted', 'qualified', 'converted', 'lost'])->map(function ($status) {
            return [
                'status' => $status,
                'count' => Lead::where('status', $status)->count(),
            ];
        });

        return view('admin.analytics.index', compact(
            'totalRevenue',
            'totalOrders',
            'avgOrderValue',
            'activeSubscriptions',
            'totalLeads',
            'conversionRate',
            'ordersByDay',
            'revenueByMonth',
            'packagePopularity',
            'leadFunnel'
        ));
    }
}
