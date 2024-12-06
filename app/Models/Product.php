<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'price', 'image'];

    // Define the many-to-many relationship with categories
    public function categories()
    {
        return $this->belongsToMany(Catagory::class, 'category_product', 'product_id', 'catagory_id');
    }

}
