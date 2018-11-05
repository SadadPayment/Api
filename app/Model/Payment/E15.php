<?php

namespace App\Model\Payment;

use App\Model\Account\BankAccount;
use App\Model\SendRequest;
use App\Model\Transaction;
use App\Model\User;
use Illuminate\Database\Eloquent\Model;

class E15 extends Model
{
    protected $fillable =
        [
            'phone',
            'invoice_no',
            'payment_id',
        ];
    const Payment = "payment";
    protected $table = "e15s";

    //
    public function payment()
    {
        return $this->belongsTo('App\Model\Payment\Payment', 'payment_id');
    }

    public static function requestBuild($transaction_id, $ipin, $type)
    {
//        dd(['trans'=> $transaction_id, 'ipin'=>$ipin, 'type'=>$type ]);
        $transaction = Transaction::where("id", $transaction_id)->first();
        $user = User::where("id", $transaction->user_id)->first();
        $payment = Payment::where("transaction_id", $transaction_id)->first();
        $e15 = E15::where("payment_id", $payment->id)->first();
        dd(['e15 full object' => $e15, 'e15 id' => $e15->id]);
        $uuid = $transaction->uuid;
        //dd($uuid);
        $userName = "";
        $userPassword = "";
        $entityId = "";
        $entityType = "";
        $authenticationType = "00";

        $bank = BankAccount::where("user_id", $user->id)->first();
        $PAN = $bank->PAN;

        $mbr = $bank->mbr;
        $expDate = $bank->expDate;

        $tranCurrency = "SDG";
        dd($e15);
        $paymentInfo = "SERVICEID=" . $type . "/INVOICENUMBER=" . $e15->invoice_no . "/PHONENUMBER=" . $e15->phone;
//dd($payment);
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
            "paymentInfo" => $paymentInfo
        ];
        //dd($request);
        return $request;
    }

    public static function sendRequest($transaction_id, $ipin, $type)
    {
        $request = self::requestBuild($transaction_id, $ipin, $type);
        $response = SendRequest::sendRequest($request, self::Payment);
        return $response;
    }

}