<!-- @extends('admin.admin_master')
@section('admin')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Customer Paid Credit Report</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);"></a></li>
                    <li class="breadcrumb-item active">Customer Paid Credit Report</li>
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
                                                <td class="text-center"><strong>Customer Name</strong></td>
                                                <td class="text-center"><strong>Invoice No</strong></td>
                                                <td class="text-center"><strong>Date</strong></td>
                                                <td class="text-center"><strong>Paid Amount</strong></td>
                                                </td>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $total_price = '0';

                                            @endphp
                                            @foreach ( $data as $key => $item)
                                            <tr>
                                                <td class="text-center">{{$key+1}}</td>
                                                <td class="text-center"> {{ $item['customers']['name'] }}</td>
                                                <td class="text-center">{{ $item['Invoices']['invoice_no'] }}</td>
                                                <td class="text-center">{{ date('d-m-Y',strtotime( $item['Invoices']['date'] ))}}</td>
                                                <td class="text-center">{{ number_format($item->paid_amount , 2, '.', ',') }} MAD</td>
                                            </tr>
                                            @php
                                            $total_price += $item->paid_amount ;
                                            @endphp
                                            @endforeach

                                            <tr>
                                                <td class="no-line"></td>
                                                <td class="no-line"></td>
                                                <td class="no-line"></td>

                                                <td class="no-line text-center">
                                                    <strong>Total Payments</strong>
                                                </td>
                                                <td class="no-line text-end">
                                                    <h4 class="m-0">{{ number_format($total_price, 2, '.', ',') }} MAD</h4>
                                                </td>
                                            </tr>

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



@endsection -->