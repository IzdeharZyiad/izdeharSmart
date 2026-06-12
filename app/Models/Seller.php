<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    protected $fillable = [
        'name',
        'phoneNumber',
        'idNumber',
        'balance',
        'admin_id',
    ];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
