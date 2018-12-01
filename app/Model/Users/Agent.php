<?php

use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

//namespace App\Model\Users;

//use Illuminate\Database\Eloquent\Model;

class Agent extends Authenticatable implements JWTSubject
{
    protected $fillable =
        ['status',
            'first_name',
            'last_name',
            'phone',
            'password',
            'email',
            'work',
            'state',
            'city',
            'local',
            'address',
            'latitude',
            'longitude'];


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
