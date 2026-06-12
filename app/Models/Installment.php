<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    protected $fillable = [
        'purchase_id',
        'sale_id',
        'firstPay',
        'finalMount',
        'installmentsCount',
        'installmentAmount',
        'intervalDays',
        'dateDay',
        'status',
        'admin_id',
    ];

    public function installmentable()
    {
        return $this->morphTo();
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function installmentDetails()
    {
        return $this->hasMany(InstallmentDetail::class);
    }
}
