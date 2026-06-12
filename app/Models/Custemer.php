<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Custemer extends Model
{
    protected $fillable = [
        'name',
        'phoneNumber',
        'idNumber',
        'balance',
        'admin_id',
    ];

    public function sale()
    {
        return $this->hasMany(Sale::class);
    }
}
