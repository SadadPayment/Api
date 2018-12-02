<?php

namespace App\Model\Response;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Response\TransferResponse
 *
 * @property int $id
 * @property int $transfer_id
 * @property int $response_id
 * @property float $balance
 * @property float $acqTranFee
 * @property float $issuerTranFee
 * @property float $tranAmount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\Response\Response $response
 * @property-read \App\Model\Transfer $trasfer
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\TransferResponse whereAcqTranFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\TransferResponse whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\TransferResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\TransferResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\TransferResponse whereIssuerTranFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\TransferResponse whereResponseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\TransferResponse whereTranAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\TransferResponse whereTransferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\TransferResponse whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TransferResponse extends Model
{
    public function trasfer(){
        return $this->belongsTo('App\Model\Transfer');
    }
    public function response(){
        return $this->belongsTo('App\Model\Response\Response');
    }
}
