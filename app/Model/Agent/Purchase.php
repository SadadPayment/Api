<?php

namespace App\Model\Agent;

use App\Functions;
use App\Model\Payment\Payment;
use App\Model\SendRequest;
use App\Model\Transaction;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Agent\Purchase
 *
 * @property-read \App\Model\Payment\Payment $payment
 * @mixin \Eloquent
 */
class Purchase extends Model
{
    const purchase = 'purchase';
    protected $fillable =
        [
            'clientId', 'terminalId', 'tranDateTime',
            'systemTraceAuditNumber', 'PAN', 'PIN', 'expDate',
            'tranCurrencyCode', 'tranAmount', 'otpId',
            'otp', 'additionalAmount', 'track2'];

    public function payment()
    {
        return $this->belongsTo('App\Model\Payment\Payment', 'payment_id');
    }

    public static function requestBuild($transaction_id, $PAN, $pin, $expDate, $agentId)
    {
        $transaction = Transaction::find($transaction_id);
        $payment = Payment::where("transaction_id", $transaction_id)->first();
        $uuid = $transaction->uuid;

        $request = [
            "applicationId" => "Sadad",
            "tranDateTime" => $transaction->transDateTime,
            "UUID" => $uuid,
            'clientId' => $agentId,
            'terminalId' => '12545454',
            'systemTraceAuditNumber' => $transaction->id,
            "PAN" => $PAN,
            'PIN' => $pin,
            'expDate' => $expDate,
            'tranCurrencyCode' => "SDG",
            'tranAmount' => $payment->amount,
            'otpId' => "",
            'otp' => "",
            'additionalAmount' => "",
            'track2' => ""
        ];
        return $request;
    }

    public static function sendRequest($transaction_id, $PAN, $pin, $expDate, $agentId)
    {
        $request = self::requestBuild($transaction_id, $PAN, $pin, $expDate, $agentId);
        $response = SendRequest::sendRequest($request, self::purchase);
        dd($response);
//        return $response;
    }
}
