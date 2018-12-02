<?php

namespace App\Model\Merchant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Merchant\MerchantUser
 *
 * @property int $id
 * @property int $user_id
 * @property int $merchant_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\Merchant\Merchant $merchant
 * @property-read \App\Model\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Merchant\MerchantUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Merchant\MerchantUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Merchant\MerchantUser whereMerchantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Merchant\MerchantUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Merchant\MerchantUser whereUserId($value)
 * @mixin \Eloquent
 */
class MerchantUser extends Model
{
    //
    public function merchant(){
        return $this->belongsTo('App\Model\Merchant\Merchant');
    }
    public function user(){
        return $this->belongsTo('App\Model\User');
    }
}
