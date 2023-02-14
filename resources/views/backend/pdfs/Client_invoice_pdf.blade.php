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

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-12">
                                <div class="invoice-title">
                                    <h4 class="float-end font-size-16"><strong>Invoice Number: {{ $invoice->invoice_no }}</strong></h4>
                                    <h3>
                                        <img src="{{asset('backend/assets/images/logo-sm.png')}}" alt="logo" height="24" /> Promed Plannet
                                    </h3>
                                </div>
                                <hr>

                                <div class="row">
                                    <div class="col-6 mt-4">
                                        <h2>Client:</h2>
                                        <address>
                                            <strong>Promed Plannet</strong><br>
                                            Benni mellal ipse lorem lol <br>
                                            jsmith@email.com
                                        </address>
                                    </div>
                                    <div class="col-6 mt-4 text-end">
                                        <address>
                                            <h2>Facture n:</h2>
                                            <strong>Order Date:</strong><br>
                                            {{ date('d-m-Y',strtotime($invoice->date)) }}<br><br>
                                        </address>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                        $payement = App\Models\Payement::where('invoice_id',$invoice->id)->first();
                        @endphp





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
                                                <tbody>
                                                    @php
                                                    $total_price = '0';

                                                    @endphp
                                                    @foreach ( $invoice['InvoiceDetails'] as $key => $invdetails)
                                                    <tr>
                                                        <td class="text-center">{{$key+1}}</td>
                                                        <td class="text-center">{{$invdetails['products']['ref_num']}}</td>
                                                        <td class="text-center">{{$invdetails['categories']['category_name']}}</td>
                                                        <td class="text-center">{{$invdetails['products']['product_name']}}</td>

                                                        <td class="text-center">{{$invdetails->qte}}</td>
                                                        <td class="text-center">{{$invdetails->unit_price}} MAD</td>
                                                        <td class="text-center">{{$invdetails->selling_price}} MAD</td>

                                                    </tr>
                                                    @php
                                                    $total_price += $invdetails->selling_price;
                                                    @endphp
                                                    @endforeach
                                                    <tr>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>

                                                        <td class="thick-line text-center">
                                                            <strong>Subtotal</strong>
                                                        </td>
                                                        <td class="thick-line text-end">{{ $total_price }} MAD</td>
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
                                                        <td class="no-line text-end">{{ $payement->discount_amount }}</td>
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
                                                        <td class="no-line text-end"> 1057 MAD</td>
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
                                                            <h4 class="m-0">{{ $payement->total_amount}}</h4>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                        <hr>
                                        @php
                                        $totalAmount = $payement->total_amount;
                                        $amountInWords = ucwords((new NumberFormatter('fr', NumberFormatter::SPELLOUT))->format($totalAmount));
                                        @endphp
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <div class="card card-body">
                                                    <p class="card-text ">Total amount is :
                                                        <b>{{ $amountInWords}}</b>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div>

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