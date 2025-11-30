<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\BoardingHouse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Display a listing of user's bookings.
     */
    public function index()
    {
        $bookings = auth()->user()->bookings()
            ->with(['room.boardingHouse', 'boardingHouse'])
            ->latest()
            ->paginate(10);

        return view('guest.bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new booking.
     */
    public function create()
    {
        $boardingHouses = BoardingHouse::whereNull('deleted_at')->get();

        return view('guest.bookings.create', compact('boardingHouses'));
    }

    /**
     * Store a newly created booking.
     * Sesuai SRS Section 4.3.1
     */
    public function store(Request $request)
    {
        // Parse dates and calculate duration_months early
        $checkInDate = \Carbon\Carbon::parse($request->input('check_in_date'));
        $checkOutDate = \Carbon\Carbon::parse($request->input('check_out_date'));

        $totalDays = $checkInDate->diffInDays($checkOutDate);
        $durationMonths = (int) ceil($totalDays / 30);

        // Merge duration_months into the request for validation
        $request->merge(['duration_months' => $durationMonths]);

        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date|after:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'duration_months' => 'required|integer|min:1', // Now validates against merged request data
            'notes' => 'nullable|string|max:500',
        ]);

        $room = Room::with('boardingHouse')->findOrFail($validated['room_id']);

        // ===== VALIDASI SESUAI SRS =====

        // 1. Cek available_units > 0
        if ($room->available_units <= 0) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'This room type is currently not available.');
        }

        // 2. Cek user tidak punya booking active untuk room yang sama
        $hasActiveBooking = auth()->user()->bookings()
            ->where('room_id', $room->id)
            ->where('status', 'active')
            ->exists();

        if ($hasActiveBooking) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'You already have an active booking for this room type.');
        }

        // ===== PERHITUNGAN SESUAI SRS =====
        // Duration months is already calculated and merged into $request and $validated

        // total_amount: room.price_per_month * duration_months
        $totalAmount = $room->price_per_month * $durationMonths;

        // Generate booking code
        $bookingCode = 'BOOK-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        // ===== SIMPAN BOOKING =====

        $booking = Booking::create([
            'booking_code' => $bookingCode,
            'guest_id' => auth()->id(),
            'room_id' => $room->id,
            'boarding_house_id' => $room->boarding_house_id,
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'duration_months' => $durationMonths,
            'total_amount' => $totalAmount, // Changed from totalPrice
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
        ]);

        // TODO: Kirim notifikasi ke Admin
        // event(new BookingCreated($booking));

        return redirect()->route('guest.bookings.show', $booking->id)
            ->with('success', 'Booking request submitted successfully! Please wait for admin approval.');
    }

    /**
     * Display the specified booking.
     */
    public function show($id)
    {
        $booking = auth()->user()->bookings()
            ->with(['room.boardingHouse', 'boardingHouse'])
            ->findOrFail($id);

        return view('guest.bookings.show', compact('booking'));
    }

    /**
     * Cancel a pending booking.
     */
    public function cancel($id)
    {
        $booking = auth()->user()->bookings()->findOrFail($id);

        if ($booking->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Only pending bookings can be cancelled.');
        }

        $booking->update(['status' => 'cancelled']);

        return redirect()->route('guest.bookings.index')
            ->with('success', 'Booking cancelled successfully.');
    }

    /**
     * Get available rooms for a specific boarding house (AJAX).
     */
    public function getAvailableRooms($boardingHouseId)
    {
        $rooms = Room::where('boarding_house_id', $boardingHouseId)
            ->whereNull('deleted_at')
            ->with('facilities')
            ->get();

        return response()->json($rooms);
    }
}