<?php

use App\Models\Customer;
use App\Models\DeliveryReceipt;
use App\Models\Invoice;
use App\Models\OrderForm;
use App\Models\quotation;
use Illuminate\Support\Carbon;
use App\Models\Payement;
use Illuminate\Support\Facades\Cache;


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
if (!function_exists('totalsalespercentagecalculations')) {
    function totalsalespercentagecalculations()
    {
        $cacheKey = 'total_sales_calculation';
        $cacheTime = now()->addHours(24); // Cache for 1 hour
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }
        $currentMonthSales = Payement::whereMonth('created_at', Carbon::now()->month)->sum('total_amount');
        $previousMonthSales = Payement::whereMonth('created_at', Carbon::now()->subMonth(1)->month)->sum('total_amount');
        if ($previousMonthSales == 0) {
            return null;
        }
        $percentageChange = ($currentMonthSales - $previousMonthSales) / $previousMonthSales * 100;
        $output = number_format($percentageChange, 2);
        Cache::put($cacheKey, $output, $cacheTime);
        return null;
    }
}
if (!function_exists('totalorderscalculations')) {
    function totalorderscalculations()
    {
        $cacheKey = 'total_order_calculation';
        $cacheTime = now()->addHours(24); // Cache for 1 hour
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }
        // Get the sales for the current week
        $currentWeekSales = Invoice::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        // Get the sales for the previous week
        $previousWeekSales = Invoice::whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->count();
        if ($previousWeekSales == 0) {
            return null;
        }
        $percentageChange = ($currentWeekSales - $previousWeekSales) / $previousWeekSales * 100;
        // Format the output
        $output = number_format($percentageChange, 2);
        Cache::put($cacheKey, $output, $cacheTime);
        return $output;
    }
}
if (!function_exists('totalcustomerscalculations')) {
    function totalcustomerscalculations()
    {
        $cacheKey = 'total_customers_calculation';
        $cacheTime = now()->addHours(24); // Cache for 1 hour
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }
        $currentcustomers = Customer::whereMonth('created_at', Carbon::now()->month)->count();
        $previousMonthCustomers = Customer::whereMonth('created_at', Carbon::now()->subMonth(1)->month)->count();
        if ($previousMonthCustomers == 0) {
            return null;
        }
        $percentageChange = ($currentcustomers - $previousMonthCustomers) / $previousMonthCustomers * 100;
        $output = number_format($percentageChange, 2);
        Cache::put($cacheKey, $output, $cacheTime);
        return $output;
    }
}
