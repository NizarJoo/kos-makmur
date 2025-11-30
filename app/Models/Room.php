<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'boarding_house_id',
        'type_name',
        'size',
        'price_per_month',
        'availability',
        'available_units',
        'description',
        'image_path',
    ];

    protected $casts = [
        'price_per_month' => 'decimal:2',
        'availability' => 'integer',
        'available_units' => 'integer',
    ];

    /**
     * Get the boarding house that owns the room.
     */
    public function boardingHouse()
    {
        return $this->belongsTo(BoardingHouse::class);
    }

    /**
     * Get all bookings for this room.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get all facilities for this room.
     * Many-to-Many relationship
     */
    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'room_facilities', 'room_id', 'facility_id');
    }

    /**
     * Check if room has available units
     */
    public function hasAvailableUnits(): bool
    {
        return $this->available_units > 0;
    }

    /**
     * Decrease available units when booked
     */
    public function decreaseAvailableUnits(int $units = 1): void
    {
        $this->decrement('available_units', $units);
    }

    /**
     * Increase available units when booking cancelled
     */
    public function increaseAvailableUnits(int $units = 1): void
    {
        $this->increment('available_units', $units);
    }
}