@extends('admin.admin_master')
@section('admin')


<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{ __("All Invoices") }}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body ">
                        <div class="d-flex justify-content-between align-items-center flex-row-reverse mb-md-3">
                            <a href="{{route('add.invoice')}}" class="btn btn-dark btn-rounded waves-effect waves-light"><i class="fas fa-plus-circle"> <span class="d-none d-sm-inline">{{ __("Add Invoice") }}</span> </i></a>
                            <h4 class="card-title">{{ __("All Invoices Data") }} </h4>
                        </div>

                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>{{ __("Invoice Number") }}</th>
                                    <th>{{ __("Customer Name") }}</th>
                                    <th>{{ __("Date") }}</th>
                                    <th>{{ __("Description") }}</th>
                                    <th>{{ __("Total Amount") }}</th>
                            </thead>

                            <tbody>

                                @foreach($allinvoices as $key => $item)
                                <tr>
                                    <td> {{ $key+1}} </td>
                                    <td> <a href="{{ route('Print.invoice.client',$item->id) }}" class="text-reset !important">{{ $item->invoice_no }} </a></td>
                                    <td> <a href="{{ route('Print.invoice.client',$item->id) }}" class="text-reset !important">{{ $item['payements']['customers']['name'] }} </a></td>
                                    <td> <a href="{{ route('Print.invoice.client',$item->id) }}" class="text-reset !important">{{ date('d-m-Y',strtotime($item->date))}} </a></td>
                                    <td> <a href="{{ route('Print.invoice.client',$item->id) }}" class="text-reset !important">{{ $item->description ?? 'N/A'}} </a></td>
                                    <td> <a href="{{ route('Print.invoice.client',$item->id) }}" class="text-reset !important">{{ number_format(  $item['payements']['total_amount'], 2, '.', ',') }} MAD</a></td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->



    </div> <!-- container-fluid -->
</div>


@endsection