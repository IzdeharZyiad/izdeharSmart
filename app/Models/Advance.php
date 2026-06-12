<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advance extends Model
{
    protected $fillable = [
        'date',
        'dayName',
        'mount',
        'user_id',
        'salary_cycle_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
