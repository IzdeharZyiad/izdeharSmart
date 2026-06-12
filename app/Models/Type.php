<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = [
        'name',
        'admin_id',
    ];

    public function item()
    {
        $this->hasMany(Item::class);
    }
}
