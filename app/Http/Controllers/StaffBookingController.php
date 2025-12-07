<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Illuminate\Support\Str;

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
     * Show the form for creating a new booking by staff.
     */
    public function create()
    {
        $staff = Auth::user();
        $boardingHouses = $staff->boardingHouses()->whereNull('deleted_at')->get();
        $guests = User::where('role', 'user')->get();

        return view('staff.bookings.create', compact('boardingHouses', 'guests'));
    }

    /**
     * Store a newly created booking by staff.
     */
    public function store(Request $request)
    {
        $startDate = \Carbon\Carbon::parse($request->input('start_date'));
        $endDate = \Carbon\Carbon::parse($request->input('end_date'));
        $totalDays = $startDate->diffInDays($endDate);
        $durationMonths = (int) floor($totalDays / 30);
        
        $request->merge(['duration_months' => $durationMonths]);

        $validated = $request->validate([
            'guest_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'duration_months' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500',
        ], [
            'duration_months.min' => 'Minimal memesan kamar kos 1 bulan.',
            'guest_id.required' => 'Tamu harus dipilih.',
            'room_id.required' => 'Kamar harus dipilih.',
        ]);

        $room = Room::findOrFail($validated['room_id']);
        
        // Authorization: Check if the admin can manage the room's boarding house
        $this->authorize('update', $room->boardingHouse);

        if ($room->available_units <= 0) {
            return redirect()->back()->withInput()->with('error', 'Kamar ini sudah tidak tersedia.');
        }

        $totalPrice = $room->price_per_month * $durationMonths;
        $bookingCode = 'BOOK-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        Booking::create([
            'booking_code' => $bookingCode,
            'guest_id' => $validated['guest_id'],
            'room_id' => $room->id,
            'boarding_house_id' => $room->boarding_house_id,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'duration_months' => $durationMonths,
            'total_price' => $totalPrice,
            'status' => 'approved', // Staff-created bookings are auto-approved
            'notes' => $validated['notes'] ?? null,
        ]);

        $room->decrement('available_units');

        return redirect()->route('staff.bookings.index')->with('success', 'Booking berhasil dibuat untuk tamu.');
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