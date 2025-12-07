<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isSuperadmin()) {
            $stats = [
                'totalUsers' => User::where('role', 'user')->count(),
                'totalAdmins' => User::where('role', 'admin')->count(),
                'totalBoardingHouses' => \App\Models\BoardingHouse::count(),
                'pendingVerifications' => \App\Models\BoardingHouse::where('is_verified', false)->count(),
            ];
            $recentUsers = User::where('role', 'user')->latest()->take(5)->get();
            return view('superadmin.dashboard', compact('stats', 'recentUsers'));

        } elseif ($user->isAdmin()) {
            $boardingHouseIds = $user->boardingHouses()->pluck('id');

            $totalRooms = Room::whereIn('boarding_house_id', $boardingHouseIds)->count();
            $occupiedRooms = Room::whereIn('boarding_house_id', $boardingHouseIds)->where('status', 'occupied')->count();

            $stats = [
                'totalRooms' => $totalRooms,
                'availableRooms' => Room::whereIn('boarding_house_id', $boardingHouseIds)->where('status', 'available')->count(),
                'occupiedRooms' => $occupiedRooms,
                'pendingBookings' => Booking::whereIn('boarding_house_id', $boardingHouseIds)->where('status', 'pending')->count(),
                'activeBookings' => Booking::whereIn('boarding_house_id', $boardingHouseIds)->where('status', 'active')->count(),
                'monthlyRevenue' => Booking::whereIn('boarding_house_id', $boardingHouseIds)
                    ->where('status', '!=', 'cancelled')
                    ->whereMonth('created_at', Carbon::now()->month)
                    ->sum('total_price'),
                'occupancyRate' => $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100) : 0,
            ];

            $pendingBookings = Booking::whereIn('boarding_house_id', $boardingHouseIds)
                ->with(['room', 'user'])
                ->where('status', 'pending')
                ->latest()
                ->take(5)
                ->get();

            return view('staff.dashboard', compact('stats', 'pendingBookings'));
        }

        // Fallback for any other roles or direct access, though middleware should prevent this.
        return redirect('/');
    }

    public function dashboard()
    {
        // Load relasi room dengan eager loading
        $bookings = auth()->user()->bookings()
            ->with('room') // TAMBAHKAN INI
            ->latest()
            ->take(5)
            ->get();

        return view('guest.dashboard', compact('bookings'));
    }
}
