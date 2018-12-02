<?php

namespace App\Model\Response;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Response\BalanceInquiryResponse
 *
 * @property int $id
 * @property int $balance_inquery_id
 * @property int $response_id
 * @property float $balance
 * @property float $acqTranFee
 * @property float $issuerTranFee
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\BalanceInquiry $balanceInquiry
 * @property-read \App\Model\Response\Response $response
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\BalanceInquiryResponse whereAcqTranFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\BalanceInquiryResponse whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\BalanceInquiryResponse whereBalanceInqueryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\BalanceInquiryResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\BalanceInquiryResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\BalanceInquiryResponse whereIssuerTranFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\BalanceInquiryResponse whereResponseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\BalanceInquiryResponse whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BalanceInquiryResponse extends Model
{
    //
    public function balanceInquiry(){
        return $this->belongsTo('App\Model\BalanceInquiry');
    }
    public function response(){
        return $this->belongsTo('App\Model\Response\Response');
    }
}
