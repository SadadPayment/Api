<?php

namespace App\Model\Response;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Response\E15Response
 *
 * @property int $id
 * @property int $e15_id
 * @property int $payment_response_id
 * @property string $invoice_no
 * @property string $UnitName
 * @property string $ServiceName
 * @property string $TotalAmount
 * @property string $ReferenceId
 * @property string $PayerName
 * @property string $expiry
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\Payment\E15 $E15
 * @property-read \App\Model\Response\PaymentResponse $PaymentResponse
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\E15Response whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\E15Response whereE15Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\E15Response whereExpiry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\E15Response whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\E15Response whereInvoiceNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\E15Response wherePayerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\E15Response wherePaymentResponseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\E15Response whereReferenceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\E15Response whereServiceName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\E15Response whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\E15Response whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\E15Response whereUnitName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\E15Response whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class E15Response extends Model
{
    protected $fillable
        = ['UnitName', 'ServiceName', 'TotalAmount', 'ReferenceId', 'PayerName', 'expiry', 'status'];

    public function E15()
    {
        return $this->belongsTo('App\Model\Payment\E15');
    }

    public function PaymentResponse()
    {
        return $this->belongsTo('App\Model\Response\PaymentResponse', 'payment_response_id');
    }

}
