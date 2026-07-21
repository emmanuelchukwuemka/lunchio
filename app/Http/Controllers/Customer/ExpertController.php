<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Expert;
use App\Models\ExpertBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpertController extends Controller
{
    public function index()
    {
        $experts = Expert::where('status', 'active')->get();

        $bookings = Auth::user()->businessOwner()->expertBookings()->with('expert')->latest()->get();

        return view('customer.experts.index', compact('experts', 'bookings'));
    }

    public function store(Request $request, Expert $expert)
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
            'scheduled_at' => ['nullable', 'date'],
        ]);

        $expert->bookings()->create([
            'user_id' => Auth::user()->businessOwner()->id,
            'status' => 'pending',
            'message' => $validated['message'],
            'scheduled_at' => $validated['scheduled_at'] ?? null,
        ]);

        return back()->with('status', "Booking request sent to {$expert->name}. They'll be in touch shortly.");
    }
}
