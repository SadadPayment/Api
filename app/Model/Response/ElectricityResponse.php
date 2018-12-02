<?php

namespace App\Model\Response;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Response\ElectricityResponse
 *
 * @property int $id
 * @property int $electricity_id
 * @property int $payment_response_id
 * @property string $meterFees
 * @property string $netAmount
 * @property string $unitsInKWh
 * @property string $waterFees
 * @property string $token
 * @property string $customerName
 * @property string $opertorMessage
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\Payment\Electricity $Electriciy
 * @property-read \App\Model\Response\PaymentResponse $PaymentResponse
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\ElectricityResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\ElectricityResponse whereCustomerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\ElectricityResponse whereElectricityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\ElectricityResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\ElectricityResponse whereMeterFees($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\ElectricityResponse whereNetAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\ElectricityResponse whereOpertorMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\ElectricityResponse wherePaymentResponseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\ElectricityResponse whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\ElectricityResponse whereUnitsInKWh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\ElectricityResponse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\ElectricityResponse whereWaterFees($value)
 * @mixin \Eloquent
 */
class ElectricityResponse extends Model
{
    protected $fillable = ["meterFees" , "netAmount" , "unitsInKWh" , "waterFees" , "token" , "customerName" , "opertorMessage"];
    //
    public function PaymentResponse(){
        return $this->belongsTo('App\Model\Response\PaymentResponse' , 'payment_response_id');
    }
    public function Electriciy(){
        return $this->belongsTo('App\Model\Payment\Electricity' , 'electricity_id');
    }
}
