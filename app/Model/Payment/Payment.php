<?php

namespace App\Model\Payment;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Payment\Payment
 *
 * @property int $id
 * @property int $transaction_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $amount
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Payment\E15[] $e15
 * @property-read \App\Model\Transaction $transaction
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Payment extends Model
{
    protected $fillable = ['transaction_id',
        'amount'];

    public function transaction()
    {
        return $this->belongsTo('App\Model\Transaction', 'transaction_id');
    }

    public function e15()
    {
        return $this->hasMany('App\Model\Payment\E15');
    }

    public function purchase()
    {
//        return $this->hasMany('App\Model\Agent\Purchase');
        return $this->hasMany('App\Model\Payment\Purchase\PurchaseUser');
    }

    public function purchase_user()
    {
        return $this->hasMany('App\Model\Payment\Purchase\PurchaseUser');
    }
}
