@extends('admin.admin_master')
@section('admin')


<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{ __("Approve Invoice") }}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4>{{ __("Invoice No") }}: #{{$invoice->invoice_no}} -- {{date('d-m-Y',strtotime($invoice->date))}}</h4>
                        <a href="{{route('all.pending.invoices')}}" class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right"><i class="fas fa-list"> {{ __("Pending Invoices") }} </i></a> <br><br>
                        <table class="table table-dark" width="100%">
                            <tbody>
                                <tr>
                                    <td>
                                        <p>{{ __("Customer Info") }}:</p>
                                    </td>
                                    <td>
                                        <p>{{ __("Name") }}: <strong>{{$payement['customers']['name']}}</strong></p>
                                    </td>
                                    <td>
                                        <p>{{ __("Phone") }}: <strong>{{$payement['customers']['phone']}}</strong></p>
                                    </td>
                                    <td>
                                        <p>{{ __("Email") }}: <strong>{{$payement['customers']['email']}}</strong></p>
                                    </td>

                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="3">

                                        <p>{{ __("Description") }}:
                                            <strong>{{$invoice->description ?? 'N/A'}}</strong>

                                        </p>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <form action="{{route('accept.invoice',$invoice->id) }}" method="post">
                            @csrf
                            <table border="1" class="table table-dark" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">SL</th>
                                        <th class="text-center">{{ __("Category") }}</th>
                                        <th class="text-center">{{ __("Product Name") }}</th>
                                        <th class="text-center" style="background-color: #8B008B;">{{ __("Current Stock") }}</th>
                                        <th class="text-center">{{ __("Quantity") }}</th>
                                        <th class="text-center">{{ __("Unite Price") }}</th>
                                        <th class="text-center">{{ __("Total Price") }}</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ( $invoice['InvoiceDetails'] as $key => $invdetails)
                                    <tr>
                                        <input type="hidden" name="category_id[]" value="{{$invdetails->category_id}}">
                                        <input type="hidden" name="product_id[$invdetails->product_id ]" value="{{$invdetails->product_id}}">
                                        <input type="hidden" name="qte[{{$invdetails->id }}]" value="{{$invdetails->qte}}">

                                        <td class="text-center">{{$key+1}}</td>
                                        <td class="text-center">{{$invdetails['categories']['category_name']}}</td>
                                        <td class="text-center">{{$invdetails['products']['product_name']}}</td>
                                        <td class="text-center" style="background-color: #8B008B;">{{$invdetails['products']['product_qte']}}</td>
                                        <td class="text-center">{{$invdetails->qte}}</td>
                                        <td class="text-center">{{$invdetails->unit_price}}</td>
                                        <td class="text-center">{{ number_format( $invdetails->selling_price, 2, '.', ',') }} MAD</td>
                                    </tr>

                                    @endforeach
                                    @php
                                    $sellingPrices = $invoice['InvoiceDetails']->pluck('selling_price')->toArray();
                                    $Subtotal = CalculateGrandTotal($sellingPrices, $payement->discount_amount , 0);
                                    $Grandtotal = CalculateGrandTotal($sellingPrices, $payement->discount_amount , $invoice->tax_rate);
                                    @endphp
                                    <tr class="text-center">
                                        <td colspan="6">{{ __("Discount") }}:</td>

                                        <td>{{ isset($payement->discount_amount) ? number_format($payement->discount_amount, 2, '.', ',').' MAD' : 'N/A' }}</td>


                                    </tr>
                                    <tr class="text-center">
                                        <td colspan="6">{{ __("Subtotal") }}:</td>

                                        <td>{{ number_format(  $Subtotal['grand_total'] , 2, '.', ',') }} MAD</td>
                                    </tr>

                                    <tr class="text-center">
                                        <td colspan="6">{{ __("Tax") }} {{ $invoice->tax_rate }}%:</td>

                                        <td> {{ number_format(  $Grandtotal['tax_amount'] , 2, '.', ',') }} MAD</td>
                                    </tr>
                                    <tr class="text-center">
                                        <td colspan="6">{{ __("Grand Total") }}:</td>
                                        <td> {{ number_format( $Grandtotal['grand_total'] , 2, '.', ',') }} MAD</td>
                                    </tr>

                                    <tr class="text-center">
                                        <td colspan="6">{{ __("Paid Amount") }}:</td>
                                        <td> {{ number_format( $payement->paid_amount , 2, '.', ',') }} MAD</td>
                                    </tr>
                                    <tr class="text-center">
                                        <td colspan="6">{{ __("Due Amount") }}:</td>
                                        <td> {{ number_format(  $payement->due_amount , 2, '.', ',') }} MAD</td>
                                    </tr>

                                </tbody>
                            </table>
                            <button type="{{ __('submit') }}" class="btn btn-info">{{ __("Approve Invoice") }}</button>
                        </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->



    </div> <!-- container-fluid -->
</div>


@endsection