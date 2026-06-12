<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'dateDay',
        'dayName',
        'totalPrice',
        'totalProfit',

        'status',
        'payment_type',
        'custemer_id',
        'admin_id',
    ];

    public function details()
    {
        return $this->hasMany(SaleDetail::class);
    }

    public function installment()
    {
        return $this->morphOne(Installment::class, 'installmentable');
    }

    public function cheques()
    {
        return $this->morphMany(Cheque::class, 'chequeable');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function custemer()
    {
        return $this->belongsTo(Custemer::class);
    }
}
