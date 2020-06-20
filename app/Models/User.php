<?php

namespace App\Models;

use App\Transformers\UserTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, SoftDeletes;
    protected $dates = ['deleted_at'];

    public $transformer = UserTransformer::class;

    const VERIFIED_USER = '1';
    const UNVERIFIED_USER = '0';
    const ADMIN_USER = 'true';
    const REGULAR_USER = 'false';

    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'password', 'verified', 'verification_token', 'admin'
    ];

    protected $hidden = [
        'password', 'remember_token', 'verification_token'
    ];


    //--------------------------------- Mutator & Accessors Methods ----------------------------------------------//
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtolower($name);
    }

    public function getNameAttribute($name)
    {
        return ucwords($name);
    }

    public function setEmailAttribute($email)
    {
        $this->attributes['email'] = strtolower($email);
    }
    //------------------------------------------------------------------------------------------------------------//


    //----------------------------------- Internal Helper Methods ------------------------------------------------//
    public function isVerified()
    {
        return $this->verified == User::VERIFIED_USER;
    }

    public function isAdmin()
    {
        return $this->admin == User::ADMIN_USER;
    }

    public static function  generateVerificationCode()
    {
        return str_random(40);
    }
    //------------------------------------------------------------------------------------------------------------//
}
