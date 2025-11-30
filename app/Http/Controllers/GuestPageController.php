<?php

namespace App\Http\Controllers;

use App\Models\BoardingHouse;
use App\Models\District;
use Illuminate\Http\Request;

class GuestPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = BoardingHouse::query()->where('is_verified', true);

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->filled('district_id')) {
            $query->where('district_id', $request->input('district_id'));
        }

        $boardingHouses = $query->latest()->paginate(9);
        $districts = District::all();

        return view('guest.boarding-houses.index', compact('boardingHouses', 'districts'));
    }

    /**
     * Display the specified resource.
     */
    public function show(BoardingHouse $boarding_house)
    {
        return view('guest.boarding-houses.show', [
            'boardingHouse' => $boarding_house
        ]);
    }
}
