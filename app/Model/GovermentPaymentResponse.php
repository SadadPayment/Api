<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\GovermentPaymentResponse
 *
 * @property int $id
 * @property int $payment_response_id
 * @property string $invoiceExpiryDate
 * @property string $invoiceStatus
 * @property string $reciptNo
 * @property string $unitName
 * @property string $serviceName
 * @property int $totalAmountInt
 * @property string $totalAmountInWord
 * @property string $amountDue
 * @property string $availableBalance
 * @property string $legerBalance
 * @property string $tranFee
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|GovermentPaymentResponse whereAmountDue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GovermentPaymentResponse whereAvailableBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GovermentPaymentResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GovermentPaymentResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GovermentPaymentResponse whereInvoiceExpiryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GovermentPaymentResponse whereInvoiceStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GovermentPaymentResponse whereLegerBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GovermentPaymentResponse wherePaymentResponseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GovermentPaymentResponse whereReciptNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GovermentPaymentResponse whereServiceName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GovermentPaymentResponse whereTotalAmountInWord($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GovermentPaymentResponse whereTotalAmountInt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GovermentPaymentResponse whereTranFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GovermentPaymentResponse whereUnitName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GovermentPaymentResponse whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Model\Response\PaymentResponse $paymentResponse
 */
class GovermentPaymentResponse extends Model
{
    public function paymentResponse()
    {
        return $this->belongsTo('App\Model\Response\PaymentResponse', 'payment_response_id');
    }

    public static function saveGovermentResponse($paymentResponse, $response)
    {
        $govermentResponse = new GovermentPaymentResponse();
        $govermentResponse->paymentResponse()->associate($paymentResponse);
        $govermentResponse->invoiceExpiryDate = $response->invoiceExpiryDate;
        $govermentResponse->invoiceStatus = $response->invoiceStatus;
        $govermentResponse->reciptNo = $response->reciptNo;
        $govermentResponse->unitName = $response->unitName;
        $govermentResponse->serviceName = $response->serviceName;
        $govermentResponse->totalAmountInt = $response->totalAmountInt;
        $govermentResponse->totalAmountInWord = $response->totalAmountInWord;
        $govermentResponse->amountDue = $response->amountDue;
        $govermentResponse->availableBalance = $response->availableBalance;
        $govermentResponse->legerBalance = $response->legerBalance;
        $govermentResponse->tranFee = $response->tranFee;
        $govermentResponse->save();
        return $govermentResponse;
    }
}
