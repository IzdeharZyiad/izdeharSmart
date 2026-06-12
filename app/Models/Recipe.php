<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = [
        'name',
        'product_detail_id',
        'total_cost',
        'admin_id',
    ];

    public function details()
    {
        return $this->hasMany(RecipeDetial::class);
    }
}
