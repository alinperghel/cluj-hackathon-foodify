<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'prompt',
        'title',
        'ingredients',
        'instructions',
    ];

    protected $casts = [
        'ingredients' => 'array',
    ];

    public function getIngredientsAttribute($value)
    {
        return json_decode($value);
    }

    public function setIngredientsAttribute($value)
    {
        $this->attributes['ingredients'] = json_encode($value);
    }
}
