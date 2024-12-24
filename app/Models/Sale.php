<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'member_id',
        'total_item',
        'total_price',
        'discount',
        'pay',
        'accepted',
        'user_id',
    ];
}
