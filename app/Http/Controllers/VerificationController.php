<?php

namespace App\Http\Controllers;

use App\Models\BoardingHouse;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /**
     * Display list of boarding houses pending verification.
     */
    public function index()
    {
        $boardingHouses = BoardingHouse::with(['admin', 'district'])
            ->pendingVerification()
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('verification.index', compact('boardingHouses'));
    }

    /**
     * Show detail of boarding house for verification.
     */
    public function show(BoardingHouse $boardingHouse)
    {
        $boardingHouse->load(['admin', 'district', 'rooms.facilities']);

        return view('verification.show', compact('boardingHouse'));
    }

    /**
     * Approve boarding house verification.
     */
    public function approve(BoardingHouse $boardingHouse)
    {
        // Check if already verified
        if ($boardingHouse->is_verified) {
            return redirect()
                ->route('verification.index')
                ->with('info', 'Kos ini sudah diverifikasi sebelumnya.');
        }

        $boardingHouse->update(['is_verified' => true]);

        // TODO: Send notification to admin (implement later)
        // Notification::send($boardingHouse->admin, new KosVerifiedNotification($boardingHouse));

        return redirect()
            ->route('verification.index')
            ->with('success', 'Kos berhasil diverifikasi dan sekarang dapat dilihat oleh publik.');
    }

    /**
     * Reject boarding house verification.
     */
    public function reject(Request $request, BoardingHouse $boardingHouse)
    {
        // Validate rejection reason (optional for MVP)
        $request->validate([
            'rejection_reason' => 'nullable|string|max:500'
        ]);

        // For MVP, we just keep is_verified = false
        // TODO: Send notification to admin with rejection reason
        // Notification::send($boardingHouse->admin, new KosRejectedNotification($boardingHouse, $request->rejection_reason));

        return redirect()
            ->route('verification.index')
            ->with('success', 'Kos ditolak. Admin akan menerima notifikasi.');
    }
}