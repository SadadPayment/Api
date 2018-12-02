<?php

namespace App\Model\Payment;

use App\Model\SendRequest;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Payment\Bashair
 *
 * @property-read \App\Model\Payment\Payment $payment
 * @mixin \Eloquent
 */
class Bashair extends Model
{
    protected $fillable=['ReferenceType', 'ReferenceValue'];
    const Payment = "payment";
    public function payment()
    {
        return $this->belongsTo('App\Model\Payment\Payment', 'payment_id');
    }

    public static function requestBuild($transaction ,$ipin)
    {
        $user = User::where("id", $transaction->user_id)->first();
        $payment = Payment::where("transaction_id", $transaction->id)->first();
        $Bashair = Bashair::where("payment_id", $payment->id)->first();
        $bank = BankAccount::where("user_id", $user->id)->first();
        $PAN = $bank->PAN;
        $mbr = $bank->mbr;
        $expDate = $bank->expDate;
        $tranCurrency = "SDG";
        $uuid = $transaction->uuid;
        //dd($uuid);
        $userName = "";
        $userPassword = "";
        $entityId = "";
        $entityType = "";
        $authenticationType = "00";
        $paymentInfo = "REFTYPE=" . $Bashair->ReferenceType . "/REFVALUE=" . $Bashair->ReferenceValue;

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
            "payeeId" => "0010060002",
            "paymentInfo" => $paymentInfo
        ];
        return $request;
    }
    public static function sendRequest($transaction, $ipin)
    {
        $request = self::requestBuild($transaction, $ipin);
        $response = SendRequest::sendRequest($request, self::Payment);
        return $response;
    }
}
