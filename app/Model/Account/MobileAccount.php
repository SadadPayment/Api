<?php

namespace App\Model\Account;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Account\MobileAccount
 *
 * @property int $id
 * @property int $user_id
 * @property string $mobileNumber
 * @property string $IPIN
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\MobileAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\MobileAccount whereIPIN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\MobileAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\MobileAccount whereMobileNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\MobileAccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\MobileAccount whereUserId($value)
 * @mixin \Eloquent
 */
class MobileAccount extends Model
{
    //
    public function user(){
        return $this->belongsTo('App\Model\User',"user_id");
    }
    public function getMobileAccountByUser($user){
        return $this::where('user_id', $user->id)->first();
    }

}
