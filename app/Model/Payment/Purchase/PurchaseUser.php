<?php

namespace App\Model\Payment\Purchase;

use App\Model\Payment\Payment;
use App\Model\SendRequest;
use App\Model\Transaction;
use Illuminate\Database\Eloquent\Model;

class PurchaseUser extends Model
{

    const purchase = 'specialPayment';

    public function payment()
    {
        return $this->belongsTo('App\Model\Payment\Payment', 'payment_id');
    }

    public static function requestBuild($transaction_id, $PAN, $pin, $expDate, $agentId)
    {
        $transaction = Transaction::find($transaction_id);
        $payment = Payment::where("transaction_id", $transaction_id)->first();
        $uuid = $transaction->uuid;
//        dd($transaction);
        $request = [
            "applicationId" => "SADAD",
            "tranDateTime" => $transaction->transDateTime,
            "UUID" => $uuid,
            'userName' => '',
            'userPassword' => '',
            'entityId' => $agentId,
            'entityType' => '',
            'tranCurrency' => "SDG",
            'tranAmount' => $payment->amount,
            'serviceInfo' => "",
            'serviceProviderId' => '6600000000',
            "PAN" => $PAN,
            "mbr" => '0',
            'expDate' => $expDate,
            'PIN' => $pin,
            'fromAccountType' => '',
            'authenticationType' => ''

        ];
        return $request;
//        dd($request);
    }

    public static function sendRequest($transaction_id, $PAN, $pin, $expDate, $userID)
    {
        $request = self::requestBuild($transaction_id, $PAN, $pin, $expDate, $userID);
        $response = SendRequest::sendRequest($request, self::purchase);
        dd([$request, $response]);
//        return $response;
    }
}