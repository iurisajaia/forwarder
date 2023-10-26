<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Cargo extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    public function details(): HasOne
    {
        return $this->hasOne(CargoDetails::class);
    }

    public function route(): HasOne
    {
        return $this->hasOne(CargoRoute::class);
    }

    public function car_type(): belongsTo
    {
        return $this->belongsTo(CarType::class, 'car_type_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function contacts(): BelongsToMany{
        return $this->belongsToMany(UserContact::class, 'cargo_user_contact', );
    }

    public function deal(): HasOne{
        return $this->hasOne(Deal::class);
    }

}
