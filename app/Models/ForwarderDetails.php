<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ForwarderDetails extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function car() : BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function trailer() : BelongsTo
    {
        return $this->belongsTo(Trailer::class);
    }

    public function driver() : BelongsTo
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
}
