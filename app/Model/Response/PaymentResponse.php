<?php

namespace App\Model\Response;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Response\PaymentResponse
 *
 * @property int $id
 * @property int $response_id
 * @property int $payment_id
 * @property string $balance
 * @property string $acqTranFee
 * @property string $issuerTranFee
 * @property string $billInfo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\Payment\Payment $payment
 * @property-read \App\Model\Response\Response $response
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\PaymentResponse whereAcqTranFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\PaymentResponse whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\PaymentResponse whereBillInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\PaymentResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\PaymentResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\PaymentResponse whereIssuerTranFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\PaymentResponse wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\PaymentResponse whereResponseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\PaymentResponse whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PaymentResponse extends Model
{
    //
    public function payment()
    {
        return $this->belongsTo('App\Model\Payment\Payment', 'payment_id');
    }

    public function response()
    {
        return $this->belongsTo('App\Model\Response\Response', 'response_id');
    }

    public static function savePaymentResponse($basicResonse, $payment, $response)
    {
        $paymentResponse = new PaymentResponse();
        $paymentResponse->response()->associate($basicResonse);
        $paymentResponse->payment()->associate($payment);
        //dd($response);
        $paymentResponse->balance = $response->balance->available;
        $paymentResponse->acqTranFee = $response->acqTranFee;
        $paymentResponse->issuerTranFee = $response->issuerTranFee;
        $paymentResponse->billInfo = ""; /* $response->billInfo != "" ? $response->billInfo :  */
        //$paymentResponse->balance = 0.0;
        $paymentResponse->save();
        return $paymentResponse;
    }
}
