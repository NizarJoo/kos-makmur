<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $casts = [
        'gallery_images' => 'array',
        'amenities' => 'array'
    ];

    protected $fillable = [
        'room_number',
        'capacity',
        'price_per_night',
        'status',
        'featured_image',
        'gallery_images',
        'description',
        'room_type',
        'amenities'
    ];

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
}