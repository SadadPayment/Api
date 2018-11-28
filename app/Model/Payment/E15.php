<?php

namespace App\Model\Payment;

use App\Functions;
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
    const inquiry = "getBill";
    protected $table = "e15s";

    //
    public function payment()
    {
        return $this->belongsTo('App\Model\Payment\Payment', 'payment_id');
    }

    public static function requestBuild($transaction_id, $ipin, $type, $bank_id)
    {
//        dd(['trans'=> $transaction_id, 'ipin'=>$ipin, 'type'=>$type ]);
        $transaction = Transaction::find($transaction_id);
        $user = User::find($transaction->user_id);
        $payment = Payment::where("transaction_id", $transaction_id)->first();
        $e15 = E15::where("payment_id", $payment->id)->first();
//        $eror = ['tran' => $transaction->id,
//            'pay' => $payment->id,
//            'e15' => $e15];
//        dd($eror);

        $uuid = $transaction->uuid;
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
        $paymentInfo = "SERVICEID=" . $type . "/INVOICENUMBER=" . $e15->invoice_no . "/PHONENUMBER=" . $e15->phone;
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
        return $request;
    }

    public static function sendRequest($transaction_id, $ipin, $type, $bank_id)
    {
        $request = self::requestBuild($transaction_id, $ipin, $type, $bank_id);
        if($type== 6) {
            $response = SendRequest::sendRequest($request, self::Payment);
        }
        else{
            $response = SendRequest::sendRequest($request, self::inquiry);
        }
        return $response;
//        dd($response);
    }

}