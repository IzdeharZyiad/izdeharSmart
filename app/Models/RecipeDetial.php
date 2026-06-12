<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeDetial extends Model
{
    protected $fillable = [
        'recipe_id',
        'raw_material_id',
        'quantity',
    ];

    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterial::class);
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
