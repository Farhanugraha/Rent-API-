<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RenterProfile extends Model
{

    protected $fillable = [
        'id', 'renter_id', 'full_name', 'nik', 'license_no', 'verification_status',
    ];


    public function renter(): BelongsTo
    {
        return $this->belongsTo(RenterAccount::class, 'renter_id');
    }
}
