<?php

namespace App\Model\Payment;

use App\Functions;
use App\Model\Account\BankAccount;
use App\Model\SendRequest;
use App\Model\Transaction;
use App\Model\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Payment\E15
 *
 * @property int $id
 * @property string $phone
 * @property string $invoice_no
 * @property int $payment_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\Payment\Payment $payment
 * @method static \Illuminate\Database\Eloquent\Builder|E15 whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|E15 whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|E15 whereInvoiceNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|E15 wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|E15 wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|E15 whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
        $transaction = Transaction::find($transaction_id);
        $payment = Payment::where("transaction_id", $transaction_id)->first();
        $e15 = E15::where("payment_id", $payment->id)->first();

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
    }

}