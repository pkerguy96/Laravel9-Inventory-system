<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notifications extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
