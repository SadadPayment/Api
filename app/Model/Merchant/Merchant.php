<?php

namespace App\Model\Merchant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Merchant\Merchant
 *
 * @property int $id
 * @property int $payee_id
 * @property string $merchant_name
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $type_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Merchant\MerchantServices[] $services
 * @property-read \App\Model\Merchant\MerchantType $types
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Merchant\MerchantUser[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Merchant\Merchant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Merchant\Merchant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Merchant\Merchant whereMerchantName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Merchant\Merchant wherePayeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Merchant\Merchant whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Merchant\Merchant whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Merchant\Merchant whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Merchant extends Model
{
//    public function users(){
//
//    }
      protected $fillable=["merchant_name","status"];
      public function services(){
          return $this->hasMany('App\Model\Merchant\MerchantServices');
      }
      public function types(){
          return $this->belongsTo('App\Model\Merchant\MerchantType','type_id');
      }
      public function users(){
          return $this->hasMany('App\Model\Merchant\MerchantUser');
      }
}
