<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'guest_id',
        'room_id',
        'check_in_date',    // GUNAKAN check_in_date
        'check_out_date',   // GUNAKAN check_out_date  
        'total_amount',
        'status',
        'notes',
        'rejection_reason'
    ];

    protected $casts = [
        'check_in_date' => 'date',   // CAST check_in_date
        'check_out_date' => 'date',  // CAST check_out_date
    ];

    // Relationships
    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_ACTIVE = 'active';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    // Scope for pending bookings
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    // Check if booking can be approved
    public function canBeApproved()
    {
        return $this->status === self::STATUS_PENDING;
    }

    // Check if booking can be rejected
    public function canBeRejected()
    {
        return $this->status === self::STATUS_PENDING;
    }

    // Accessor untuk kompatibilitas (jika ada kode yang masih pakai check_in/check_out)
    public function getCheckInAttribute()
    {
        return $this->check_in_date;
    }

    public function getCheckOutAttribute()
    {
        return $this->check_out_date;
    }
}