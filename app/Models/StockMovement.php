<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    protected $fillable = [
        'product_detail_id',
        'raw_material_id',
        'type',
        'quantity',
        'before_quantity',
        'after_quantity',
        'purchase_detail_id',
        'sale_detail_id',
        'admin_id',
    ];

    public function productDetail()
    {
        return $this->belongsTo(ProductDetail::class);
    }
}
