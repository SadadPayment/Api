<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\PayTopUp
 *
 * @property int $id
 * @property string $phone
 * @property float $amount
 * @property int $top_up_id
 * @property int $payment_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\Payment\Payment $payment
 * @property-read \App\Model\TopUp $topUp
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PayTopUp whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PayTopUp whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PayTopUp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PayTopUp wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PayTopUp wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PayTopUp whereTopUpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PayTopUp whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PayTopUp extends Model
{
    //
    public function topUp(){
        return $this->belongsTo('App\Model\TopUp','top_up_id');
    }
    public function payment(){
        return $this->belongsTo('App\Model\Payment\Payment','payment_id');
    }
}
