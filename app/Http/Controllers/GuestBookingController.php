<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\Guest;
use Illuminate\Http\Request;
use Carbon\Carbon;

class GuestBookingController extends Controller
{
    public function index()
    {
        $bookings = Auth::user()->bookings()->latest()->get();
        return view('guest.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $availableRooms = Room::where('status', 'available')
            ->orderBy('room_type')
            ->get()
            ->groupBy('room_type');

        if ($availableRooms->isEmpty()) {
            return back()->with('error', 'No rooms are available at the moment.');
        }

        return view('guest.bookings.create', compact('availableRooms'));
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date|after:today',
            'check_out_date' => 'required|date|after:check_in_date',
        ]);

        // Cari kamar
        $room = Room::findOrFail($request->room_id);

        // Validasi ketersediaan kamar
        if ($room->available_units <= 0) {
            return back()->with('error', 'Kamar tidak tersedia untuk tanggal yang dipilih.');
        }

        // Hitung total amount
        $checkIn = Carbon::parse($request->check_in_date);
        $checkOut = Carbon::parse($request->check_out_date);
        $nights = $checkIn->diffInDays($checkOut);
        $totalAmount = $room->price_per_night * $nights;

        // Buat booking - GUNAKAN check_in_date dan check_out_date
        $booking = Booking::create([
            'room_id' => $room->id,
            'guest_id' => auth()->id(),
            'check_in_date' => $request->check_in_date,    // PASTIKAN INI
            'check_out_date' => $request->check_out_date,  // PASTIKAN INI
            'total_amount' => $totalAmount,
            'status' => 'pending', // Status awal pending
        ]);

        return redirect()->route('guest.bookings')
            ->with('success', 'Booking berhasil dibuat! Menunggu persetujuan admin.');
    }
}
