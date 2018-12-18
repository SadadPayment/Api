<?php

namespace App\Model\Payment\Purchase;

use Illuminate\Database\Eloquent\Model;

class PurchaseUserResponse extends Model
{
    protected $table = 'purchase_users_responses';

    //

//    protected $fillable = ['issuerTranFee', 'fromAccount', 'payment_response_id', 'purchase_user_id'];

    public function PaymentResponse()
    {
        return $this->belongsTo('App\Model\Response\PaymentResponse', 'payment_response_id');
    }

    public function Purchase()
    {
        return $this->belongsTo('App\Model\Payment\Purchase\PurchaseUser');
    }
}
