<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable,HasApiTokens;

    protected $fillable = [
        'mobile_no', 'password', 'otp', 'otp_expires_at'
    ];

    protected $hidden = [
        'password', 'otp'
    ];
    public function userProfile()
    {
        return $this->hasOne(UserProfile::class);
    }
}
