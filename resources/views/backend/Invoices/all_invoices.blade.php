@extends('admin.admin_master')
@section('admin')


<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">All Invoices</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{route('add.invoice')}}" class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right"><i class="fas fa-plus-circle"> Add Invoice </i></a> <br>
                        <h4 class="card-title">All Invoices Data </h4>
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Invoice Number</th>
                                    <th>Customer Name</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Total Amount</th>
                            </thead>

                            <tbody>

                                @foreach($allinvoices as $key => $item)
                                <tr>
                                    <td> <a href="{{ route('Print.invoice.client',$item->id) }}" class="text-reset !important">{{ $key+1}} </a></td>
                                    <td> <a href="{{ route('Print.invoice.client',$item->id) }}" class="text-reset !important">{{ $item->invoice_no }} </a></td>
                                    <td> <a href="{{ route('Print.invoice.client',$item->id) }}" class="text-reset !important">{{ $item['payements']['customers']['name'] }} </a></td>
                                    <td> <a href="{{ route('Print.invoice.client',$item->id) }}" class="text-reset !important">{{ date('d-m-Y',strtotime($item->date))}} </a></td>
                                    <td> <a href="{{ route('Print.invoice.client',$item->id) }}" class="text-reset !important">{{ $item->description}} </a></td>
                                    <td> <a href="{{ route('Print.invoice.client',$item->id) }}" class="text-reset !important">{{ $item['payements']['total_amount']}} MAD</a></td>

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