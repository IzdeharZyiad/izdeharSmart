<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    protected $fillable = [
        'Quantity',
        'lessQuantity',
        'size',
        'sale_price',
        'product_id',
    ];

    public function stock()
    {
        return $this->hasOne(Stock::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class);
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }
}
