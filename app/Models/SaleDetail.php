<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    protected $fillable = [
        'sale_id',
        'product_detail_id',
        'quantity',
        'sale_price',
        'typeDisCount',
        'disCount',
        'subtotal',
        'profit',
        'purchase_cost',
    ];

    public function productDetail()
    {
        return $this->belongsTo(ProductDetail::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
