<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Filament\Models\Contracts\FilamentUser;

class User extends Authenticatable implements HasMedia, FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia ;



    public function canAccessFilament(): bool
    {
        return str_ends_with($this->email, '.com');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_role_id',
        'phone',
        'meta_info',
        'user_data_is_verified'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'user_data_is_verified' => 'boolean',
        'meta_info' => 'json'
    ];

    protected $appends = ['phone_is_verified'];

    public function getPhoneIsVerifiedAttribute()
    {
        return !is_null($this->phone_verified_at);
    }


    public function role(): BelongsTo
    {
        return $this->belongsTo(UserRole::class, 'user_role_id');
    }


    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'user_languages' );
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(CarType::class, 'car_type_id');
    }

    public function standard() : HasOne
    {
        return $this->hasOne(StandardUserDetails::class);
    }

    public function driver() : HasOne
    {
        return $this->hasOne(DriverUserDetails::class);
    }

    public function legal() : HasOne
    {
        return $this->hasOne(LegalUserDetails::class);
    }

    public function forwarder() : HasOne
    {
        return $this->hasOne(ForwarderDetails::class);
    }

    public function customer() : HasOne
    {
        return $this->hasOne(CustomerDetails::class);
    }






}
