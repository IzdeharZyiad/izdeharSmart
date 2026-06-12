<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryCycle extends Model
{
    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
        'is_closed',
        'total_salary',
    ];
}
