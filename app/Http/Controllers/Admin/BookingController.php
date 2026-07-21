<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExpertBooking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = ExpertBooking::with(['user', 'expert'])->latest()->paginate(20);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function updateStatus(Request $request, ExpertBooking $booking)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,confirmed,completed,cancelled'],
        ]);

        $booking->update(['status' => $validated['status']]);

        return back()->with('status', 'Booking status updated.');
    }
}
