<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\TopUpType
 *
 * @property-read \App\Model\Payment\Payment $payment
 * @mixin \Eloquent
 */
class TopUpType extends Model
{
    //
    public function payment(){
        return $this->belongsTo('App\Model\payment\payment');
    }
}
