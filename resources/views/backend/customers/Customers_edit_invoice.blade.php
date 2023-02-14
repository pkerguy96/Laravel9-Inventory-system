@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Customer Invoice</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);"></a></li>
                            <li class="breadcrumb-item active">Customer Invoice</li>
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

                        <a href="{{route('customers.credit')}}" class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right"><i class="fas fa-list"> Back</i></a> <br>
                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <div class="p-2">
                                        <h3 class="font-size-16"><strong>Client Invoice (Invoice No: #{{ $payements['Invoices']['invoice_no'] }})</strong></h3>
                                    </div>
                                    <div class="">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <td><strong>Client Name</strong></td>
                                                        <td class="text-center"><strong>Client Phone</strong></td>
                                                        <td class="text-center"><strong>Client Address</strong>
                                                        <td class="text-center"><strong>Description</strong>
                                                        </td>

                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <tr>
                                                        <td>{{$payements['customers']['name']}}</td>
                                                        <td class="text-center">{{$payements['customers']['phone']}}</td>
                                                        <td class="text-center">{{$payements['customers']['email']}}</td>
                                                        <td class="text-center">{{$payements['Invoices']['description']}}</td>


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
                                                        $inv_details = App\Models\InvoiceDetail::where('invoice_id',$payements->invoice_id)->get();
                                                        @endphp
                                                        @foreach ( $inv_details as $key => $invdetails)
                                                        <tr>
                                                            <td class="text-center">{{$key+1}}</td>
                                                            <td class="text-center">{{$invdetails['categories']['category_name']}}</td>
                                                            <td class="text-center">{{$invdetails['products']['product_name']}}</td>

                                                            <td class="text-center">{{$invdetails->qte}}</td>
                                                            <td class="text-center">{{$invdetails->unit_price}}</td>
                                                            <td class="text-center">{{$invdetails->selling_price}}</td>

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

                                                            <td class="thick-line text-center">
                                                                <strong>Subtotal</strong>
                                                            </td>
                                                            <td class="thick-line text-end">{{ $total_price }} MAD</td>
                                                        </tr>
                                                        @if (is_null($payements->discount_amount))
                                                        @else
                                                        <tr>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>

                                                            <td class="no-line text-center">
                                                                <strong>Discount Amount</strong>
                                                            </td>
                                                            <td class="no-line text-end">{{ $payements->discount_amount }}</td>
                                                        </tr>
                                                        @endif
                                                        <tr>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>

                                                            <td class="no-line text-center">
                                                                <strong>Paid Amount</strong>
                                                            </td>
                                                            <td class="no-line text-end">{{ $payements->paid_amount}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>

                                                            <td class="no-line text-center">
                                                                <strong>Due Amount</strong>
                                                            </td>
                                                            <td class="no-line text-end">{{ $payements->due_amount}}</td>
                                                            <input type="hidden" value="{{ $payements->due_amount}}" name="dueamount">
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
                                                                <h4 class="m-0">{{ $payements->total_amount}}</h4>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-3">
                                                    <label for="">Payement Status</label>
                                                    <select name="pay_status" id="pay_status" class="form-select">
                                                        <option value="">Select Payement</option>
                                                        <option value="full_paid">Full Payement</option>
                                                        <option value="partial_paid">Partial Payement</option>
                                                    </select>
                                                    <input type="text" name="pay_amount" class="form-control paid_amount" placeholder="Enter Amount" style="display: none; margin-top: 10px;">

                                                </div>
                                                <div class="form-group col-md-3">
                                                    <div class="md-3">
                                                        <label for="example-text-input" class="form-label">Date</label>
                                                        <input class="form-control" type="date" placeholder="YYYY-MM-DD" name="date" id="date">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <div class="md-3" style="padding-top: 20px;">
                                                        <button type="submit" class="btn btn-info">Update Invoice</button>
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