<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catagory extends Model
{
    use HasFactory;
    protected $fillable = ['catagory_name'];

    // Define the many-to-many relationship with products
    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product', 'catagory_id', 'product_id');
    }
}
