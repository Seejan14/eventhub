<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['event', 'customerAddress'])->get();

        return view('booking.index', compact('bookings'));
    }

    public function show($id)
    {

        $booking = Booking::findOrFail($id);
        return view('booking.show', compact('booking'));
    }
}
