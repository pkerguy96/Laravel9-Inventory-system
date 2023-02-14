@extends('admin.admin_master')
@section('admin')


<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">All Customers Credit Status</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{route('customer.pdf.print')}}" class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right" target="_blank"><i class="fas fa-plus-circle"> Print Customers Credit </i></a> <br>
                        <h4 class="card-title">All Customers Credit </h4>
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Customer Name</th>
                                    <th>Invoice Number</th>
                                    <th>Date</th>
                                    <th>Due Amount</th>
                                    <th>Action</th>

                            </thead>


                            <tbody>

                                @foreach($data as $key => $item)
                                <tr>
                                    <td> {{ $key+1}} </td>
                                    <td> {{ $item['customers']['name'] }} </td>
                                    <td> {{ $item['Invoices']['invoice_no'] }} </td>
                                    <td> {{ date('d-m-Y',strtotime( $item['Invoices']['date'] ))}} </td>
                                    <td> {{ $item->due_amount }} </td>


                                    <td>
                                        <a href="{{ route('edit.customer.invoice',$item->invoice_id) }}" class="btn btn-info sm" title="Edit Data"> <i class="fas fa-edit"></i> </a>

                                        <a href="{{route('customer.invoices.detail',$item->invoice_id)}}" class="btn btn-danger sm" title="Customers Invoice Details" target="_blank"> <i class="fas fa-eye"></i> </a>

                                    </td>

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