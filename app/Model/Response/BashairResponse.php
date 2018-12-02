<?php

namespace App\Model\Response;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Response\BashairResponse
 *
 * @property-read \App\Model\Response\PaymentResponse $PaymentResponse
 * @property-read \App\Model\Payment\Bashair $bashair
 * @mixin \Eloquent
 */
class BashairResponse extends Model
{
    protected $fillable =['CustomerName', 'BashaerCardStatus'];
    public function bashair()
    {
        return $this->belongsTo('App\Model\Payment\Bashair');
    }

    public function PaymentResponse()
    {
        return $this->belongsTo('App\Model\Response\PaymentResponse', 'payment_response_id');
    }

}
