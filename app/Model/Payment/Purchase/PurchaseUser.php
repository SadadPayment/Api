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
protected $fillable =['PAN'];
    public function payment()
    {
        return $this->belongsTo('App\Model\Payment\Payment', 'payment_id');
    }

    public static function requestBuild($transaction_id, $PAN, $ipin, $expDate, $UserId)
    {
        $transaction = Transaction::find($transaction_id);
        $payment = Payment::where("transaction_id", $transaction_id)->first();
//        $e15 = PurchaseUser::where("payment_id", $payment->id)->first();

        $uuid = $transaction->uuid;
        $userName = "";
        $userPassword = "";
        $entityId = "";
        $entityType = "";
        $authenticationType = "00";
//        $bank = Functions::getBankAccountByUser($UserId);
//        $PAN = $bank->PAN;
//        $mbr = $bank->mbr;
//        $expDate = $bank->expDate;
        $tranCurrency = "SDG";
        $request = [
            "applicationId" => "Sadad",
            "tranDateTime" => $transaction->transDateTime,
            "UUID" => $uuid,
            "userName" => $userName,
            "entityId" => $entityId,
            "entityType" => $entityType,
            "tranCurrency" => $tranCurrency,
            "tranAmount" => $payment->amount,
            "serviceInfo" => "Description=xxxxx",
            "serviceProviderId" => '6600000000',
            "PAN" => $PAN,
            "mbr" => "0",
            "expDate" => $expDate,
            "IPIN" => $ipin,
            "userPassword" => $userPassword,
            "fromAccountType" => "00",
            "authenticationType" => $authenticationType,
        ];

        return $request;
    }

    /**
     * @param $transaction_id
     * @param $PAN
     * @param $ipin
     * @param $expDate
     * @param $UserId
     * @return bool|mixed
     */
    public static function sendRequest($transaction_id, $PAN, $ipin, $expDate, $UserId)
    {
        $request = self::requestBuild($transaction_id, $PAN, $ipin, $expDate, $UserId);
        $response = SendRequest::sendRequest($request, self::purchase);
        return $response;
    }

    public function PurchaseResponse()
    {
        $this->hasMany('App\Model\Payment\Purchase\PurchaseUserResponse');
    }
}