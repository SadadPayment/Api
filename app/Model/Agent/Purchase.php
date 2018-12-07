<?php

namespace App\Model\Agent;

use App\Model\Payment\Payment;
use App\Model\Transaction;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable =
        ['clientId', 'terminalId', 'tranDateTime',
            'systemTraceAuditNumber', 'PAN', 'PIN', 'expDate',
            'tranCurrencyCode', 'tranAmount', 'otpId',
            'otp', 'additionalAmount', 'track2'];

    public function payment()
    {
        return $this->belongsTo('App\Model\Payment\Payment', 'payment_id');
    }

    public static function requestBuild($transaction_id, $ipin, $type, $bank_id)
    {
        $transaction = Transaction::find($transaction_id);
        $payment = Payment::where("transaction_id", $transaction_id)->first();
        $e15 = Purchase::where("payment_id", $payment->id)->first();
//

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
        if ($type == 6) {
            $response = SendRequest::sendRequest($request, self::Payment);
        } else {
            $response = SendRequest::sendRequest($request, self::inquiry);
        }
        return $response;
//        dd($response);
    }
}
