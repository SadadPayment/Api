<?php

namespace App\Model\Merchant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Merchant\MerchantServices
 *
 * @property int $id
 * @property string $name
 * @property float $totalFees
 * @property float $sadadFess
 * @property float $standardFess
 * @property int $merchant_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $type_id
 * @property-read \App\Model\Merchant\Merchant $merchant
 * @property-read \App\Model\Merchant\MerchantType $type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Merchant\MerchantServices whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Merchant\MerchantServices whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Merchant\MerchantServices whereMerchantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Merchant\MerchantServices whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Merchant\MerchantServices whereSadadFess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Merchant\MerchantServices whereStandardFess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Merchant\MerchantServices whereTotalFees($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Merchant\MerchantServices whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Merchant\MerchantServices whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MerchantServices extends Model
{
    protected $fillable =array('*');
    public function merchant(){
        return $this->belongsTo('App\Model\Merchant\Merchant' , "merchant_id");
    }
    public function type(){
        return $this->belongsTo('App\Model\Merchant\MerchantType' , "type_id");
    }
}
