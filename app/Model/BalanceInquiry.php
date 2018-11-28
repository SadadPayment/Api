<?php

namespace App\Model;

use App\Model\Account\BankAccount;
use Illuminate\Database\Eloquent\Model;

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

    public static function requestBuild($transaction_id, $ipin)
    {
        $request = array();
        $transaction = Transaction::where("id", $transaction_id)->first();
        $user = User::where("id", $transaction->user_id)->first();
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
        $bank = BankAccount::getBankAccountByUser($user);
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
            'accountType'=>$account_type,
            "authenticationType" => $authenticationType,
            "fromAccountType" => "00",
            "tranCurrency" => $tranCurrency];

        return $request;
    }

    public static function sendRequest($transaction_id, $ipin)
    {
        $request = self::requestBuild($transaction_id, $ipin);

        $response = SendRequest::sendRequest($request, self::Balance);
        return $response;

    }

}
