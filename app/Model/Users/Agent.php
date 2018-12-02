<?php
namespace App\Model\Users;

use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;


/**
 * App\Model\Users\Agent
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $phone
 * @property string $password
 * @property string|null $email
 * @property string|null $work
 * @property string|null $state
 * @property string|null $city
 * @property string|null $local
 * @property string|null $address
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $status
 * @property int $user_group
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Users\Agent whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Users\Agent whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Users\Agent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Users\Agent whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Users\Agent whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Users\Agent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Users\Agent whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Users\Agent whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Users\Agent whereLocal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Users\Agent whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Users\Agent wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Users\Agent wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Users\Agent whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Users\Agent whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Users\Agent whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Users\Agent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Users\Agent whereUserGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Users\Agent whereWork($value)
 * @mixin \Eloquent
 */
class Agent extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $fillable =
        ['status',
            'first_name',
            'last_name',
            'phone',
            'email',
            'work',
            'state',
            'city',
            'local',
            'address',
            'latitude',
            'longitude'];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * User Group Type
     */

    public function userGroup()
    {
        $this->belongsTo('\App\Model\UserGroup');
    }

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
