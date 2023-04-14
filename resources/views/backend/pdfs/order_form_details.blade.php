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
                    <h4 class="mb-sm-0">Order Form</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);"></a></li>
                            <li class="breadcrumb-item active">Order Form </li>
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
                                        <img src="{{asset('backend/assets/images/logo.png')}}" alt="logo" height="24" /> Promed Plannet
                                    </h3>
                                </div>
                                <hr>

                                <div class="row">
                                    <div class="col-6 mt-4">

                                    </div>
                                    <div class="col-6 mt-4 text-end">
                                        <address>
                                            <h5>Order Form Number: {{ $orderforms->orderform_no }}</h5>
                                            <strong>Date: {{ date('d-m-Y',strtotime($orderforms->date)) }}</strong><br>


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
                                                        <td class="text-center"><strong>Sl</strong></td>
                                                        <td class="text-center"><strong>Product Name</strong>
                                                        <td class="text-center"><strong>Quantity</strong>

                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ( $orderforms['OrderFormDetails'] as $key => $OrderFormDetail)
                                                    <tr>
                                                        <td class="text-center">{{$key+1}}</td>
                                                        <td class="text-center">{{$OrderFormDetail['products']['product_name']}}</td>
                                                        <td class="text-center">{{$OrderFormDetail->qte}}</td>

                                                    </tr>

                                                    @endforeach
                                                    <tr>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
                                                    </tr>
                                                    <tr>



                                                        <td class="thick-line"></td>
                                                        <td class="thick-line text-center">
                                                            <strong>Total Quantity</strong>
                                                        </td>
                                                        <td class="thick-line text-center ">{{ $orderforms->total_qte }} </td>
                                                    </tr>




                                                </tbody>
                                            </table>
                                        </div>
                                        <hr>




                                        <div class="d-print-none">
                                            <div class="float-end">
                                                <a id="print" class="btn btn-success waves-effect waves-light"><i class="fa fa-print"></i></a>
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