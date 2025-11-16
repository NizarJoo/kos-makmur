<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    public function create()
    {
        // jika sudah punya profil yang lengkap, redirect ke dashboard
        $user = Auth::user();
        if ($user->profile && $this->isProfileComplete($user->profile)) {
            return redirect()->route('dashboard');
        }

        return view('profile.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:1000',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();

        // handle file upload
        $picturePath = null;
        if ($request->hasFile('profile_picture')) {
            $picturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        $user->profile()->create([
            'phone' => $request->phone,
            'address' => $request->address,
            'profile_picture' => $picturePath,
        ]);

        return redirect()->route('dashboard')->with('success', 'Profil berhasil disimpan.');
    }

    public function edit()
    {
        $profile = Auth::user()->profile;
        return view('profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:1000',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();
        $profile = $user->profile;

        // handle file replace
        if ($request->hasFile('profile_picture')) {
            // hapus file lama kalau ada
            if ($profile && $profile->profile_picture) {
                Storage::disk('public')->delete($profile->profile_picture);
            }
            $profile_picture = $request->file('profile_picture')->store('profile_pictures', 'public');
        } else {
            $profile_picture = $profile->profile_picture ?? null;
        }

        if ($profile) {
            $profile->update([
                'phone' => $request->phone,
                'address' => $request->address,
                'profile_picture' => $profile_picture,
            ]);
        } else {
            $user->profile()->create([
                'phone' => $request->phone,
                'address' => $request->address,
                'profile_picture' => $profile_picture,
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Profil diperbarui.');
    }

    // helper lokal: apa sudah lengkap (atur sesuai kebutuhan)
    protected function isProfileComplete($profile): bool
    {
        return $profile && $profile->phone && $profile->address;
    }
}
