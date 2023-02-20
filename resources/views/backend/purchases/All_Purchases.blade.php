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
                                    <th>Purchase Date</th>
                                    <th>Purchase Number</th>
                                    <th>Supplier</th>
                                    <th>Category</th>
                                    <th>Quantity</th>
                                    <th>Product Name</th>
                                    <th>Grand Total</th>
                                    <th>Status</th>
                                    <th>Action</th>
                            </thead>

                            <tbody>

                                @foreach($purchases as $key => $item)

                                <tr>

                                    <td> <a href="{{ route('Purchases.details',$item->id) }}" class="text-reset !important"> {{ $key+1}} </a></td>
                                    <td><a href="{{ route('Purchases.details',$item->id) }}" class="text-reset !important">{{ date('d-m-Y',strtotime($item->date))}}</a> </td>
                                    <td> <a href="{{ route('Purchases.details',$item->id) }}" class="text-reset !important">{{ $item->purchase_no }} </a></td>
                                    <td> <a href="{{ route('Purchases.details',$item->id) }}" class="text-reset !important">{{ $item['suppliers']->name}} </a></td>
                                    <td> <a href="{{ route('Purchases.details',$item->id) }}" class="text-reset !important">{{ $item['categories']->category_name}}</a> </td>
                                    <td> <a href="{{ route('Purchases.details',$item->id) }}" class="text-reset !important">{{ $item->qte}} </a></td>
                                    <td> <a href="{{ route('Purchases.details',$item->id) }}" class="text-reset !important">{{ $item['products']->product_name}} </a></td>
                                    <td> <a href="{{ route('Purchases.details',$item->id) }}" class="text-reset !important">{{ $item->grand_total}} MAD</a></td>
                                    <td>
                                        @if($item->status == '0' )
                                        <a class=" btn btn-warning" href="{{route('all.Pending.Purchases')}}">Pending</a>
                                        @elseif($item->status == '1')
                                        <a class="btn btn-success" disabled style="cursor: not-allowed;">Approved</a>
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