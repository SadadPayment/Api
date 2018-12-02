<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\ResetPassword
 *
 * @property int $id
 * @property string $phone
 * @property string $code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ResetPassword whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ResetPassword whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ResetPassword whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ResetPassword wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ResetPassword whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ResetPassword extends Model
{
    //
}
