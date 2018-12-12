<?php

namespace App\Model\Response;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Response\TopUpResponse
 *
 * @property int $id
 * @property int $top_up_id
 * @property int $payment_response_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\Response\PaymentResponse $PaymentResponse
 * @property-read \App\Model\Payment\TopUp\TopUp $TopUp
 * @method static \Illuminate\Database\Eloquent\Builder|TopUpResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TopUpResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TopUpResponse wherePaymentResponseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TopUpResponse whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TopUpResponse whereTopUpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TopUpResponse whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TopUpResponse extends Model
{
    //
    protected $fillable = ["status"];
    public function PaymentResponse(){
        return $this->belongsTo('App\Model\Response\PaymentResponse' , 'payment_response_id');
    }
    public function TopUp(){
        return $this->belongsTo('App\Model\Payment\TopUp\TopUp' , 'top_up_id');
    }
}
