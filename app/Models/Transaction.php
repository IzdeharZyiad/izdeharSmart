<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'dateDay',
        'dayName',
        'purchase_id',
        'sale_id',
        'amount',
        'payment_methode',
        'type',
        'refrece_id',
        'admin_id',
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
