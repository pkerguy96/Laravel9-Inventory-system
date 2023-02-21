<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    /* making table champs fillable  */
    protected $guarded = [];
    public function payements()
    {
        return $this->belongsTo(Payement::class, 'id', 'invoice_id');
    }
    public function clients()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    public function InvoiceDetails()
    {
        return $this->hasMany(InvoiceDetail::class, 'invoice_id', 'id');
    }
}
