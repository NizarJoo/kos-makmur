<?php

namespace App\Policies;

use App\Models\Room;
use App\Models\User;
use App\Models\BoardingHouse;

class RoomPolicy
{
    /**
     * Determine if the user can view any rooms.
     */
    public function viewAny(User $user, BoardingHouse $boardingHouse): bool
    {
        return $user->id === $boardingHouse->admin_id;
    }

    /**
     * Determine if the user can view the room.
     */
    public function view(User $user, Room $room): bool
    {
        return $user->id === $room->boardingHouse->admin_id;
    }

    /**
     * Determine if the user can create rooms.
     */
    public function create(User $user, BoardingHouse $boardingHouse): bool
    {
        return $user->isAdmin() && $user->id === $boardingHouse->admin_id;
    }

    /**
     * Determine if the user can update the room.
     */
    public function update(User $user, Room $room): bool
    {
        return $user->id === $room->boardingHouse->admin_id;
    }

    /**
     * Determine if the user can delete the room.
     */
    public function delete(User $user, Room $room): bool
    {
        return $user->id === $room->boardingHouse->admin_id;
    }
}