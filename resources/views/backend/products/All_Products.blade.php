@extends('admin.admin_master')
@section('admin')


<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">All Products</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{route('add.product')}}" class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right"><i class="fas fa-plus-circle"> Add Product </i></a> <br>
                        <h4 class="card-title">All Products Data </h4>
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Brand</th>
                                    <th>Product Name</th>
                                    <th>Product Quantity</th>
                                    <th>Supplier</th>
                                    <th>Unit</th>
                                    <th>Category</th>
                                    <th>Action</th>
                            </thead>

                            <tbody>

                                @foreach($products as $key => $item)
                                <tr>
                                    <td> {{ $key+1}} </td>
                                    <td> {{ $item['brands']->Brand_name ?? ' ' }} </td>
                                    <td> {{ $item->product_name }} </td>
                                    <td> {{ $item->product_qte}} </td>
                                    <!-- COME BACK FOR THIS TO CHECK WEATHER ITS DELETED OR NOT  -->
                                    <td> {{ $item['suppliers']->name ?? '' }} </td>
                                    <td> {{ $item['units']->unit_name ?? ' '}} </td>
                                    <td> {{ $item['categories']->category_name ?? ' '}} </td>

                                    <td>
                                        <a href="{{ route('edit.product',$item->id) }}" class="btn btn-info sm" title="Edit Data"> <i class="fas fa-edit"></i> </a>

                                        <a href="{{route('delete.product',$item->id)}}" class="btn btn-danger sm" title="Delete Data" id="delete"> <i class="fas fa-trash-alt"></i> </a>

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