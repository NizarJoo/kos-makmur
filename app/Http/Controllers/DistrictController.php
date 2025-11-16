<?php

namespace App\Http\Controllers;

use App\Http\Requests\DistrictRequest;
use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    /**
     * Display a listing of the districts.
     */
    public function index()
    {
        $districts = District::withCount('kos')
            ->orderBy('name')
            ->paginate(15);

        return view('districts.index', compact('districts'));
    }

    /**
     * Show the form for creating a new district.
     */
    public function create()
    {
        return view('districts.create');
    }

    /**
     * Store a newly created district in storage.
     */
    public function store(DistrictRequest $request)
    {
        District::create($request->validated());

        return redirect()
            ->route('districts.index')
            ->with('success', 'Kecamatan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified district.
     */
    public function edit(District $district)
    {
        return view('districts.edit', compact('district'));
    }

    /**
     * Update the specified district in storage.
     */
    public function update(DistrictRequest $request, District $district)
    {
        $district->update($request->validated());

        return redirect()
            ->route('districts.index')
            ->with('success', 'Kecamatan berhasil diperbarui.');
    }

    /**
     * Remove the specified district from storage.
     */
    public function destroy(District $district)
    {
        // Check if district has any kos
        if ($district->kos()->exists()) {
            return redirect()
                ->route('districts.index')
                ->with('error', 'Tidak dapat menghapus kecamatan yang memiliki data kos.');
        }

        $district->delete();

        return redirect()
            ->route('districts.index')
            ->with('success', 'Kecamatan berhasil dihapus.');
    }
}