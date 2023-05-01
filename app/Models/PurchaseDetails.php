<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetails extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function suppliers()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }
    public function units()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }
    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function brands()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }
}
