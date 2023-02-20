<?php
if (!function_exists('calculateTax')) {
    function calculateTax($subtotal)
    {
        $subtotal = floatval($subtotal);
        $tax_rate = 0.2; // 20%
        $tax_amount = round($subtotal * $tax_rate, 2); // round to two decimal places
        return number_format((float)$tax_amount, 2, '.', ''); // format as a decimal with two decimal places
    }
}
if (!function_exists('CalculateGrandAmount')) {
    function CalculateGrandAmount($grandamount, $taxamount)
    {
        $total = round(doubleval($grandamount) + doubleval($taxamount), 2);
        return $total;
    }
}
