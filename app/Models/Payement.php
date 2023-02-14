<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payement extends Model
{
    use HasFactory;
    /* making table champs fillable  */
    protected $guarded = [];
    public function customers()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    public function Invoices()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }
}
