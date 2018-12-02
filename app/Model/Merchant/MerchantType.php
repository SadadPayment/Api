<?php

namespace App\Model\Merchant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Merchant\MerchantType
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Merchant\Merchant[] $Merchants
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Merchant\MerchantType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Merchant\MerchantType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Merchant\MerchantType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Merchant\MerchantType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MerchantType extends Model
{
    //
    protected $table = 'merchant_types';

    public function Merchants(){
        return $this->hasMany('App\Model\Merchant\Merchant');
    }
}
