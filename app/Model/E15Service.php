<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\E15Service
 *
 * @property int $id
 * @property int $service_id
 * @property int $e15_id
 * @property int $ref_id
 * @property int $terminal_id
 * @property string $description
 * @property string $has_vat
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\Merchant\MerchantServices $service
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\E15Service whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\E15Service whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\E15Service whereE15Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\E15Service whereHasVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\E15Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\E15Service whereRefId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\E15Service whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\E15Service whereTerminalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\E15Service whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class E15Service extends Model
{
    //
    public function service(){
        return $this->belongsTo('App\Model\Merchant\MerchantServices');
    }
}
