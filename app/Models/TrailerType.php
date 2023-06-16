<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class TrailerType extends Model
{
    use HasFactory;

    use HasFactory, HasTranslations;

    protected $guarded = [];

    public $translatable = ['title'];
}
