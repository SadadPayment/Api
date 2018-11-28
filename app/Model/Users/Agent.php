<?php

namespace App\Model\Users;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
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
}
