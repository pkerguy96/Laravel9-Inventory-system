<?php

use App\Models\DeliveryReceipt;
use App\Models\Invoice;
use App\Models\OrderForm;
use App\Models\quotation;
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
if (!function_exists('CalculateGrandTotal')) {
    function CalculateGrandTotal($subtotal, $discount = 0, $tax = 0)
    {
        $items_count = count($subtotal);
        $grand_amount = 0;
        for ($i = 0; $i < $items_count; $i++) {
            $grand_amount += $subtotal[$i];
        }
        $grand_total =  $grand_amount - $discount;
        $tax_amount = $grand_total * ($tax / 100);
        $total_amount = $grand_total + $tax_amount;
        return array(
            'grand_total' => $total_amount,
            'tax_amount' => $tax_amount
        );
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
if (!function_exists('generateQuotationNumber')) {
    function generateQuotationNumber()
    {
        $latestQuotation = quotation::latest('id')->first();
        if ($latestQuotation) {
            $QuotationNumber = (int) substr($latestQuotation->quotation_no, -3);
            $QuotationNumber++;
            $QuotationNumber = str_pad($QuotationNumber, 3, "0", STR_PAD_LEFT);
        } else {
            $QuotationNumber = "001";
        }
        return Carbon::now()->format('y') . '/' . Carbon::now()->format('m') . Carbon::now()->format('d') . $QuotationNumber;
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
if (!function_exists('generateOrderFormNumber')) {
    function generateOrderFormNumber()
    {
        $latestOrderForm = OrderForm::latest('id')->first();
        if ($latestOrderForm) {
            $OrderformNumber = (int) substr($latestOrderForm->orderform_no, -3);
            $OrderformNumber++;
            $OrderformNumber = str_pad($OrderformNumber, 3, "0", STR_PAD_LEFT);
        } else {
            $OrderformNumber = "001";
        }
        return Carbon::now()->format('y') . '/' . Carbon::now()->format('m') . Carbon::now()->format('d') . 'BD' . $OrderformNumber;
    }
}
