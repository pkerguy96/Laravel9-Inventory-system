<?php

use App\Models\DeliveryReceipt;
use App\Models\Invoice;
use Illuminate\Support\Carbon;

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
if (!function_exists('generateInvoiceNumber')) {
    function generateInvoiceNumber()
    {
        $latestInvoice = Invoice::latest('id')->first();
        if ($latestInvoice) {
            $invoiceNumber = (int) substr($latestInvoice->invoice_no, -3);
            $invoiceNumber++;
            $invoiceNumber = str_pad($invoiceNumber, 3, "0", STR_PAD_LEFT);
        } else {
            $invoiceNumber = "001";
        }
        return Carbon::now()->format('y') . '/' . Carbon::now()->format('m') . Carbon::now()->format('d') . $invoiceNumber;
    }
}

if (!function_exists('generateDeliveryNumber')) {
    function generateDeliveryNumber()
    {
        $latestInvoice = DeliveryReceipt::latest('id')->first();
        if ($latestInvoice) {
            $invoiceNumber = (int) substr($latestInvoice->delivery_no, -3);
            $invoiceNumber++;
            $invoiceNumber = str_pad($invoiceNumber, 3, "0", STR_PAD_LEFT);
        } else {
            $invoiceNumber = "001";
        }
        return Carbon::now()->format('y') . '/' . Carbon::now()->format('m') . Carbon::now()->format('d') . 'BL' . $invoiceNumber;
    }
}
