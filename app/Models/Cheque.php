<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cheque extends Model
{
    protected $fillable = [
        'cheque_number',
        'bank_name',
        'amount',
        'due_date',
        'status',
        'chequeImg',
        'admin_id',
    ];

    public function chequeable()
    {
        return $this->morphTo();
    }
}
