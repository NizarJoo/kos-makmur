<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UserProfileController extends Controller
{
    /**
     * Show the form for creating first time profile.
     */
    public function create(): View
    {
        return view('profile.create');
    }

    /**
     * Store first time profile data.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name'      => ['required', 'string', 'max:255'],
            'phone'          => ['required', 'string', 'max:20'],
            'address'        => ['required', 'string'],
            'birth_date'     => ['required', 'date'],
            'gender'         => ['required', 'in:male,female,other'],
            'profile_picture'=> ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
        ]);

        $user = Auth::user();

        // Update nama di tabel user
        $user->name = $validated['full_name'];
        $user->save();

        // Upload foto
        if ($request->hasFile('profile_picture')) {
            $validated['profile_picture'] = 
                $request->file('profile_picture')->store('profile-pictures', 'public');
        }

        // Buat profil
        $user->profile()->create($validated);

        return redirect()->route('dashboard')->with('status', 'Profil berhasil dibuat!');
    }

    /**
     * Show the form for editing the user's profile and account.
     */
    public function edit(): View
    {
        $user = Auth::user();
        $profile = $user->profile;

        return view('profile.edit', [
            'user' => $user,
            'profile' => $profile
        ]);
    }

    /**
     * Update biodata profile.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name'      => ['required', 'string', 'max:255'],
            'phone'          => ['required', 'string', 'max:20'],
            'address'        => ['required', 'string'],
            'birth_date'     => ['required', 'date'],
            'gender'         => ['required', 'in:male,female,other'],
            'profile_picture'=> ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
        ]);

        $user = Auth::user();

        // Update nama di tabel users
        $user->name = $validated['full_name'];
        $user->save();

        $profile = $user->profile;

        // Upload foto baru
        if ($request->hasFile('profile_picture')) {

            // Hapus jika ada foto lama
            if ($profile && $profile->profile_picture) {
                Storage::disk('public')->delete($profile->profile_picture);
            }

            $validated['profile_picture'] =
                $request->file('profile_picture')->store('profile-pictures', 'public');
        }

        // Update atau buat profil
        $user->profile()->updateOrCreate(['user_id' => $user->id], $validated);

        return redirect()->route('profile.edit')->with('status', 'Profil berhasil diperbarui!');
    }
}