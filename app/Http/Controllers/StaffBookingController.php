<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffBookingController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of bookings for the staff member's boarding houses.
     */
    public function index()
    {
        $staff = Auth::user();
        
        // Get the IDs of the boarding houses managed by the staff
        $boardingHouseIds = $staff->boardingHouses()->pluck('id');

        // Fetch bookings related to those boarding houses
        $bookings = Booking::whereIn('boarding_house_id', $boardingHouseIds)
            ->with(['room', 'user', 'boardingHouse'])
            ->latest()
            ->paginate(15);

        return view('staff.bookings.index', compact('bookings'));
    }

    /**
     * Approve a booking request.
     */
    public function approve(Booking $booking)
    {
        // Authorization: Ensure the booking belongs to a boarding house managed by the staff
        $this->authorize('update', $booking);

        if ($booking->status !== 'pending') {
            return redirect()->route('staff.bookings.index')->with('error', 'This booking has already been processed.');
        }

        $room = $booking->room;

        // Check for room availability
        if ($room->available_units <= 0) {
            return redirect()->route('staff.bookings.index')->with('error', 'The room is no longer available.');
        }

        // Update booking status and decrement available units
        $booking->update(['status' => 'approved']);
        $room->decrement('available_units');

        // TODO: Send notification to the user

        return redirect()->route('staff.bookings.index')->with('success', 'Booking approved successfully.');
    }

    /**
     * Reject a booking request.
     */
    public function reject(Request $request, Booking $booking)
    {
        // Authorization: Ensure the booking belongs to a boarding house managed by the staff
        $this->authorize('update', $booking);

        if ($booking->status !== 'pending') {
            return redirect()->route('staff.bookings.index')->with('error', 'This booking has already been processed.');
        }

        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $booking->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        // TODO: Send notification to the user

        return redirect()->route('staff.bookings.index')->with('success', 'Booking rejected successfully.');
    }
}