<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'supplier_id',
        'total_item',
        'total_price',
        'discount',
        'pay',
    ];

    // Relation
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
