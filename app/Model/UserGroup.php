<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\UserGroup
 *
 * @property int $id
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Users\Agent[] $agents
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserGroup whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class UserGroup extends Model
{
    //
    public function users(){
        return $this->hasMany('App\Model\User');
    }
    public function agents(){
        return $this->hasMany('App\Model\Users\Agent');
    }
}
