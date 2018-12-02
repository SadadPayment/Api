<?php

namespace App\Model\Response;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Response\Response
 *
 * @property int $id
 * @property int $transaction_id
 * @property string $responseCode
 * @property string $responseMessage
 * @property string $responseStatus
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\Transaction $transaction
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\Response whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\Response whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\Response whereResponseCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\Response whereResponseMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\Response whereResponseStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\Response whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\Response whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Response extends Model
{
    //
    public function transaction(){
        return $this->belongsTo('App\Model\Transaction');
    }
    public static function saveBasicResponse($transaction, $response){
        $basicResonse = new Response();
        $basicResonse->transaction()->associate($transaction);
        $basicResonse->responseCode = $response->responseCode;
        $basicResonse->responseMessage = $response->responseMessage;
        $basicResonse->responseStatus = $response->responseStatus;
        $basicResonse->save();
        return $basicResonse;
    }

}
