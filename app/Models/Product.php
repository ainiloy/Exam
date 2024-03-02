<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_name',
        'slug',
        'category_id',
        'price',
        'image',
   ];


public function category()
{
    return $this->belongsTo(Category::class);
}

}
