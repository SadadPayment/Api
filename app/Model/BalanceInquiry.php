<?php

namespace App\Model;

use App\Functions;
use App\Model\Account\BankAccount;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\BalanceInquiry
 *
 * @property int $id
 * @property int $transaction_id
 * @property int $account_type_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\Account\AccountType $account_type
 * @property-read \App\Model\Transaction $transaction
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceInquiry whereAccountTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceInquiry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceInquiry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceInquiry whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceInquiry whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BalanceInquiry extends Model
{
    //
    const Balance = "getBalance";

    public function transaction()
    {
        return $this->belongsTo('App\Model\Transaction', "transaction_id");
    }

    public function account_type()
    {
        return $this->belongsTo('App\Model\Account\AccountType', "account_type_id");
    }

    public static function requestBuild($transaction_id, $ipin, $bank_id)
    {
        $request = array();
        $transaction = Transaction::where("id", $transaction_id)->first();
//        $user = User::where("id", $transaction->user_id)->first();
        $balance_inquiry = BalanceInquiry::where("transaction_id", $transaction_id)->first();
        $uuid = $transaction->uuid;
        $request += ["applicationId" => "Sadad"];
        $request += ["tranDateTime" => $transaction->transDateTime, "UUID" => $uuid];
        $account_type = $balance_inquiry->account_type->name;
        $userName = "";
        $userPassword = "";
        $entityId = "";
        $entityType = "";
        $authenticationType = "00";
        $bank = Functions::getBankAccountByUser($bank_id);
        $PAN = $bank->PAN;

        $mbr = $bank->mbr;
        $expDate = $bank->expDate;
        $tranCurrency = "SDG";
        $request += ["userName" => $userName,
            "userPassword" => $userPassword,
            "entityId" => $entityId,
            "entityType" => $entityType,
            "PAN" => $PAN,
            "mbr" => $mbr,
            "expDate" => $expDate,
            "IPIN" => $ipin,
            'accountType' => $account_type,
            "authenticationType" => $authenticationType,
            "fromAccountType" => "00",
            "tranCurrency" => $tranCurrency];

        return $request;
    }

    public static function sendRequest($transaction_id, $ipin, $bank_id)
    {
        $request = self::requestBuild($transaction_id, $ipin, $bank_id);

        $response = SendRequest::sendRequest($request, self::Balance);
        return $response;

    }

}
