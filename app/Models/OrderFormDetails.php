<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderFormDetails extends Model
{
    use HasFactory;
    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
