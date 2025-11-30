<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Kos;

class SuperadminController extends Controller
{
    public function index()
    {
        $stats = [
            'pendingVerification' => Kos::where('is_verified', false)->count(),
            'totalUsers' => User::count(),
            'totalKos' => Kos::count(),
            'activeBookings' => Booking::where('status', 'active')->count(),
        ];

        return view('superadmin.dashboard', compact('stats'));
    }
}