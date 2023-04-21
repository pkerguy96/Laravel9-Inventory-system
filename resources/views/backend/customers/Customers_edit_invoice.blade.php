@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{ __("Customer Invoice") }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);"></a></li>
                            <li class="breadcrumb-item active">{{ __("Customer Invoice") }}</li>
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

                        <a href="{{route('customers.credit')}}" class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right"><i class="fas fa-list"> {{ __("Back") }}</i></a> <br>
                        <div class="row w-100">
                            <div class="col-12">
                                <div>
                                    <div class="p-2">
                                        <h3 class="font-size-16"><strong>{{ __("Client Invoice") }} (Invoice No: #{{ $payements['Invoices']['invoice_no'] }})</strong></h3>
                                    </div>
                                    <div class="">
                                        <div class="table-responsive ">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <td><strong>{{ __("Client Name") }}</strong></td>
                                                        <td class="text-center"><strong>{{ __("Client Phone") }}</strong></td>
                                                        <td class="text-center"><strong>{{ __("Client Address") }}</strong>
                                                        <td class="text-center"><strong>{{ __("Description") }}</strong>
                                                        </td>

                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <tr>
                                                        <td>{{$payements['customers']['name']}}</td>
                                                        <td class="text-center">{{$payements['customers']['phone']}}</td>
                                                        <td class="text-center">{{$payements['customers']['email']}}</td>
                                                        <td class="text-center">{{$payements['Invoices']['description'] ?? 'N/A'}}</td>


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
                                <form action="{{route('update.customer.payement',$payements->invoice_id)}}" method="post">
                                    @csrf

                                    <div>
                                        <div class="p-2">

                                        </div>
                                        <div class="">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <td><strong>Sl</strong></td>
                                                            <td class="text-center"><strong>{{ __("Category") }}</strong></td>
                                                            <td class="text-center"><strong>{{ __("Product Name") }}</strong>

                                                            <td class="text-center"><strong>{{ __("Quantity") }}</strong>
                                                            <td class="text-center"><strong>{{ __("Unite Price") }}</strong>
                                                            <td class="text-center"><strong>{{ __("Total Price") }}</strong>

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
                                                            <td class="text-center"> {{ number_format($invdetails->selling_price, 2, '.', ',') }} MAD</td>

                                                        </tr>
                                                        @endforeach
                                                        @php
                                                        $sellingPrices = $invoice['InvoiceDetails']->pluck('selling_price')->toArray();
                                                        $Subtotal = CalculateGrandTotal($sellingPrices, $payements->discount_amount, 0);
                                                        $Grandtotal = CalculateGrandTotal($sellingPrices, $payements->discount_amount, 20);
                                                        @endphp
                                                        @if (is_null($payements->discount_amount))
                                                        @else
                                                        <tr>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>

                                                            <td class="no-line text-center">
                                                                <strong>{{ __("Discount Amount") }}</strong>
                                                            </td>
                                                            <td class="no-line text-end">{{ number_format($payements->discount_amount , 2, '.', ',') }}
                                                                MAD </td>
                                                        </tr>
                                                        @endif
                                                        <tr>
                                                            <td class="thick-line"></td>
                                                            <td class="thick-line"></td>
                                                            <td class="thick-line"></td>
                                                            <td class="thick-line"></td>

                                                            <td class="thick-line text-center">
                                                                <strong>{{ __("Subtotal") }}</strong>
                                                            </td>
                                                            <td class="thick-line text-end"> {{ number_format($Subtotal['grand_total'], 2, '.', ',') }}
                                                                MAD</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="thick-line"></td>
                                                            <td class="thick-line"></td>
                                                            <td class="thick-line"></td>
                                                            <td class="thick-line"></td>

                                                            <td class="thick-line text-center">
                                                                <strong>{{ __("Tax 20%") }}</strong>
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
                                                                <strong>{{ __("Paid Amount") }}</strong>
                                                            </td>
                                                            <td class="no-line text-end">{{ number_format($payements->paid_amount , 2, '.', ',') }} MAD</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>

                                                            <td class="no-line text-center">
                                                                <strong>{{ __("Due Amount") }}</strong>
                                                            </td>
                                                            <td class="no-line text-end">{{ number_format($payements->due_amount , 2, '.', ',') }} MAD</td>
                                                            <input type="hidden" value="{{ $payements->due_amount}}" name="dueamount">
                                                        </tr>
                                                        <tr>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>

                                                            <td class="no-line"></td>
                                                            <td class="no-line text-center">
                                                                <strong>{{ __("Total") }}</strong>
                                                            </td>
                                                            <td class="no-line text-end">
                                                                <h4 class="m-0">{{ number_format($payements->total_amount, 2, '.', ',') }} MAD</h4>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-3">
                                                    <label for="">{{ __("Payement Status") }}</label>
                                                    <select name="pay_status" id="pay_status" class="form-select">
                                                        <option value="">{{ __("Select Payement") }}</option>
                                                        <option value="full_paid">{{ __("Full Payement") }}</option>
                                                        <option value="partial_paid">{{ __("Partial Payement") }}</option>
                                                    </select>
                                                    <input type="text" name="pay_amount" class="form-control paid_amount" placeholder="{{ __('Enter Amount') }}" style="display: none; margin-top: 10px;">

                                                </div>
                                                <div class="form-group col-md-3">
                                                    <div class="md-3">
                                                        <label for="example-text-input" class="form-label">{{ __("Date") }}</label>
                                                        <input class="form-control" type="date" placeholder="YYYY-MM-DD" name="date" id="date">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <div class="md-3" style="padding-top: 20px;">
                                                        <button type="{{ __('submit') }}" class="btn btn-info">{{ __("Update Invoice") }}</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>







                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

<script type="text/javascript">
    $(document).on('change', '#pay_status', function() {
        var payement_status = $(this).val();
        if (payement_status == 'partial_paid') {
            $('.paid_amount').show();
        } else {
            $('.paid_amount').hide();
        }
    });
</script>

@endsection