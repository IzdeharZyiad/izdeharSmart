<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleProductBatche extends Model
{
    protected $fillable = [
        'sale_id',
        'purchase_id',
        'quantity',
        'admin_id',
        'sale_detail_id',
        'price_purchase',
        'admin_id',
    ];
}
