<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\BillInquiry
 *
 * @property int $id
 * @property int $transaction_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\Merchant\Merchant $merchant
 * @property-read \App\Model\Transaction $transaction
 * @method static \Illuminate\Database\Eloquent\Builder|BillInquiry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillInquiry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillInquiry whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillInquiry whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BillInquiry extends Model
{
    //
    public function transaction(){
        return $this->belongsTo('App\Model\Transaction');
    }
    public function merchant(){
        return $this->belongsTo('App\Model\Merchant\Merchant');
    }
}
