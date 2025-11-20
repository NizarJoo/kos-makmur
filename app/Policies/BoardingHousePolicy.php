<?php

namespace App\Policies;

use App\Models\BoardingHouse;
use App\Models\User;

class BoardingHousePolicy
{
    /**
     * Determine if the user can view any boarding houses.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can view the boarding house.
     */
    public function view(User $user, BoardingHouse $boardingHouse): bool
    {
        return $user->id === $boardingHouse->admin_id;
    }

    /**
     * Determine if the user can create boarding houses.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can update the boarding house.
     */
    public function update(User $user, BoardingHouse $boardingHouse): bool
    {
        return $user->id === $boardingHouse->admin_id;
    }

    /**
     * Determine if the user can delete the boarding house.
     */
    public function delete(User $user, BoardingHouse $boardingHouse): bool
    {
        return $user->id === $boardingHouse->admin_id;
    }

    /**
     * Determine if the user can restore the boarding house.
     */
    public function restore(User $user, BoardingHouse $boardingHouse): bool
    {
        return $user->id === $boardingHouse->admin_id;
    }

    /**
     * Determine if the user can permanently delete the boarding house.
     */
    public function forceDelete(User $user, BoardingHouse $boardingHouse): bool
    {
        return $user->id === $boardingHouse->admin_id;
    }
}