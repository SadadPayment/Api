<?php

namespace App\Model\Payment;

use Illuminate\Database\Eloquent\Model;

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
}
