<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const VERIFIED_USER = '1';
    const UNVERIFIED_USER = '0';
    const ADMIN_USER = 'true';
    const REGULAR_USER = 'false';

    protected $fillable = [
        'name', 'email', 'password', 'verified', 'verification_token', 'admin'
    ];

    protected $hidden = [
        'password', 'remember_token', 'verification_token'
    ];


    //----------------------------------- Internal Helper Methods ------------------------------------------------//
    public function isVerified()
    {
        return $this->verified = User::VERIFIED_USER;
    }

    public function isAdmin()
    {
        return $this->admin = User::ADMIN_USER;
    }

    public static function  generateVerificationCode()
    {
        return str_random(40);
    }
    //------------------------------------------------------------------------------------------------------------//
}
