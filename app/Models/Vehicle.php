<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    protected $fillable = [
        'id', 'owner_id', 'brand', 'model', 'daily_rate',
        'latitude', 'longitude', 'status',
    ];

    protected $casts = [
        'daily_rate' => 'decimal:2',
        'latitude'   => 'decimal:7',
        'longitude'  => 'decimal:7',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(OwnerAccount::class, 'owner_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'vehicle_id');
    }
}
