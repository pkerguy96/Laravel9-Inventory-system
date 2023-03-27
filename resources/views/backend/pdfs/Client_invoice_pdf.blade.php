@extends('admin.admin_master')
@section('admin')
<div class="page-content">
    <div class="container-fluid">
        <style>
            .custom-margin {
                margin-bottom: 13%;
            }

            /*    .btn {
                z-index: 999;
                position: relative;
            } */

            /*  .main-bg {
                background-image: url("{{ asset('backend/assets/images/logo-promed-3adi.png') }}");
                opacity: 0.3;
                background-position: center;
                background-size: cover;
            } */
            /*     .main-bg {
                position: relative;
                z-index: -1;
            }

            .main-bg::before {
                content: "";
                position: absolute;
                top: 3%;
                left: 0;
                width: 98%;
                height: 98%;
                background-image: url("{{ asset('backend/assets/images/logo-promed-3adi.png') }}");
                background-size: cover;
                background-position: center center;
                opacity: 0.1;
                z-index: -2;
            } */
        </style>
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
                                        <img src="{{asset('backend/assets/images/logo-promed-sm.png')}}" alt="logo" height="24" /> Promed Plannet
                                    </h3>
                                </div>
                                <hr>

                                <div class="row">
                                    <div class="col-6 mt-4">
                                        <h2>Client:</h2>
                                        <address>
                                            <strong>{{ $invoice['clients']['name'] }}</strong><br>
                                            <strong>{{ $invoice['clients']['address'] }}</strong> <br>
                                            <strong> Ice: {{ $invoice['clients']['ice'] }}</strong> <br>
                                            <strong> {{ $invoice['clients']['phone'] }} </strong>
                                        </address>
                                    </div>
                                    <div class="col-6 mt-4 text-end">
                                        <address>
                                            <h3>Invoice Number: {{ $invoice->invoice_no }}</h3>
                                            <strong>Due Date: {{ date('d-m-Y',strtotime($invoice->date)) }}</strong><br>
                                            <strong>Order Date: {{ date('d-m-Y',strtotime($invoice->due_date)) }}</strong><br>
                                            <strong>Delivery Receipt: {{ $invoice['Delivery']['delivery_no'] }}</strong><br>
                                            <br><br>
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
                                                <thead class="border-1 border-dark" style="background-color:  rgba(0,255,0,255);">
                                                    <tr>
                                                        <td class="text-center border border-right-1 border-dark"><strong>Sl</strong></td>
                                                        <td class="text-center border border-right-1 border-dark"><strong>reference</strong></td>
                                                        <td class="text-center border border-right-1 border-dark"><strong>Category</strong></td>
                                                        <td class="text-center border border-right-1 border-dark"><strong>Product Name</strong> </td>

                                                        <td class="text-center border border-right-1 border-dark"><strong>Quantity</strong> </td>
                                                        <td class="text-center border border-right-1 border-dark"><strong>Unite Price</strong> </td>
                                                        <td class="text-center"><strong>Total Price</strong> </td>



                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                    $total_price = '0';

                                                    @endphp
                                                    @foreach ( $invoice['InvoiceDetails'] as $key => $invdetails)
                                                    <tr class="border border-dark">
                                                        <td class="text-center border border-right-1 border-dark">{{$key+1}}</td>
                                                        <td class="text-center border border-right-1 border-dark">{{$invdetails['products']['ref_num']}}</td>
                                                        <td class="text-center border border-right-1 border-dark">{{$invdetails['categories']['category_name']}}</td>
                                                        <td class="text-center border border-right-1 border-dark">{{$invdetails['products']['product_name']}}</td>

                                                        <td class="text-center border border-right-1 border-dark">{{$invdetails->qte}}</td>
                                                        <td class="text-center border border-right-1 border-dark">{{$invdetails->unit_price}} MAD</td>
                                                        <td class="text-center">{{$invdetails->selling_price}} MAD</td>

                                                    </tr>
                                                    @php
                                                    $total_price += $invdetails->selling_price;
                                                    @endphp
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="5" class="no-line border-0"></td>

                                                        <td class="thick-line text-center border-1 border-dark" style="background-color:  rgba(0,255,0,255);">
                                                            <strong>Subtotal</strong>
                                                        </td>
                                                        <td class="thick-line text-center border-1 border-dark border-left-0" style="background-color:  rgba(0,255,0,255);">{{ $total_price }} MAD</td>
                                                    </tr>

                                                    @if (is_null($payement->discount_amount))
                                                    @else
                                                    <tr>
                                                        <td colspan="5" class="no-line border-0"></td>

                                                        <td class="no-line text-center border-1 border-dark" style="background-color:  rgba(0,255,0,255);">
                                                            <strong>Discount Amount</strong>
                                                        </td>
                                                        <td class="no-line text-center border-1 border-dark border-left-0" style="background-color:  rgba(0,255,0,255);">{{ $payement->discount_amount }} MAD</td>
                                                    </tr>
                                                    @endif
                                                    <tr>
                                                        <td colspan="5" class="no-line border-0"></td>

                                                        <td class="no-line text-center border-1 border-dark" style="background-color:  rgba(0,255,0,255);">
                                                            <strong>Tax</strong>
                                                        </td>
                                                        <td class="no-line text-center border-1 border-dark border-left-0" style="background-color:  rgba(0,255,0,255);">20%</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5" class="no-line border-0"></td>

                                                        <td class="no-line text-center border-1 border-dark" style="background-color:  rgba(0,255,0,255);">
                                                            <strong>Total Tax</strong>
                                                        </td>
                                                        <td class="no-line text-center border-1 border-dark border-left-0" style="background-color:  rgba(0,255,0,255);">1057 MAD </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="5" class="no-line border-0"></td>
                                                        <td class="no-line text-center border-1 border-dark" style="background-color:  rgba(0,255,0,255);">
                                                            <h5 class="m-0">Total</h5>
                                                        </td>
                                                        <td class="no-line text-center border-1 border-dark border-left-0" style="background-color:  rgba(0,255,0,255); ">
                                                            <h5 class="m-0">{{ $payement->total_amount}} MAD</h5>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                        <hr>
                                        @php
                                        $totalAmount = $payement->total_amount;
                                        $amountInWords = ucwords((new NumberFormatter('en', NumberFormatter::SPELLOUT))->format($totalAmount));
                                        @endphp
                                        <div class="row ">
                                            <div class="col-md-12 text-center  ">
                                                <div class="card card-body border-1 border-dark">
                                                    <p class="card-text ">Current invoice total:
                                                        <b style="color:rgba(0,255,0,255);"> {{ $amountInWords}}</b>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row pt-3 custom-margin ">
                                            <div class="mb-5">
                                                <h4 style="text-align: right; margin-right:20px;"><strong>Signature</strong></h4>

                                            </div>

                                        </div>
                                        <div class="text-center">
                                            <hr class="p-1 rounded-3 text-dark " style="margin-left: 8%; margin-right:8%; background-color:rgba(0,255,0,255);">
                                            <p class="pt-4 pb-4  rounded-3 text-center" style="margin-left: 8%; margin-right:8%; background-color: rgba(0,255,0,255);">PROMED PLANET SARL AU au capital de 100 000 MAD / RC : 12937 / IF : 52551967 / TAXE PROFESSIONNELLE : 41304239 <br>
                                                ICE: 003103471000024 | Compte bancaire : 011 450 0000452100001985 13 <br>
                                                SIEGE SOCIAL : ETG 1 AV MED V° HAY CHARAF AIT KORCHI PRES DE LA GENDARMERIE ROYALE BENI MELLAL <br>
                                                GSM: 0661 47 25 34 // 0039 388 126 9567 | Email : promed.planet@gmail.com | Web : www.promedplanet.ma


                                            </p>
                                        </div>

                                        <div class="d-print-none">
                                            <div class="float-end">
                                                <a id="print" class="btn btn-success waves-effect waves-light"><i class="fa fa-print"></i></a>
                                                <a href="{{route('generate-pdf',$invoice->id)}}" class="btn btn-primary waves-effect waves-light ms-2">Download</a>
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
<script defer>
    getPrintFunction({
        client: "ahmedqo",
        address: "04 rue nador",
        ice: "1000000s54s5455",
        phone: "4545545455454",
        bill: "2023/10",
        date: "1000000s54s5455",
        bon: "1000000s54s5455",
        tax: "1000000s54s5455",
        total: "{{ $payement->total_amount }}",
        sub_total: "1000000s54s5455",
        total_tax: "1000000s54s5455",
        total_text: "1000000s54s5455",
        rows: `	<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
            <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
          
         
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
            
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>`,
    }).then((print) => {
        document.querySelector("#print").addEventListener("click", print);
    });
</script>
<!-- End Page-content -->



@endsection