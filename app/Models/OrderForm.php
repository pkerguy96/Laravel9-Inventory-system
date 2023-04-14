<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderForm extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function OrderFormDetails()
    {
        return $this->hasMany(OrderFormDetails::class, 'orderform_id', 'id');
    }
}
