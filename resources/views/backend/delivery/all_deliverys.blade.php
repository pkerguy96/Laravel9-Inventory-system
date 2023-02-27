@extends('admin.admin_master')
@section('admin')


<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">All Delivery Receipts</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{route('add.delivery')}}" class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right"><i class="fas fa-plus-circle"> Add Delivery Receipt </i></a> <br>
                        <h4 class="card-title">All Delivery Receipts </h4>
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Delivery Number</th>
                                    <th>Customer Name</th>
                                    <th>Date</th>
                                    <th>Due Date</th>
                                    <th>Description</th>
                                    <th>Total Quantity</th>
                                    <th>Action</th>
                            </thead>

                            <tbody>

                                @foreach($deliverys as $key => $item)
                                <tr>
                                    <td> <a href="{{ route('print.delivery',$item->id) }}" class="text-reset !important"> {{ $key+1}} </a></td>
                                    <td> <a href="{{ route('print.delivery',$item->id) }}" class="text-reset !important">{{ $item->delivery_no }} </a></td>
                                    <td> <a href="{{ route('print.delivery',$item->id) }}" class="text-reset !important">{{ $item['customers']['name'] }} </a></td>
                                    <td> <a href="{{ route('print.delivery',$item->id) }}" class="text-reset !important">{{ date('d-m-Y',strtotime($item->date))}}</a> </td>
                                    <td> <a href="{{ route('print.delivery',$item->id) }}" class="text-reset !important">{{ date('d-m-Y',strtotime($item->due_date))}}</a> </td>
                                    <td> <a href="{{ route('print.delivery',$item->id) }}" class="text-reset !important">{{ $item->description}} </a></td>
                                    <td> <a href="{{ route('print.delivery',$item->id) }}" class="text-reset !important">{{ $item->total_qte}} </a></td>
                                    <td>

                                        <a href="{{route('print.delivery',$item->id)}}" class="btn btn-success waves-effect waves-light" title="Print"> <i class="fas fa-print"></i> </a>
                                        <a href="{{route('delete.delivery',$item->id)}}" class="btn btn-danger sm" title="Delete Data" id="delete"> <i class="fas fa-trash-alt"></i> </a>

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