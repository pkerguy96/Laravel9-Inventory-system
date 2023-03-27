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
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Invoice Number</th>
                                        <th>Customer Name</th>
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th>Total Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                </thead>

                                <tbody>

                                    @foreach($allinvoices as $key => $item)
                                    <tr>
                                        <td> {{ $key+1}} </td>
                                        <td> {{ $item->invoice_no }} </td>
                                        <td> {{ $item['payements']['customers']['name'] }} </td>
                                        <td> {{ date('d-m-Y',strtotime($item->date))}} </td>
                                        <td> {{ $item->description}} </td>
                                        <td> {{ $item['payements']['total_amount']}} MAD</td>
                                        <td> @if($item->status == '0' )
                                            <span class="btn btn-warning">Pending</span>
                                            @elseif($item->status == '1')
                                            <span class="btn btn-success">Approved</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->status == '0' )
                                            <a href="{{route('Approve.invoice',$item->id)}}" class="btn btn-success waves-effect waves-light" title="Approve Data"> <i class="fas fa-check-circle"></i> </a>
                                            <a href="{{route('delete.invoice',$item->id)}}" class="btn btn-danger sm" title="Delete Data" id="delete"> <i class="fas fa-trash-alt"></i> </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->



    </div> <!-- container-fluid -->
</div>


@endsection