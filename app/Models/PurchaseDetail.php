<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    protected $fillable = [
        'purchase_id',
        'product_detail_id',
        'quantity',
        'price',
        'typeDisCount',
        'disCount',
        'raw_material_id',
        'type',
        'unit_cost_after_discount',
        'remaining_quantity',
        'subtotal',
    ];

    public function productDetail()
    {
        return $this->belongsTo(ProductDetail::class);
    }

    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterial::class);
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}
