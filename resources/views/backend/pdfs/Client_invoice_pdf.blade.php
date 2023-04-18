@extends('admin.admin_master')
@section('admin')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Invoice</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);"></a></li>
                            <li class="breadcrumb-item active">Invoice </li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div id="page" class="row">
            <div class="col-12">
                <div class="card main-bg">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-12">
                                <div class="invoice-title">
                                    <h4 class="float-end font-size-16"><strong></strong></h4>
                                    <h3>
                                        <img src="{{ asset('backend/assets/images/logo.png') }}" alt="logo" height="24" /> Promed Plannet
                                    </h3>
                                </div>
                                <hr>

                                <div class="row">
                                    <div class="col-6 mt-4">
                                        <h2>Client:</h2>
                                        <address>
                                            <strong>{{ $invoice['clients']['name'] }}</strong><br>
                                            <strong>{{ $invoice['clients']['address'] }}</strong> <br>
                                            <strong>{{ $invoice['clients']['email'] }}</strong><br>
                                            <strong> Ice: {{ $invoice['clients']['ice'] }}</strong> <br>
                                            <strong> {{ $invoice['clients']['phone'] }} </strong>
                                        </address>
                                    </div>
                                    <div class="col-6 mt-4 text-end">
                                        <address>
                                            <h5>Invoice Number: {{ $invoice->invoice_no }}</h5>
                                            <strong>Due Date: {{ date('d-m-Y', strtotime($invoice->date)) }}</strong><br>
                                            <strong>Order Date:
                                                {{ date('d-m-Y', strtotime($invoice->due_date)) }}</strong><br>
                                            <strong>Delivery Receipt:
                                                {{ $invoice['Delivery']['delivery_no'] }}</strong><br>
                                            <br><br>
                                        </address>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <div class="p-2">

                                    </div>
                                    <div class="">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <td><strong>Sl</strong></td>
                                                        <td class="text-center"><strong>reference</strong></td>
                                                        <td class="text-center"><strong>Category</strong></td>
                                                        <td class="text-center"><strong>Product Name</strong>
                                                        <td class="text-center"><strong>Quantity</strong>
                                                        <td class="text-center"><strong>Unite Price</strong>
                                                        <td class="text-center"><strong>Total Price</strong>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody id="body">

                                                    @foreach ($invoice['InvoiceDetails'] as $key => $invdetails)
                                                    <tr class="to-keep">
                                                        <td class="text-center">{{ $key + 1 }}</td>
                                                        <td class="text-center">
                                                            {{ $invdetails['products']['ref_num'] }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $invdetails['categories']['category_name'] }}
                                                        </td>
                                                        <td class="to-keep text-center">
                                                            {{ $invdetails['products']['product_name'] }}
                                                        </td>
                                                        <td class="to-keep text-center">{{ $invdetails->qte }}</td>
                                                        <td class="to-keep text-center">
                                                            {{ $invdetails->unit_price }} MAD
                                                        </td>
                                                        <td class="to-keep text-center">
                                                            {{ number_format($invdetails->selling_price, 2, '.', ',') }}
                                                            MAD
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    @php
                                                    $sellingPrices = $invoice['InvoiceDetails']->pluck('selling_price')->toArray();
                                                    $Subtotal = CalculateGrandTotal($sellingPrices, $payement->discount_amount, 0);
                                                    $Grandtotal = CalculateGrandTotal($sellingPrices, $payement->discount_amount, 20);
                                                    @endphp
                                                    <tr>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line text-center">
                                                            <strong>Subtotal</strong>
                                                        </td>
                                                        <td class="thick-line text-end">
                                                            {{ number_format($Subtotal['grand_total'], 2, '.', ',') }}
                                                            MAD
                                                        </td>
                                                    </tr>
                                                    @if (is_null($payement->discount_amount))
                                                    @else
                                                    <tr>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line text-center">
                                                            <strong>Discount Amount</strong>
                                                        </td>
                                                        <td class="no-line text-end">
                                                            {{ number_format($payement->discount_amount, 2, '.', ',') }}
                                                            MAD
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    <tr>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line text-center">
                                                            <strong>Tax</strong>
                                                        </td>
                                                        <td class="no-line text-end">20%</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line text-center">
                                                            <strong>Total Tax</strong>
                                                        </td>
                                                        <td class="no-line text-end">
                                                            {{ number_format($Grandtotal['tax_amount'], 2, '.', ',') }}
                                                            MAD
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line text-center">
                                                            <strong>Total</strong>
                                                        </td>
                                                        <td class="no-line text-end">
                                                            <h4 class="m-0">
                                                                {{ number_format($Grandtotal['grand_total'], 2, '.', ',') }}
                                                                MAD
                                                            </h4>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <hr>
                                        @if (!is_null($invoice->description))
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <div class="card card-body ">
                                                    <p class="card-text">Description:
                                                        <b>{{ $invoice->description }}</b>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @php
                                        $amountInWords = ucwords((new NumberFormatter('en', NumberFormatter::SPELLOUT))->format($payement->total_amount));
                                        @endphp
                                        <div class="row ">
                                            <div class="col-md-12 text-center  ">
                                                <div class="card card-body border-1 border-dark">
                                                    <p class="card-text ">Current invoice total:
                                                        <b> {{ $amountInWords }}</b>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="d-print-none">
                                            <div class="float-end">
                                                <a id="print" href="javascript:void()" class="btn btn-success waves-effect waves-light"><i class="fa fa-print"></i></a>
                                                <a href="#" class="btn btn-primary waves-effect waves-light ms-2">Download</a>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div> <!-- end row -->





                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>

<!-- End Page-content -->
<script defer>
    var body = document.querySelector("#body").cloneNode(true);
    [...body.querySelectorAll("*")].forEach(e => {
        if (!e.classList.contains("to-keep")) e.remove();
    });
    getPrintFunction("facture", {
        client: "{{ $invoice['clients']['name'] }}",
        address: "{{ $invoice['clients']['address'] }}",
        ice: "{{ $invoice['clients']['ice'] }}",
        phone: "{{ $invoice['clients']['phone'] }}",
        bill: "{{ $invoice->invoice_no }}",
        date: "{{ date('d-m-Y', strtotime($invoice->due_date)) }}",
        bon: "{{ $invoice['Delivery']['delivery_no'] }}",
        tax: "20%",
        total: "{{ number_format($Grandtotal['grand_total'], 2, '.', ',') }}",
        sub_total: "{{ number_format($Subtotal['grand_total'], 2, '.', ',') }}",
        total_tax: "{{ number_format($Grandtotal['tax_amount'], 2, '.', ',') }}",
        total_text: "{{ $amountInWords }}",
        rows: body.innerHTML,
    }).then((print) => {
        document.querySelector("#print").addEventListener("click", print);
    });
</script>
@endsection