<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get all kos in this district.
     */
    public function boardingHouses()  // ← Ubah dari 'kos()'
    {
        return $this->hasMany(BoardingHouse::class, 'district_id');
    }
}