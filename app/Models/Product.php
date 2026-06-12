<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'productImg',
        /*'Quantity',
        'lessQuantity',
        'productImg',
        'price',
        'avgPrice',*/
        'item_id',
        'admin_id',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function productDetail()
    {
        return $this->hasMany(productDetail::class);
    }
}
