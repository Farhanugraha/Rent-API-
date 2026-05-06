<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OwnerProfile extends Model
{

    protected $fillable = [
        'id', 'owner_id', 'full_name', 'nik', 'ktp_image_url', 'verification_status',
    ];


    public function owner(): BelongsTo
    {
        return $this->belongsTo(OwnerAccount::class, 'owner_id');
    }
}
