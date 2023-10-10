<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function ingredients()
    {
        return $this->belongsTo(Ingredient::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    use HasFactory;
}