<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'seller_id',
        'dateDay',
        'dayName',
        'totalPrice',
        'finalPrice',
        'status',
        'payment_type',
        'admin_id',
    ];

    public function installment()
    {
        return $this->morphOne(Installment::class, 'installmentable');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function details()
    {
        return $this->hasMany(PurchaseDetail::class);
    }

    public function cheques()
    {
        return $this->morphMany(Cheque::class, 'chequeable');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
