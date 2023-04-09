<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class quotation extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function QuotationDetails()
    {
        return $this->hasMany(QuotationDetail::class, 'quotation_id', 'id');
    }
}
