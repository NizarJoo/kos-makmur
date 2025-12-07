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
        $startDate = \Carbon\Carbon::parse($request->input('start_date'));
        $endDate = \Carbon\Carbon::parse($request->input('end_date'));

        $totalDays = $startDate->diffInDays($endDate);
        $durationMonths = (int) floor($totalDays / 30);

        // Merge duration_months into the request for validation
        $request->merge(['duration_months' => $durationMonths]);

        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
            'duration_months' => 'required|integer|min:1', // Now validates against merged request data
            'notes' => 'nullable|string|max:500',
        ], [
            'duration_months.min' => 'Minimal memesan kamar kos 1 bulan.',
            'room_id.required' => 'Kamar harus dipilih.',
            'start_date.required' => 'Tanggal mulai harus diisi.',
            'end_date.required' => 'Tanggal berakhir harus diisi.',
            'end_date.after' => 'Tanggal berakhir harus setelah tanggal mulai.',
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

        // total_price: room.price_per_month * duration_months
        $totalPrice = $room->price_per_month * $durationMonths;

        // Generate booking code
        $bookingCode = 'BOOK-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        // ===== SIMPAN BOOKING =====

        $booking = Booking::create([
            'booking_code' => $bookingCode,
            'guest_id' => auth()->id(),
            'room_id' => $room->id,
            'boarding_house_id' => $room->boarding_house_id,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'duration_months' => $durationMonths,
            'total_price' => $totalPrice, 
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

        return redirect()->route('booking.index')
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