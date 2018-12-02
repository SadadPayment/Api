<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\TransactionType
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TransactionType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TransactionType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TransactionType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TransactionType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TransactionType extends Model
{
    protected $fillable = [
        'name'
    ];
    //
}
