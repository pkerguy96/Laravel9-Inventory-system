<?php
if (!function_exists('calculateTax')) {
    function calculatetax($subtotal)
    {
        $sum = doubleval(0.2 * $subtotal);
        return $sum;
    }
}
if (!function_exists('CalculateGrandAmount')) {
    function CalculateGrandAmount($grandamount, $taxamount)
    {
        $total =  doubleval($grandamount + $taxamount);
        return $total;
    }
}
