<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarrgoDetails extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function trailer_type(): belongsTo
    {
        return $this->belongsTo(TrailerType::class, 'trailer_type_id');
    }

}
