<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\CustomerAddress;
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
        $bookings = Booking::with(['package', 'customerAddress', 'schedule'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $bookings
        ]);
    }

    public function upcomingTrips()
    {
        $bookings = Booking::with(['package', 'customerAddress'])
            ->where('user_id', auth()->id())
            ->whereHas('package', function ($query) {
                $query->where('start_date', '>=', now())->where('status', 1);
            })
            ->orderByRaw('(SELECT start_date FROM packages WHERE packages.id = bookings.package_id) ASC')
            ->paginate(10);

        return $this->successResponse($bookings, 'Upcoming Trips Fetched Successfully');
    }

    public function activeBookings()
    {
        $bookings = Booking::with(['package', 'customerAddress'])
            ->where('user_id', auth()->id())
            ->whereHas('package', function ($query) {
                $query->where('status', 1);
            })
            ->orderByRaw('(SELECT start_date FROM packages WHERE packages.id = bookings.package_id) ASC')
            ->paginate(10);

        return $this->successResponse($bookings, 'Active Bookings Fetched Successfully');
    }

    public function recentBookings()
    {
        $bookings = Booking::with(['package', 'customerAddress'])
            ->where('user_id', auth()->id())
            ->orderBy('booking_date', 'desc')
            ->paginate(10);

        return $this->successResponse($bookings, 'Recent Bookings Fetched Successfully');
    }

    public function totalSpent()
    {
        $totalSpent = Booking::where('user_id', auth()->id())
            ->sum('total_amount');

        return response()->json([
            'status' => 'success',
            'data' => [
                'total_spent' => $totalSpent
            ]
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
            'package_id' => 'required|exists:packages,id',
            'schedule_id' => 'required|exists:package_schedules,id',
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

        $package = Package::findOrFail($validated['package_id']);

        $schedule = PackageSchedule::where('id', $validated['schedule_id'])
            ->where('package_id', $package->id)
            ->firstOrFail();

        if ($package->status !== 1) {
            return response()->json([
                'message' => 'Package is not available for booking.'
            ], 422);
        }

        if ($schedule->total_space < $validated['number_of_people']) {
            return response()->json([
                'message' => 'Not enough space available in the selected schedule. Only ' . $schedule->total_space . ' spaces are available.'
            ], 422);
        }

        try {
            DB::beginTransaction();

            $totalAmount = $schedule->price * $validated['number_of_people'];

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
                'package_id' => $validated['package_id'],
                'schedule_id' => $validated['schedule_id'],
                'customer_address_id' => $customerAddress->id,
                'number_of_people' => $validated['number_of_people'],
                'booking_date' => $validated['booking_date'],
                'special_requirements' => $validated['special_requirements'],
                'total_amount' => $totalAmount,
                'status' => 4 // Completed
            ]);

            $schedule->decrement('total_space', $validated['number_of_people']);

            $remainingSchedules = PackageSchedule::where('package_id', $package->id)
                ->where('total_space', '>', 0)
                ->count();

            if ($remainingSchedules == 0) {
                $package->update(['status' => 0]);
            }

            DB::commit();

            $booking->load(['package', 'customerAddress', 'schedule']);

            Mail::send('emails.booking-confirm-mail', ['booking' => $booking], function ($message) use ($validated) {
                $message->to($validated['email'])
                    ->subject('Package Booking Confirmation');
            });

            return $this->successResponse($booking, 'Package booked successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Something went wrong while processing your booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    // public function cancel(Booking $booking)
    // {
    //     if ($booking->user_id !== auth()->id()) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Unauthorized access'
    //         ], 403);
    //     }

    //     if (!in_array($booking->status, [1, 2])) { // Only pending or confirmed bookings can be cancelled
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'This booking cannot be cancelled'
    //         ], 422);
    //     }

    //     try {
    //         DB::beginTransaction();

    //         // Update booking status to cancelled
    //         $booking->status = 3; // cancelled
    //         $booking->save();

    //         // Restore package space
    //         $booking->package->increment('total_space', $booking->number_of_people);

    //         DB::commit();

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Booking cancelled successfully'
    //         ]);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Failed to cancel booking'
    //         ], 500);
    //     }
    // }
}
