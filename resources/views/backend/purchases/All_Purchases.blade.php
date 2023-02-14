@extends('admin.admin_master')
@section('admin')


<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">All Purchases</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{route('add.purchase')}}" class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right"><i class="fas fa-plus-circle"> Add Purchase </i></a> <br>
                        <h4 class="card-title">All Purchases Data </h4>
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Purchase Number</th>
                                    <th>Purchase Date</th>
                                    <th>Supplier</th>
                                    <th>Category</th>
                                    <th>Quantity</th>
                                    <th>Product Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                            </thead>

                            <tbody>

                                @foreach($purchases as $key => $item)
                                <tr>
                                    <td> {{ $key+1}} </td>
                                    <td> {{ $item->purchase_no }} </td>
                                    <td> {{ date('d-m-Y',strtotime($item->date))}} </td>
                                    <td> {{ $item['suppliers']->name}} </td>
                                    <td> {{ $item['categories']->category_name}} </td>
                                    <td> {{ $item->qte}} </td>
                                    <td> {{ $item['products']->product_name}} </td>
                                    <td>
                                        @if($item->status == '0' )
                                        <span class="btn btn-warning">Pending</span>
                                        @elseif($item->status == '1')
                                        <span class="btn btn-success">Approved</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($item->status == '0' )
                                        <a href="{{route('delete.purchase',$item->id)}}" class="btn btn-danger sm" title="Delete Data" id="delete"> <i class="fas fa-trash-alt"></i> </a>
                                        @endif
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