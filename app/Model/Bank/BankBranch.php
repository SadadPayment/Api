<?php

namespace App\Model\Bank;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Bank\BankBranch
 *
 * @property int $id
 * @property int $bank_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\Bank\Bank $bank
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Bank\BankBranch whereBankId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Bank\BankBranch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Bank\BankBranch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Bank\BankBranch whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Bank\BankBranch whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BankBranch extends Model
{
    //
    public function bank(){
        return $this->belongsTo('App\Model\Bank\Bank');
    }
}
