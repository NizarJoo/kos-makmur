<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoardingHouse extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'boarding_houses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'admin_id',
        'name',
        'address',
        'district_id',
        'description',
        'image_path',
        'type',
        'is_verified',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_verified' => 'boolean',
    ];

    /**
     * Get the admin that owns the boarding house.
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Get the district of the boarding house.
     */
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    /**
     * Get all rooms in this boarding house.
     */
    public function rooms()
    {
        return $this->hasMany(Room::class, 'boarding_house_id');
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    /**
     * Get the type label.
     */
    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'male' => 'Male Only',
            'female' => 'Female Only',
            'mixed' => 'Mixed',
            default => $this->type,
        };
    }

    /**
     * Get the verification status badge.
     */
    public function getVerificationBadgeAttribute(): string
    {
        return $this->is_verified
            ? '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Verified</span>'
            : '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">Pending Verification</span>';
    }

    /**
     * Scope to only show verified boarding houses.
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }
    public function scopePendingVerification($query)
    {
        return $query->where('is_verified', false);
    }

    /**
     * Scope to only show boarding houses owned by specific admin.
     */
    public function scopeOwnedBy($query, $adminId)
    {
        return $query->where('admin_id', $adminId);
    }
}