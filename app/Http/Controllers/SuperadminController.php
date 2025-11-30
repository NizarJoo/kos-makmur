<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SuperadminController extends Controller
{
    public function index()
    {
        $users = User::where('verification_status', 'pending')->get();
        return view('superadmin.approvals', compact('users'));
    }

    public function approve(User $user)
    {
        $user->update([
            'role' => 'admin',
            'verification_status' => 'approved',
            'verified_at' => now(),
        ]);

        return redirect()->route('superadmin.approvals')->with('success', 'User approved as admin.');
    }

    public function reject(User $user)
    {
        $user->update([
            'verification_status' => 'rejected',
        ]);

        return redirect()->route('superadmin.approvals')->with('success', 'User rejected.');
    }
}
