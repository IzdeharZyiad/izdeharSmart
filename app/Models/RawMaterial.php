<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RawMaterial extends Model
{
    protected $fillable = [
        'name',
        'quantity',
        'unit',
        'pruches_unit',
        'lessQuantity',
        'admin_id',
    ];

    public function recipeDetails()
    {
        return $this->hasMany(RecipeDetial::class);
    }
}
