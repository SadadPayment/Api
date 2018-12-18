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
 * @property string $operatorMessage
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\Payment\Electricity $Electricity
 * @property-read \App\Model\Response\PaymentResponse $PaymentResponse
 * @method static \Illuminate\Database\Eloquent\Builder|ElectricityResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ElectricityResponse whereCustomerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ElectricityResponse whereElectricityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ElectricityResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ElectricityResponse whereMeterFees($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ElectricityResponse whereNetAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ElectricityResponse whereOpertorMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ElectricityResponse wherePaymentResponseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ElectricityResponse whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ElectricityResponse whereUnitsInKWh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ElectricityResponse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ElectricityResponse whereWaterFees($value)
 * @mixin \Eloquent
 */
class ElectricityResponse extends Model
{
    protected $fillable = ["meterFees" , "netAmount" , "unitsInKWh" , "waterFees" , "token" , "customerName" , "operatorMessage"];
    //
    public function PaymentResponse(){
        return $this->belongsTo('App\Model\Response\PaymentResponse' , 'payment_response_id');
    }
    public function Electricity(){
        return $this->belongsTo('App\Model\Payment\Electricity' , 'electricity_id');
    }
}
