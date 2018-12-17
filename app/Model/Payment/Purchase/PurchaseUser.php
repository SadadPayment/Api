<?php

namespace App\Model\Payment\Purchase;

use App\Functions;
use App\Model\Payment\Payment;
use App\Model\SendRequest;
use App\Model\Transaction;
use Illuminate\Database\Eloquent\Model;

class PurchaseUser extends Model
{

    const purchase = 'specialPayment';
    protected $table = 'purchase_users';

    public function payment()
    {
        return $this->belongsTo('App\Model\Payment\Payment', 'payment_id');
    }

    public static function requestBuild($transaction_id, $PAN, $ipin, $expDate, $UserId)
    {
        $transaction = Transaction::find($transaction_id);
        $payment = Payment::where("transaction_id", $transaction_id)->first();
        $e15 = E15::where("payment_id", $payment->id)->first();

        $uuid = $transaction->uuid;
        $userName = "";
        $userPassword = "";
        $entityId = "";
        $entityType = "";
        $authenticationType = "00";
        $bank = Functions::getBankAccountByUser($UserId);
        $PAN = $bank->PAN;
        $mbr = $bank->mbr;
        $expDate = $bank->expDate;
        $tranCurrency = "SDG";
        $request = [
            "applicationId" => "Sadad",
            "tranDateTime" => $transaction->transDateTime,
            "UUID" => $uuid,
            "userName" => $userName,
            "PAN" => $PAN,
            "mbr" => $mbr,
            "entityType" => $entityType,
            "expDate" => $expDate,
            "entityId" => $entityId,
            "userPassword" => $userPassword,
            "tranCurrency" => $tranCurrency,
            "tranAmount" => $payment->amount,
            "fromAccountType" => "00",
            "IPIN" => $ipin,
            "authenticationType" => $authenticationType,
            "payeeId" => "0010050001",
        ];

        return $request;
    }

    public static function sendRequest($transaction_id, $PAN, $ipin, $expDate, $UserId)
    {
        $request = self::requestBuild($transaction_id, $PAN, $ipin, $expDate, $UserId);
        $response = SendRequest::sendRequest($request, self::purchase);
        return $response;
        dd([$request, $response]);
    }
}