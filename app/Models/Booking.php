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
        'user_id',
        'kamar_id',
        'kos_id',
        'start_date',
        'end_date',
        'duration_months',
        'total_price',
        'status',
        'notes',
        'rejection_reason',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'duration_months' => 'integer',
        'total_price' => 'decimal:2',
    ];

    /**
     * Status yang diperbolehkan sesuai SRS:
     * pending, approved, rejected, active, finished, cancelled
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
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Kamar
     */
    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }

    /**
     * Relasi ke Kos
     */
    public function kos()
    {
        return $this->belongsTo(Kos::class);
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
    public function canBeCancelled()
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check apakah booking bisa di-approve (untuk Admin)
     */
    public function canBeApproved()
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Get status badge color untuk UI
     */
    public function getStatusColorAttribute()
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
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }
}