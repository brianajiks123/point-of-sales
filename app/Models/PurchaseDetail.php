<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    protected $fillable = [
        'purchase_id',
        'product_id',
        'purchase_price',
        'amount',
        'sub_total',
    ];

    // Relation
    public function product()
    {
        return $this->hasOne(Product::class, "id", "product_id");
    }
}
