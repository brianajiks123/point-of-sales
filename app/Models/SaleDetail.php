<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    protected $fillable = [
        'sale_id',
        'product_id',
        'sale_price',
        'amount',
        'discount',
        'sub_total',
    ];

    // Relation
    public function product()
    {
        return $this->hasOne(Product::class, "id", "product_id");
    }
}
