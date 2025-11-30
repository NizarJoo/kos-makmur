<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';

    protected $fillable = [
        'booking_code',
        'guest_id',
        'room_id',
        'boarding_house_id',
        'check_in_date',
        'check_out_date',
        'duration_months',
        'total_amount', // Changed from total_price
        'status',
        'notes',
        'rejection_reason',
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'duration_months' => 'integer',
        'total_amount' => 'decimal:2', // Changed from total_price
    ];

    /**
     * Status constants
     */
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_ACTIVE = 'active';
    const STATUS_FINISHED = 'finished';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * Relasi ke User (pencari/penghuni kos)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'guest_id');
    }

    /**
     * Relasi ke Room
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Relasi ke BoardingHouse
     */
    public function boardingHouse()
    {
        return $this->belongsTo(BoardingHouse::class);
    }

    /**
     * Scope untuk filter booking berdasarkan status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk booking yang sedang pending
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope untuk booking yang sedang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Check apakah booking bisa di-cancel
     */
    public function canBeCancelled(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check apakah booking bisa di-approve (untuk Admin)
     */
    public function canBeApproved(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Get status badge color untuk UI
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'active' => 'green',
            'pending' => 'yellow',
            'approved' => 'blue',
            'finished' => 'gray',
            'rejected' => 'red',
            'cancelled' => 'red',
            default => 'gray',
        };
    }

    /**
     * Format harga untuk display
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }
}