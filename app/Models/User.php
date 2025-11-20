<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_staff', // Keep untuk backward compatibility
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_staff' => 'boolean',
    ];

    /**
     * Relationships
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'guest_id');
    }

    // public function profile()
    // {
    //     return $this->hasOne(UserProfile::class);
    // }

    public function boardingHouses()
    {
        return $this->hasMany(BoardingHouse::class, 'admin_id');
    }

    /**
     * Role Checker Methods
     */
    public function isSuperadmin(): bool
    {
        return $this->role === 'superadmin';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Check if user is staff (admin or superadmin)
     * Untuk backward compatibility dengan is_staff
     */
    public function isStaff(): bool
    {
        return in_array($this->role, ['admin', 'superadmin']);
    }

    /**
     * Accessor untuk is_staff (backward compatibility)
     */
    public function getIsStaffAttribute(): bool
    {
        return $this->isStaff();
    }
}