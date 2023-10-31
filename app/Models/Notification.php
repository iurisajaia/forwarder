<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function deal(): BelongsTo{
        return $this->belongsTo(Deal::class);
    }

    public function offer(): BelongsTo{
        return $this->belongsTo(Offer::class);
    }

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
}
