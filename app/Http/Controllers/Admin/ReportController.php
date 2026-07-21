<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Order;
use App\Models\Package;
use App\Models\Payment;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $ordersByStatus = collect(Order::STATUSES)->map(function ($status) {
            return ['status' => $status, 'count' => Order::where('status', $status)->count()];
        });

        $revenueByPackage = Package::all()->map(function ($package) {
            $revenue = Payment::where('status', Payment::STATUS_SUCCESS)
                ->whereHas('order', fn ($q) => $q->where('package_id', $package->id))
                ->sum('amount');

            return [
                'package' => $package->name,
                'orders' => $package->orders()->count(),
                'revenue' => $revenue,
            ];
        });

        $leadsBySource = Lead::selectRaw('COALESCE(source, "Unknown") as source, count(*) as count')
            ->groupBy('source')
            ->get();

        $staffPerformance = \App\Models\User::role(['admin', 'staff'])
            ->withCount([
                'assignedOrders',
                'assignedOrders as delivered_count' => fn ($q) => $q->where('status', Order::STATUS_DELIVERED),
            ])
            ->get();

        return view('admin.reports.index', compact('ordersByStatus', 'revenueByPackage', 'leadsBySource', 'staffPerformance'));
    }
}
