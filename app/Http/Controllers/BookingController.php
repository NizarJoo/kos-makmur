<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['guest', 'room'])->latest();

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $bookings = $query->paginate(10);

        // DEBUG: Cek data booking
        logger('Bookings data:', [
            'total' => $bookings->count(),
            'pending_count' => $bookings->where('status', 'pending')->count(),
            'first_booking' => $bookings->first() ? [
                'id' => $bookings->first()->id,
                'status' => $bookings->first()->status,
                'guest' => $bookings->first()->guest ? $bookings->first()->guest->name : 'No guest',
                'room' => $bookings->first()->room ? $bookings->first()->room->name : 'No room'
            ] : 'No bookings'
        ]);

        return view('admin.bookings.index', compact('bookings'));
    }
    public function create()
    {
        $rooms = Room::where('status', 'available')->get();
        $guests = Guest::all();
        return view('bookings.create', compact('rooms', 'guests'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'guest_ids' => 'required|array',
            'guest_ids.*' => 'exists:guests,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
        ]);

        $room = Room::findOrFail($request->room_id);

        // Calculate total days
        $checkIn = \Carbon\Carbon::parse($request->check_in_date);
        $checkOut = \Carbon\Carbon::parse($request->check_out_date);
        $days = $checkIn->diffInDays($checkOut);

        // Create the main booking with the first guest
        $booking = Booking::create([
            'guest_id' => $validated['guest_ids'][0], // Primary guest
            'room_id' => $validated['room_id'],
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'status' => 'active',
            'total_amount' => $room->price_per_night * $days
        ]);

        // Create additional guest bookings if any
        foreach (array_slice($validated['guest_ids'], 1) as $additionalGuestId) {
            Booking::create([
                'guest_id' => $additionalGuestId,
                'room_id' => $validated['room_id'],
                'check_in_date' => $validated['check_in_date'],
                'check_out_date' => $validated['check_out_date'],
                'status' => 'active',
                'total_amount' => 0 // Only primary guest pays
            ]);
        }

        // Update room status
        $room->update(['status' => 'occupied']);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Booking created successfully');
    }

    public function show(Booking $booking)
    {
        $booking->load(['guest', 'room']);
        return view('bookings.show', compact('booking'));
    }

    public function checkout(Booking $booking)
    {
        $booking->update(['status' => 'completed']);
        $booking->room->update(['status' => 'available']);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Guest checked out successfully');
    }
    public function approve(Booking $booking)
    {
        // Authorization check - hanya admin yang bisa approve
        if (!auth()->user()->isAdmin()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menyetujui booking.');
        }

        // Validasi status booking
        if (!$booking->canBeApproved()) {
            return redirect()->back()->with('error', 'Booking tidak dapat disetujui.');
        }

        DB::transaction(function () use ($booking) {
            $booking->update([
                'status' => Booking::STATUS_APPROVED,
                'rejection_reason' => null
            ]);

            $room = $booking->room;
            if ($room->available_units > 0) {
                $room->decrement('available_units');
            }
        });

        return redirect()->route('bookings.index')
            ->with('success', 'Booking berhasil disetujui.');
    }

    /**
     * Reject a booking
     */
    public function reject(Request $request, Booking $booking)
    {
        // Authorization check - hanya admin yang bisa reject
        if (!auth()->user()->isAdmin()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menolak booking.');
        }

        // Validasi status booking
        if (!$booking->canBeRejected()) {
            return redirect()->back()->with('error', 'Booking tidak dapat ditolak.');
        }

        // Validasi alasan penolakan
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        DB::transaction(function () use ($booking, $request) {
            $booking->update([
                'status' => Booking::STATUS_REJECTED,
                'rejection_reason' => $request->rejection_reason
            ]);
        });

        return redirect()->route('bookings.index')
            ->with('success', 'Booking berhasil ditolak.');
    }

    /**
     * Show rejection form
     */
    public function showRejectForm(Booking $booking)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        if (!$booking->canBeRejected()) {
            return redirect()->back()->with('error', 'Booking tidak dapat ditolak.');
        }

        return view('admin.bookings.reject', compact('booking'));
    }

}

