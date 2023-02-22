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
                        <a href="{{route('add.invoice')}}" class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right"><i class="fas fa-plus-circle"> Add Delivery Receipt </i></a> <br>
                        <h4 class="card-title">All Delivery Receipts </h4>
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Delivery Number</th>
                                    <th>Customer Name</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Quantity</th>
                                    <th>Total Amount</th>
                            </thead>

                            <tbody>

                                @foreach($deliverys as $key => $item)
                                <tr>
                                    <td> {{ $key+1}} </td>
                                    <td> {{ $item->delivery_no }} </td>
                                    <td> {{ $item['customers']['name'] }} </td>
                                    <td> {{ date('d-m-Y',strtotime($item->date))}} </td>
                                    <td> {{ $item->description}} </td>
                                    <td> {{ $item->qte}} </td>
                                    <td> {{ $item->grand_total}} MAD</td>

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