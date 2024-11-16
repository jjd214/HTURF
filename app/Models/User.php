<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Consignment;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard = "user";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'email_verified_at',
        'verified',
        'password',
        'picture',
        'google_id'
    ];

    public function consignment()
    {
        return $this->hasMany(Consignment::class, 'consignor_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getPictureAttribute($value)
    {
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            // If the picture is a valid URL, return it directly
            return $value;
        }

        // Otherwise, return the local path or a default avatar
        return asset('/images/users/consignors/' . ($value ?: 'default-avatar.png'));
    }


    // public function getPictureAttribute($value)
    // {
    //     if ($value) {
    //         return asset('/images/users/consignors/' . $value);
    //     } else {
    //         return asset('/images/users/default-avatar.png');
    //     }
    // }
}
