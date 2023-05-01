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
                    <h4 class="mb-sm-0">{{ __('Order Form') }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);"></a></li>
                            <li class="breadcrumb-item active">{{ __('Order Form') }} </li>
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
                                <div class="row">
                                    <div class="col-6 mt-4">

                                    </div>
                                    <div class="col-6 mt-4 text-end">
                                        <address>
                                            <h5>{{ __('Order Form Number') }}: {{ $orderforms->orderform_no }}</h5>
                                            <strong>{{ __('Date') }}:
                                                {{ date('d-m-Y', strtotime($orderforms->date)) }}</strong><br>


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
                                                        <td class="text-center"><strong>{{ __('Sl') }}</strong>
                                                        </td>
                                                        <td class="text-center"><strong>{{ __('Quantity') }}</strong>

                                                        </td>
                                                        <td class="text-center">
                                                            <strong>{{ __('Product Name') }}</strong>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody id="body" class="to-keep">

                                                    @foreach ($orderforms['OrderFormDetails'] as $key => $OrderFormDetail)
                                                    <tr class="to-keep">
                                                        <td class="text-center">{{ $key + 1 }}</td>
                                                        <td class="to-keep text-center">{{ $OrderFormDetail->qte }}</td>
                                                        <td class="to-keep text-center">
                                                            {{ $OrderFormDetail['products']['product_name'] }}
                                                        </td>

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
                                                            <strong>{{ __('Total Quantity') }}</strong>
                                                        </td>
                                                        <td class="thick-line text-center ">
                                                            {{ $orderforms->total_qte }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <hr>
                                        <div class="d-print-none">
                                            <div class="float-end">
                                                <a id="print" href="javascript:void()" class="btn btn-success waves-effect waves-light"><i class="fa fa-print"></i></a>
                                                <a href="#" class="btn btn-primary waves-effect waves-light ms-2">{{ __('Download') }}</a>
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
    getPrintFunction("commande", {
        date: "{{ date('d-m-Y', strtotime($orderforms->date)) }}",
        rows: body.innerHTML,
    }).then((print) => {
        document.querySelector("#print").addEventListener("click", print);
    });
</script>
@endsection