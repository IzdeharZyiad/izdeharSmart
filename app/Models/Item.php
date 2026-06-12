<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name',
        'type_id',
        'admin_id',
    ];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
