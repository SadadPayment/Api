<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\UserVerification
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserVerification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserVerification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserVerification whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserVerification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserVerification whereUserId($value)
 * @mixin \Eloquent
 */
class UserVerification extends Model
{
    //
}
