<?php

use App\Models\Supplier;

if (!function_exists('verifySupplierIce')) {

    function verifySupplierIce($ice)
    {
        if (Supplier::where('ice', $ice)->exists()) {

            return true;
        }
    }
}
