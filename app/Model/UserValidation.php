<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\UserValidation
 *
 * @property int $id
 * @property string $phone
 * @property string $code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserValidation whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserValidation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserValidation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserValidation wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserValidation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class UserValidation extends Model
{
    //
}
