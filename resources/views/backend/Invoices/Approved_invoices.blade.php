@extends('admin.admin_master')
@section('admin')


<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Approve Invoices</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        @php
        $payement = App\Models\Payement::where('invoice_id',$invoice->id)->first();
        @endphp
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4>Invoice No: #{{$invoice->invoice_no}} -- {{date('d-m-Y',strtotime($invoice->date))}}</h4>
                        <a href="{{route('all.pending.invoices')}}" class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right"><i class="fas fa-list"> Pending Invoices </i></a> <br><br>
                        <table class="table table-dark" width="100%">
                            <tbody>
                                <tr>
                                    <td>
                                        <p>Customer Info</p>
                                    </td>
                                    <td>
                                        <p>Name: <strong>{{$payement['customers']['name']}}</strong></p>
                                    </td>
                                    <td>
                                        <p>Phone: <strong>{{$payement['customers']['phone']}}</strong></p>
                                    </td>
                                    <td>
                                        <p>Email: <strong>{{$payement['customers']['email']}}</strong></p>
                                    </td>

                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="3">

                                        <p>Descriptopn: <strong>{{$invoice->description}}</strong></p>

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
                                        <th class="text-center">Category</th>
                                        <th class="text-center">Product Name</th>
                                        <th class="text-center" style="background-color: #8B008B;">Current Stock</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-center">Unite Price</th>
                                        <th class="text-center">Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $total_price = '0';

                                    @endphp
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
                                        <td class="text-center">{{$invdetails->selling_price}}</td>
                                    </tr>
                                    @php
                                    $total_price += $invdetails->selling_price;
                                    @endphp
                                    @endforeach
                                    <tr>
                                        <td colspan="6">Sub Total:</td>
                                        <td>{{ $total_price }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">Discount:</td>
                                        <td>{{ $payement->discount_amount }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">Paid Amount</td>
                                        <td>{{ $payement->paid_amount}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">Due Amount</td>
                                        <td>{{ $payement->due_amount}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">Grand Amount</td>
                                        <td>{{ $payement->total_amount}}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-info">Approve Invoice</button>
                        </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->



    </div> <!-- container-fluid -->
</div>


@endsection