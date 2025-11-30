<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomRequest;
use App\Models\BoardingHouse;
use App\Models\Facility;
use App\Models\Room;
use App\Services\FileUploadService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RoomController extends Controller
{
    use AuthorizesRequests;

    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Show the form for creating a new room.
     */
    public function create(BoardingHouse $boardingHouse)
    {
        $this->authorize('create', [Room::class, $boardingHouse]);

        $facilities = Facility::orderBy('name')->get();

        return view('rooms.create', compact('boardingHouse', 'facilities'));
    }

    /**
     * Store a newly created room in storage.
     */
    public function store(RoomRequest $request, BoardingHouse $boardingHouse)
    {
        $this->authorize('create', [Room::class, $boardingHouse]);

        $data = $request->validated();
        $data['boarding_house_id'] = $boardingHouse->id;

        // Set available_units sama dengan availability saat pertama kali dibuat
        $data['available_units'] = $data['availability'];

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image_path'] = $this->fileUploadService->upload(
                $request->file('image'),
                'rooms'
            );
        }

        // Extract facilities data before creating room
        $facilities = $data['facilities'] ?? [];
        unset($data['facilities']);

        $room = Room::create($data);

        // Attach facilities if any
        if (!empty($facilities)) {
            $room->facilities()->attach($facilities);
        }

        return redirect()
            ->route('boarding-houses.show', $boardingHouse)
            ->with('success', 'Room added successfully.');
    }

    /**
     * Show the form for editing the specified room.
     */
    public function edit(BoardingHouse $boardingHouse, Room $room)
    {
        $this->authorize('update', $room);

        $facilities = Facility::orderBy('name')->get();

        return view('rooms.edit', compact('boardingHouse', 'room', 'facilities'));
    }

    /**
     * Update the specified room in storage.
     */
    public function update(RoomRequest $request, BoardingHouse $boardingHouse, Room $room)
    {
        $this->authorize('update', $room);

        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image_path'] = $this->fileUploadService->upload(
                $request->file('image'),
                'rooms',
                $room->image_path
            );
        }

        // Extract facilities data before updating room
        $facilities = $data['facilities'] ?? [];
        unset($data['facilities']);

        $room->update($data);

        // Sync facilities
        $room->facilities()->sync($facilities);

        return redirect()
            ->route('boarding-houses.show', $boardingHouse)
            ->with('success', 'Room updated successfully.');
    }

    /**
     * Remove the specified room from storage.
     */
    public function destroy(BoardingHouse $boardingHouse, Room $room)
    {
        $this->authorize('delete', $room);

        // Check if room has active bookings
        // TODO: Uncomment this when booking system is implemented
        // if ($room->bookings()->whereIn('status', ['pending', 'approved', 'active'])->exists()) {
        //     return redirect()
        //         ->route('boarding-houses.show', $boardingHouse)
        //         ->with('error', 'Cannot delete room with active bookings.');
        // }

        // Delete image
        if ($room->image_path) {
            $this->fileUploadService->delete($room->image_path);
        }

        // Detach facilities
        $room->facilities()->detach();

        $room->delete();

        return redirect()
            ->route('boarding-houses.show', $boardingHouse)
            ->with('success', 'Room deleted successfully.');
    }
}