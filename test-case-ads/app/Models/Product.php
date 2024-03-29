<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'slug', 'price'];

    public function catgory()
    {
        return $this->belongsTo(Category::class);
    }

    public function assets(){
        return $this->hasMany(ProductAsset::class);
    }
}
