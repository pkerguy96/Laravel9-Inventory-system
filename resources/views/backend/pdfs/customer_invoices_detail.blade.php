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
                            <li class="breadcrumb-item active">Customer Payment Report</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-12">
                                <div class="invoice-title">
                                    <h4 class="float-end font-size-16"><strong>Invoice Number: {{ $payement['invoices']['invoice_no'] }}</strong></h4>
                                    <h3>
                                        <img src="{{asset('backend/assets/images/logo-sm.png')}}" alt="logo" height="24" /> Promed Plannet
                                    </h3>
                                </div>
                                <hr>

                                <div class="row">
                                    <div class="col-6 mt-4">
                                        <address>
                                            <strong>Promed Plannet</strong><br>
                                            Benni mellal ipse lorem lol <br>
                                            jsmith@email.com
                                        </address>
                                    </div>
                                    <div class="col-6 mt-4 text-end">
                                        <address>
                                            <strong>Order Date:</strong><br>
                                            {{ date('d-m-Y',strtotime($payement['invoices']['date'])) }}<br><br>
                                        </address>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <div class="p-2">
                                        <h3 class="font-size-16"><strong>Order summary</strong></h3>
                                    </div>
                                    <div class="">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <td><strong>Client Name</strong></td>
                                                        <td class="text-center"><strong>Client Phone</strong></td>
                                                        <td class="text-center"><strong>Client Address</strong>

                                                        </td>

                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <tr>
                                                        <td>{{$payement['customers']['name']}}</td>
                                                        <td class="text-center">{{$payement['customers']['phone']}}</td>
                                                        <td class="text-center">{{$payement['customers']['email']}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>


                                    </div>
                                </div>

                            </div>
                        </div> <!-- end row -->




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
                                                        <td class="text-center"><strong>Category</strong></td>
                                                        <td class="text-center"><strong>Product Name</strong>

                                                        <td class="text-center"><strong>Quantity</strong>
                                                        <td class="text-center"><strong>Unite Price</strong>
                                                        <td class="text-center"><strong>Total Price</strong>

                                                        </td>

                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ( $invoice['InvoiceDetails'] as $key => $invdetails)
                                                    <tr>
                                                        <td class="text-center">{{$key+1}}</td>
                                                        <td class="text-center">{{$invdetails['categories']['category_name']}}</td>
                                                        <td class="text-center">{{$invdetails['products']['product_name']}}</td>
                                                        <td class="text-center">{{$invdetails->qte}}</td>
                                                        <td class="text-center">{{$invdetails->unit_price}}</td>
                                                        <td class="text-center">{{ number_format($invdetails->selling_price, 2, '.', ',') }} MAD</td>

                                                    </tr>
                                                    @endforeach
                                                    @php
                                                    $sellingPrices = $invoice['InvoiceDetails']->pluck('selling_price')->toArray();
                                                    $Subtotal = CalculateGrandTotal($sellingPrices, $payement->discount_amount, 0);
                                                    $Grandtotal = CalculateGrandTotal($sellingPrices, $payement->discount_amount, 20);
                                                    @endphp
                                                    @if (is_null($payement->discount_amount))
                                                    @else
                                                    <tr>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>

                                                        <td class="no-line text-center">
                                                            <strong>Discount Amount</strong>
                                                        </td>
                                                        <td class="no-line text-end">{{ number_format($payement->discount_amount , 2, '.', ',') }}
                                                            MAD</td>
                                                    </tr>
                                                    @endif
                                                    <tr>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>

                                                        <td class="thick-line text-center">
                                                            <strong>Subtotal</strong>
                                                        </td>
                                                        <td class="thick-line text-end">{{ number_format($Subtotal['grand_total'], 2, '.', ',') }}
                                                            MAD</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>

                                                        <td class="thick-line text-center">
                                                            <strong>Tax 20%</strong>
                                                        </td>
                                                        <td class="thick-line text-end"> {{ number_format( $Grandtotal['tax_amount'], 2, '.', ',') }}
                                                            MAD</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>

                                                        <td class="no-line text-center">
                                                            <strong>Paid Amount</strong>
                                                        </td>
                                                        <td class="no-line text-end">{{ number_format($payement->paid_amount , 2, '.', ',') }} MAD</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>

                                                        <td class="no-line text-center">
                                                            <strong>Due Amount</strong>
                                                        </td>
                                                        <td class="no-line text-end">{{ number_format($payement->due_amount , 2, '.', ',') }} MAD</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>

                                                        <td class="no-line"></td>
                                                        <td class="no-line text-center">
                                                            <strong>Total</strong>
                                                        </td>
                                                        <td class="no-line text-end">
                                                            <h4 class="m-0">{{ number_format($payement->total_amount, 2, '.', ',') }} MAD</h4>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="7" style="text-align: center; font-weight:bold;">Payment Summary</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" style="text-align: center; font-weight:bold;">Date</td>

                                                        <td colspan="3" style="text-align: center; font-weight:bold;">Amount</td>
                                                    </tr>

                                                    @foreach ($Pdetails as $value)
                                                    <tr>
                                                        <td colspan="4" style="text-align: center; font-weight:bold;">{{ date('d-m-y',strtotime($value->date)) }}</td>

                                                        <td colspan="3" style="text-align: center; font-weight:bold;">{{ number_format($value->paid_amount_current, 2, '.', ',') }} MAD</td>
                                                    </tr>

                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="d-print-none">
                                            <div class="float-end">
                                                <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light"><i class="fa fa-print"></i></a>
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



@endsection