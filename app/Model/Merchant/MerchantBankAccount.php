<?php

namespace App\Model\Merchant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Merchant\MerchantBankAccount
 *
 * @property int $id
 * @property int $branch_id
 * @property int $merchant_id
 * @property string $number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\Bank\BankBranch $BankBranch
 * @property-read \App\Model\Merchant\Merchant $Merchant
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Merchant\MerchantBankAccount whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Merchant\MerchantBankAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Merchant\MerchantBankAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Merchant\MerchantBankAccount whereMerchantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Merchant\MerchantBankAccount whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Merchant\MerchantBankAccount whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MerchantBankAccount extends Model
{
    //
    public function Merchant(){
        return $this->belongsTo('App\Model\Merchant\Merchant');
    }
    public function BankBranch(){
        return $this->belongsTo('App\Model\Bank\BankBranch');
    }
}
