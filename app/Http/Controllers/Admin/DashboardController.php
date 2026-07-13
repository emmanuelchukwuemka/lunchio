<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // High level metrics
        $totalUsers = User::count();
        $totalRevenue = Payment::where('status', 'succeeded')->sum('amount');
        $pendingOrders = Order::where('status', 'pending')->count();
        $recentUsers = User::latest()->take(5)->get();
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalRevenue',
            'pendingOrders',
            'recentUsers',
            'recentOrders'
        ));
    }
}
