<?php

namespace App\Model\Account;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Account\BankAccount
 *
 * @property int $id
 * @property string $PAN
 * @property string $IPIN
 * @property string $expDate
 * @property int $mbr
 * @property string|null $name
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\BankAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\BankAccount whereExpDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\BankAccount whereIPIN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\BankAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\BankAccount whereMbr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\BankAccount whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\BankAccount wherePAN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\BankAccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\BankAccount whereUserId($value)
 * @mixin \Eloquent
 */
class BankAccount extends Model
{
    protected $fillable = ['PAN', 'expDate', 'mbr', 'name'];
    protected $hidden = ['IPIN'];

    public function user()
    {
        return $this->belongsTo('App\Model\User', "user_id");
    }

    public static function getBankAccountByUser($user)
    {
        return BankAccount::where('user_id', $user->id)->first();
    }

    public static function saveBankAccountByUser($PAN, $expDate, $mbr, $user)
    {
        $bank = new BankAccount();
        $bank->PAN = $PAN;
        $bank->expDate = $expDate;
        $bank->mbr = $mbr;
        $bank->user()->associate($user);
        $bank->save();
    }
}
