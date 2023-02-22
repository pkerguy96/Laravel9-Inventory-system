<?php

namespace App\Http\Controllers\sop;

use App\Models\DeliveryReceipt;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function Alldelivery()
    {
        $deliverys = DeliveryReceipt::all();
        return view('backend.delivery.all_deliverys', compact(('deliverys')));
    }
}
