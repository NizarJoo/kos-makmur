<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'address',
        'birth_date',
        'gender',
        'profile_picture',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
