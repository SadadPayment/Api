<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Transaction
 *
 * @property int $id
 * @property string $transDateTime
 * @property string $uuid
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $transaction_type
 * @property string $status
 * @property-read \App\Model\BalanceInquiry $balanceInquiry
 * @property-read \App\Model\Payment\Payment $payment
 * @property-read \App\Model\TopUp $topUp
 * @property-read \App\Model\TransactionType $transactionType
 * @property-read \App\Model\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Transaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Transaction whereTransDateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Transaction whereTransactionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Transaction whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Transaction whereUuid($value)
 * @mixin \Eloquent
 */
class Transaction extends Model
{
    protected $fillable =
        [
            'uuid',
            'user_id',
            'transDateTime',
            'transaction_type',
            'status'
        ];

    public function user()
    {
        return $this->belongsTo('App\Model\User', 'user_id');

    }

    public function transactionType()
    {
        return $this->belongsTo('App\Model\TransactionType', 'transaction_type');
    }

    public function payment()
    {
        return $this->hasOne('App\Model\Payment\Payment');
    }

    public function topUp()
    {
        return $this->hasOne('App\Model\TopUp');
    }

    public function balanceInquiry()
    {
        return $this->hasOne('App\Model\BalanceInquiry');
    }
}
