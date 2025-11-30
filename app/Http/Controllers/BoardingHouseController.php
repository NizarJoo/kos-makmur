<?php

namespace App\Http\Controllers;

use App\Http\Requests\BoardingHouseRequest;
use App\Models\BoardingHouse;
use App\Models\District;
use App\Services\FileUploadService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class BoardingHouseController extends Controller
{
    use AuthorizesRequests;

    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Display a listing of boarding houses owned by the authenticated admin.
     */
    public function index()
    {
        $this->authorize('viewAny', BoardingHouse::class);

        $boardingHouses = BoardingHouse::with(['district', 'rooms'])
            ->ownedBy(auth()->id())
            ->withCount('rooms')
            ->latest()
            ->paginate(10);

        return view('boarding-houses.index', compact('boardingHouses'));
    }

    /**
     * Show the form for creating a new boarding house.
     */
    public function create()
    {
        $this->authorize('create', BoardingHouse::class);

        $districts = District::orderBy('name')->get();

        return view('boarding-houses.create', compact('districts'));
    }

    /**
     * Store a newly created boarding house in storage.
     */
    public function store(BoardingHouseRequest $request)
    {
        $this->authorize('create', BoardingHouse::class);

        $data = $request->validated();
        $data['admin_id'] = auth()->id();
        $data['is_verified'] = false;

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image_path'] = $this->fileUploadService->upload(
                $request->file('image'),
                'boarding-houses'
            );
        }

        $boardingHouse = BoardingHouse::create($data);

        // TODO: Send notification to superadmin for verification

        return redirect()
            ->route('boarding-houses.index')
            ->with('success', 'Boarding house created successfully. Waiting for verification.');
    }

    /**
     * Display the specified boarding house with its rooms.
     */
    public function show(BoardingHouse $boardingHouse)
    {
        $this->authorize('view', $boardingHouse);

        $boardingHouse->load(['district', 'rooms.facilities']);

        return view('boarding-houses.show', compact('boardingHouse'));
    }

    /**
     * Show the form for editing the specified boarding house.
     */
    public function edit(BoardingHouse $boardingHouse)
    {
        $this->authorize('update', $boardingHouse);

        $districts = District::orderBy('name')->get();

        return view('boarding-houses.edit', compact('boardingHouse', 'districts'));
    }

    /**
     * Update the specified boarding house in storage.
     */
    public function update(BoardingHouseRequest $request, BoardingHouse $boardingHouse)
    {
        $this->authorize('update', $boardingHouse);

        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image_path'] = $this->fileUploadService->upload(
                $request->file('image'),
                'boarding-houses',
                $boardingHouse->image_path
            );
        }

        $boardingHouse->update($data);

        return redirect()
            ->route('boarding-houses.index')
            ->with('success', 'Boarding house updated successfully.');
    }

    /**
     * Remove the specified boarding house from storage.
     */
    public function destroy(BoardingHouse $boardingHouse)
    {
        $this->authorize('delete', $boardingHouse);

        // Check if boarding house has rooms
        if ($boardingHouse->rooms()->exists()) {
            return redirect()
                ->route('boarding-houses.index')
                ->with('error', 'Cannot delete boarding house that has rooms. Please delete all rooms first.');
        }

        // Delete image
        if ($boardingHouse->image_path) {
            $this->fileUploadService->delete($boardingHouse->image_path);
        }

        $boardingHouse->delete();

        return redirect()
            ->route('boarding-houses.index')
            ->with('success', 'Boarding house deleted successfully.');
    }
}