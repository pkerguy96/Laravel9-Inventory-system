<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryReceipt extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function customers()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function brands()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }
    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
