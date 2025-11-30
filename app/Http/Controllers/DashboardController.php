<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use App\Models\User;
use App\Models\Guest;

class DashboardController extends Controller
{
    /**
     * Display dashboard based on user role
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->isSuperadmin()) {
            return $this->superadminDashboard();
        } elseif ($user->isAdmin()) {
            return $this->adminDashboard();
        } else {
            return $this->guestDashboard();
        }
    }

    /**
     * Superadmin Dashboard
     */
    private function superadminDashboard()
    {
        $stats = [
            'pendingVerification' => 0, // Sementara 0, nanti disesuaikan
            'totalUsers' => User::count(),
            'totalKos' => Room::count(),
            'activeBookings' => Booking::where('status', 'active')->count(),
        ];

        return view('superadmin.dashboard', compact('stats'));
    }

    /**
     * Admin Dashboard
     */
    private function adminDashboard()
    {
        $stats = $this->getAdminStats();
        return view('admin.dashboard', compact('stats'));
    }

    /**
     * Guest Dashboard  
     */
    private function guestDashboard()
    {
        return view('guest.dashboard');
    }

    /**
     * Get admin dashboard statistics
     */
    private function getAdminStats()
    {
        return [
            'activeBookings' => Booking::where('status', 'active')->count(),
            'checkoutsToday' => Booking::whereDate('check_out_date', today())->count(),
            'availableRooms' => Room::where('status', 'available')->count(),
            'occupancyRate' => $this->calculateOccupancyRate(),
            'totalGuests' => Guest::count(),
            'newGuestsThisMonth' => Guest::whereMonth('created_at', now()->month)->count(),
            'monthlyRevenue' => $this->calculateMonthlyRevenue(),
            'revenueGrowth' => 0,
            'occupiedRooms' => Room::where('status', 'occupied')->count(),
            'maintenanceRooms' => Room::where('status', 'maintenance')->count(),
        ];
    }

    private function calculateOccupancyRate()
    {
        $totalRooms = Room::count();
        $occupiedRooms = Room::where('status', 'occupied')->count();

        return $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100) : 0;
    }

    private function calculateMonthlyRevenue()
    {
        return Booking::where('status', 'active')
            ->whereMonth('created_at', now()->month)
            ->sum('total_amount') ?? 0;
    }
}