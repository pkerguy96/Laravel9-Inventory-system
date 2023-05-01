@extends('admin.admin_master')
@section('admin')
<div class="page-content">
    <div class="container-fluid">
        <style>
            .custom-margin {
                margin-bottom: 13%;
            }
        </style>
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{ __('Quotation') }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);"></a></li>
                            <li class="breadcrumb-item active">{{ __('Quotation') }} </li>
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
                                @php
                                // Convert the dates to Carbon instances
                                $startDate = \Carbon\Carbon::parse($quotation->date);
                                $endDate = \Carbon\Carbon::parse($quotation->due_date);
                                // Calculate the difference in weeks and days
                                $dateDiff = $endDate->diff($startDate);
                                $totalDaysDifference = $dateDiff->days;
                                $weeksDifference = intval($totalDaysDifference / 7);
                                $daysDifference = $totalDaysDifference % 7;
                                @endphp
                                <div class="row">
                                    <div class="col-6 mt-4">
                                        <address>
                                            <strong>{{ __('Delivery delay') }}: {{ $weeksDifference }}
                                                {{ __('Weeks and') }}
                                                {{ $daysDifference }} {{ __('days') }}</strong><br>
                                            <strong>{{ __('Payment method') }}:
                                                {{ $quotation->payement_type }}</strong><br>
                                            <br><br>
                                        </address>
                                    </div>
                                    <div class="col-6 mt-4 text-end">
                                        <address>
                                            <h5>{{ __('Quotation Number') }}: {{ $quotation->quotation_no }}</h5>
                                            <strong>{{ __('Due Date') }}:
                                                {{ date('d-m-Y', strtotime($quotation->date)) }}</strong><br>
                                            <strong>{{ __('Order Date') }}:
                                                {{ date('d-m-Y', strtotime($quotation->due_date)) }}</strong><br>

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
                                                        <td><strong>{{ __('Sl') }}</strong></td>
                                                        <td class="text-center"><strong>{{ __('Reference') }}</strong>
                                                        </td>
                                                        <td class="text-center"><strong>{{ __('Category') }}</strong>
                                                        </td>
                                                        <td class="text-center">
                                                            <strong>{{ __('Product Name') }}</strong>
                                                        <td class="text-center"><strong>{{ __('Quantity') }}</strong>
                                                        <td class="text-center">
                                                            <strong>{{ __('Unite Price') }}</strong>
                                                        <td class="text-center">
                                                            <strong>{{ __('Total Price') }}</strong>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody id="body">

                                                    @foreach ($quotation['QuotationDetails'] as $key => $quotationdetails)
                                                    <tr class="to-keep">
                                                        <td class="text-center">{{ $key + 1 }}</td>
                                                        <td class="to-keep text-center">
                                                            {{ $quotationdetails['products']['ref_num'] }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $quotationdetails['categories']['category_name'] }}
                                                        </td>
                                                        <td class="to-keep text-center">
                                                            {{ $quotationdetails['products']['product_name'] }}
                                                        </td>
                                                        <td class="to-keep text-center">
                                                            {{ $quotationdetails->qte }}
                                                        </td>
                                                        <td class="to-keep text-center">
                                                            {{ $quotationdetails->unit_price }}
                                                            MAD
                                                        </td>
                                                        <td class="to-keep text-center">
                                                            {{ number_format($quotationdetails->selling_price, 2, '.', ',') }}
                                                            MAD
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    @if (is_null($quotation->discount))
                                                    @else
                                                    <tr>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line text-center">
                                                            <strong>{{ __('Discount Amount') }}</strong>
                                                        </td>
                                                        <td class="no-line text-center">
                                                            <b>{{ number_format($quotation->discount, 2, '.', ',') }}
                                                                MAD</b>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @php
                                                    $sellingPrices = $quotation['QuotationDetails']->pluck('selling_price')->toArray();
                                                    $subtotal = CalculateGrandTotal($sellingPrices, $quotation->discount, 0);
                                                    $Grand_total = CalculateGrandTotal($sellingPrices, $quotation->discount, $quotation->tax_rate);
                                                    @endphp
                                                    <tr>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line text-center">
                                                            <strong>{{ __('Subtotal') }}</strong>
                                                        </td>
                                                        <td class="thick-line text-end">
                                                            {{ number_format($subtotal['grand_total'], 2, '.', ',') }}
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
                                                            <strong>{{ __('Tax') }}</strong>
                                                        </td>
                                                        <td class="no-line text-end">{{ $quotation->tax_rate  }}%</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line text-center">
                                                            <strong>{{ __('Total Tax') }}</strong>
                                                        </td>
                                                        <td class="no-line text-end">
                                                            {{ number_format($Grand_total['tax_amount'], 2, '.', ',') }}
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
                                                            <strong>{{ __('Grand Total') }}</strong>
                                                        </td>
                                                        <td class="no-line text-end">
                                                            <h4 class="m-0">
                                                                {{ number_format($Grand_total['grand_total'], 2, '.', ',') }}
                                                                MAD
                                                            </h4>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <hr>
                                        @if (!is_null($quotation->description))
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <div class="card card-body ">
                                                    <p class="card-text">{{ __('Description') }}:
                                                        <b>{{ $quotation->description }}</b>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @php
                                        $totalAmount = $Grand_total['grand_total'];
                                        $amountInWords = ucwords((new NumberFormatter(__('en'), NumberFormatter::SPELLOUT))->format($totalAmount));
                                        @endphp
                                        <div class="row ">
                                            <div class="col-md-12 text-center  ">
                                                <div class="card card-body border-1 border-dark">
                                                    <p class="card-text ">{{ __('Current invoice total') }}:
                                                        <b> {{ $amountInWords }}</b>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-print-none">
                                            <div class="float-end">
                                                <a id="print" href="javascript:void()" class="btn btn-success waves-effect waves-light"><i class="fa fa-print"></i></a>
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
    getPrintFunction("devis", {
        date: "{{ date('d-m-Y', strtotime($quotation->due_date)) }}",
        devis: "{{ $quotation->quotation_no }}",
        total: "{{ number_format($Grand_total['grand_total'], 2, '.', ',') }}",
        sub_total: "{{ number_format($subtotal['grand_total'], 2, '.', ',') }}",
        total_tax: "{{ number_format($Grand_total['tax_amount'], 2, '.', ',') }}",
        rows: body.innerHTML,
    }).then((print) => {
        document.querySelector("#print").addEventListener("click", print);
    });
</script>
@endsection