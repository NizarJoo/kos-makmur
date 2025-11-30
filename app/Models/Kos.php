<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use App\Models\User;
use App\Models\Guest;

// HAPUS BARIS INI JIKA MODEL KOS TIDAK ADA:
// use App\Models\Kos;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function index()
    {
        // Logic untuk admin dashboard
        $stats = $this->getAdminStats();
        
        return view('admin.dashboard', compact('stats'));
    }

    /**
     * Display superadmin dashboard
     */
    public function superadmin()
    {
        // Logic untuk superadmin dashboard
        $stats = $this->getSuperadminStats();
        
        return view('superadmin.dashboard', compact('stats'));
    }

    /**
     * Get admin dashboard statistics
     */
    private function getAdminStats()
    {
        return [
            'activeBookings' => Booking::where('status', 'active')->count(),
            'checkoutsToday' => Booking::whereDate('check_out', today())->count(),
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

    /**
     * Get superadmin dashboard statistics - PERBAIKAN DI SINI
     */
    private function getSuperadminStats()
    {
        // GUNAKAN MODEL YANG SUDAH ADA DI PROJECT ANDA
        // Jika tidak ada model Kos, gunakan model Room atau lainnya
        
        return [
            'pendingVerification' => 0, // Sementara set 0, nanti disesuaikan
            'totalUsers' => User::count(),
            'totalKos' => Room::count(), // Gunakan Room sebagai ganti Kos
            'activeBookings' => Booking::where('status', 'active')->count(),
        ];
        
        // ATAU JIKA INGIN LEBIH AMAN, GUNAKAN INI:
        /*
        try {
            $pendingVerification = \App\Models\Kos::where('is_verified', false)->count();
            $totalKos = \App\Models\Kos::count();
        } catch (\Exception $e) {
            $pendingVerification = 0;
            $totalKos = Room::count();
        }
        
        return [
            'pendingVerification' => $pendingVerification,
            'totalUsers' => User::count(),
            'totalKos' => $totalKos,
            'activeBookings' => Booking::where('status', 'active')->count(),
        ];
        */
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