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
    public function DeliveryDetails()
    {
        return $this->hasMany(delivery_details::class, 'delivery_id', 'id');
    }
}
