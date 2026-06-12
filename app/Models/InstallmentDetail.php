<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstallmentDetail extends Model
{
    protected $fillable = [
        'installment_id',
        'amount',
        'due_date',
        'status',
    ];

    public function installment()
    {
        return $this->belongsTo(Installment::class);
    }
}
