<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Kamar;
use App\Models\Kos;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Display a listing of user's bookings.
     * Sesuai SRS: User hanya bisa melihat bookings miliknya
     */
    public function index()
    {
        $bookings = auth()->user()->bookings()
            ->with(['kamar.kos', 'kos']) // Eager loading untuk performa
            ->latest()
            ->paginate(10);
        
        return view('guest.bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new booking.
     */
    public function create()
    {
        // Ambil semua kos yang sudah verified dengan kamar yang available
        $kosItems = Kos::where('is_verified', true)
            ->with(['kamar' => function($query) {
                $query->where('available_units', '>', 0)
                      ->whereNull('deleted_at');
            }])
            ->whereNull('deleted_at')
            ->get();
        
        return view('guest.bookings.create', compact('kosItems'));
    }

    /**
     * Store a newly created booking in storage.
     * Sesuai SRS Section 4.3.1: Alur User: Pencarian & Pengajuan Booking
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kamar_id' => 'required|exists:kamar,id',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
            'notes' => 'nullable|string|max:500',
        ]);

        $kamar = Kamar::with('kos')->findOrFail($validated['kamar_id']);
        
        // ===== VALIDASI SESUAI SRS =====
        
        // 1. Cek available_units > 0
        if ($kamar->available_units <= 0) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'This room type is currently not available.');
        }

        // 2. Cek user tidak punya booking active untuk kamar yang sama
        $hasActiveBooking = auth()->user()->bookings()
            ->where('kamar_id', $kamar->id)
            ->where('status', 'active')
            ->exists();
        
        if ($hasActiveBooking) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'You already have an active booking for this room type.');
        }

        // ===== PERHITUNGAN SESUAI SRS (Section 5.1) =====
        
        $startDate = \Carbon\Carbon::parse($validated['start_date']);
        $endDate = \Carbon\Carbon::parse($validated['end_date']);
        
        // duration_months: CEIL(DATEDIFF(end_date, start_date) / 30)
        $totalDays = $startDate->diffInDays($endDate);
        $durationMonths = (int) ceil($totalDays / 30);
        
        // total_price: kamar.price * duration_months
        $totalPrice = $kamar->price * $durationMonths;

        // Generate booking code: format BOOK-YYYYMMDD-XXXXX
        $bookingCode = 'BOOK-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        // ===== SIMPAN BOOKING =====
        
        $booking = Booking::create([
            'booking_code' => $bookingCode,
            'user_id' => auth()->id(),
            'kamar_id' => $kamar->id,
            'kos_id' => $kamar->kos_id,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'duration_months' => $durationMonths,
            'total_price' => $totalPrice,
            'status' => 'pending', // Status awal selalu pending
            'notes' => $validated['notes'],
        ]);

        // TODO: Kirim notifikasi ke Admin pemilik kos (akan diimplementasikan nanti)
        // $this->notifyAdmin($kamar->kos->admin_id, $booking);

        return redirect()->route('guest.booking.show', $booking->id)
            ->with('success', 'Booking request submitted successfully! Please wait for admin approval.');
    }

    /**
     * Display the specified booking.
     */
    public function show($id)
    {
        // User hanya bisa melihat booking miliknya sendiri
        $booking = auth()->user()->bookings()
            ->with(['kamar.kos', 'kos'])
            ->findOrFail($id);
        
        return view('guest.bookings.show', compact('booking'));
    }

    /**
     * Cancel a pending booking.
     * Sesuai SRS: User bisa cancel booking dengan status 'pending'
     */
    public function cancel($id)
    {
        $booking = auth()->user()->bookings()->findOrFail($id);
        
        // Validasi: hanya booking dengan status 'pending' yang bisa di-cancel
        if ($booking->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Only pending bookings can be cancelled.');
        }
        
        $booking->update(['status' => 'cancelled']);
        
        return redirect()->route('guest.bookings.index')
            ->with('success', 'Booking cancelled successfully.');
    }

    /**
     * Get available rooms for a specific kos (AJAX).
     * Digunakan di form create untuk dynamic room selection
     */
    public function getAvailableRooms($kosId)
    {
        $kamarList = Kamar::where('kos_id', $kosId)
            ->where('available_units', '>', 0)
            ->whereNull('deleted_at')
            ->with('fasilitas')
            ->get();
        
        return response()->json($kamarList);
    }
}