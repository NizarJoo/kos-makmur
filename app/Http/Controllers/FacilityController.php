<?php

namespace App\Http\Controllers;

use App\Http\Requests\FacilityRequest;
use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    /**
     * Display a listing of the fasilitas.
     */
    public function index()
    {
        $facilities = Facility::withCount('rooms')
            ->orderBy('name')
            ->paginate(15);

        return view('facilities.index', compact('facilities'));
    }

    /**
     * Show the form for creating a new fasilitas.
     */
    public function create()
    {
        return view('facilities.create');
    }

    /**
     * Store a newly created fasilitas in storage.
     */
    public function store(FacilityRequest $request)
    {
        Facility::create($request->validated());

        return redirect()
            ->route('facilities.index')
            ->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified fasilitas.
     */
    public function edit(Facility $facility)
    {
        return view('facilities.edit', compact('facility'));
    }

    /**
     * Update the specified fasilitas in storage.
     */
    public function update(FacilityRequest $request, Facility $facility)
    {
        $facility->update($request->validated());

        return redirect()
            ->route('facilities.index')
            ->with('success', 'Fasilitas berhasil diperbarui.');
    }

    /**
     * Remove the specified fasilitas from storage.
     */
    public function destroy(facility $facility)
    {
        // Check if facilitys is used by any kamar
        if ($facility->rooms()->exists()) {
            return redirect()
                ->route('facilities.index')
                ->with('error', 'Tidak dapat menghapus fasilitas yang sedang digunakan oleh kamar.');
        }

        $facility->delete();

        return redirect()
            ->route('facilities.index')
            ->with('success', 'Fasilitas berhasil dihapus.');
    }
}