<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Sanctum\HasApiTokens;

class RenterAccount extends Model
{
    use HasApiTokens; 

    protected $fillable = [
        'id',
        'email',
        'password_hash',
        'is_active',
    ];

    protected $hidden = [
        'password_hash',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function profile(): HasOne
    {
        return $this->hasOne(RenterProfile::class, 'renter_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'renter_id');
    }
}
