<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class GuestController extends Controller
{
    public function index()
    {
        // This page might need to be refactored or removed as it lists a deprecated Guest model.
        // For now, we will fetch users with the 'user' role.
        $guests = User::where('role', 'user')->latest()->paginate(15);
        return view('staff.guests.index', compact('guests'));
    }

    public function create()
    {
        return view('staff.guests.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        return redirect()->route('staff.bookings.index')->with('success', 'Akun tamu berhasil dibuat.');
    }

    public function show(Guest $guest)
    {
        $guest->load(['bookings.room']);
        return view('guests.show', compact('guest'));
    }

    public function edit(Guest $guest)
    {
        return view('guests.edit', compact('guest'));
    }

    public function update(Request $request, Guest $guest)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'id_number' => 'required|string|max:50|unique:guests,id_number,' . $guest->id,
        ]);

        $guest->update($validated);
        return redirect()->route('guests.show', $guest)->with('success', 'Guest updated successfully');
    }

    public function destroy(Guest $guest)
    {
        if ($guest->bookings()->where('status', 'active')->exists()) {
            return back()->with('error', 'Cannot delete guest with active bookings');
        }

        $guest->delete();
        return redirect()->route('guests.index')->with('success', 'Guest deleted successfully');
    }
}
