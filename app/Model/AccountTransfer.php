<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\AccountTransfer
 *
 * @property int $id
 * @property int $transfer_id
 * @property string $toAccount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\Transfer $transfer
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AccountTransfer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AccountTransfer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AccountTransfer whereToAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AccountTransfer whereTransferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AccountTransfer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AccountTransfer extends Model
{
    //
    public function transfer(){
        return $this->belongsTo('App\Model\Transfer');
    }
}
