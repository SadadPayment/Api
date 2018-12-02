<?php

namespace App\Model\Response;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Response\BillInquiryResponse
 *
 * @property int $id
 * @property int $bill_inquiry_id
 * @property int $response_id
 * @property string $billInfo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\BillInquiry $billInquiry
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\BillInquiryResponse whereBillInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\BillInquiryResponse whereBillInquiryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\BillInquiryResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\BillInquiryResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\BillInquiryResponse whereResponseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Response\BillInquiryResponse whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BillInquiryResponse extends Model
{
    //
    public function billInquiry(){
        return $this->belongsTo('App\Model\BillInquiry');
    }
}
