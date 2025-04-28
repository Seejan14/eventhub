<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\CustomerAddress;
use App\Models\Event;
use App\Models\Package;
use App\Models\PackageSchedule;
use App\Traits\RespondTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    use RespondTrait;

    public function index()
    {
        $bookings = Booking::with(['event', 'customerAddress'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $bookings
        ]);
    }


    public function show(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access'
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'data' => $booking->load(['package', 'customerAddress'])
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'number_of_people' => 'required|integer|min:1',
            'booking_date' => 'required|date',
            'special_requirements' => 'nullable|string',
            'name' => 'required|string',
            'email' => 'required|email',
            'address_line1' => 'required|string',
            'address_line2' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
            'postal_code' => 'required|string',
            'phone' => 'nullable|string'
        ]);

        $event = Event::findOrFail($validated['event_id']);

        if ($event->status !== 1) {
            return response()->json([
                'message' => 'event is not available for booking.'
            ], 422);
        }

        if ($event->total_space < $validated['number_of_people']) {
            return response()->json([
                'message' => 'Not enough space available in the selected event. Only ' . $event->total_space . ' spaces are available.'
            ], 422);
        }

        try {
            DB::beginTransaction();

            $totalAmount = $event->price * $validated['number_of_people'];

            $addressData = [
                'user_id' => auth()->id(),
                'name' => $validated['name'],
                'email' => $validated['email'],
                'address_line1' => $validated['address_line1'],
                'address_line2' => $validated['address_line2'] ?? null,
                'city' => $validated['city'],
                'state' => $validated['state'],
                'country' => $validated['country'],
                'postal_code' => $validated['postal_code'],
                'phone' => $validated['phone'] ?? null,
                'is_default' => false
            ];

            if ($addressData['is_default']) {
                CustomerAddress::where('user_id', auth()->id())
                    ->update(['is_default' => false]);
            }

            $customerAddress = CustomerAddress::create($addressData);

            $booking = Booking::create([
                'user_id' => auth()->id(),
                'event_id' => $validated['event_id'],
                'customer_address_id' => $customerAddress->id,
                'number_of_people' => $validated['number_of_people'],
                'booking_date' => $validated['booking_date'],
                'special_requirements' => $validated['special_requirements'],
                'total_amount' => $totalAmount,
                'status' => 4 // Completed
            ]);

            $event->decrement('total_space', $validated['number_of_people']);

            $remainingTicket = Event::where('id', $event->id)
                ->where('total_space', '>', 0)
                ->count();

            if ($remainingTicket == 0) {
                $event->update(['status' => 0]);
            }

            DB::commit();

            $booking->load(['event', 'customerAddress']);

            Mail::send('emails.booking-confirm-mail', ['booking' => $booking], function ($message) use ($validated) {
                $message->to($validated['email'])
                    ->subject('Event Booking Confirmation');
            });

            return $this->successResponse($booking, 'Event booked successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Something went wrong while processing your booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
