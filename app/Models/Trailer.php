<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Trailer extends Model
{
    use HasFactory, HasTranslations;

    protected $guarded = [];

    public $translatable = ['title'];

    public function driver(): BelongsTo
    {
        return $this->belongsTo(DriverUserDetails::class, 'driver_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(TrailerType::class, 'trailer_type_id');
    }
}
