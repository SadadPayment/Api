<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Transfer
 *
 * @property int $id
 * @property int $transaction_id
 * @property string $amount
 * @property int $type_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\Transaction $transaction
 * @property-read \App\Model\TransferType $type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Transfer whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Transfer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Transfer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Transfer whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Transfer whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Transfer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Transfer extends Model
{
    //
    public function transaction(){
        return $this->belongsTo('App\Model\Transaction');
    }
    public function type(){
        return $this->belongsTo('App\Model\TransferType' , 'type_id');
    }
}
