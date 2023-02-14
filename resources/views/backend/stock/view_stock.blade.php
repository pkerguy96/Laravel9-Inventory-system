@extends('admin.admin_master')
@section('admin')


<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Stock Report</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{route('print.stock.report.pdf')}}" target="_blank" class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right"><i class="fas fa-print"> Print Stock Report </i></a> <br>
                        <h4 class="card-title">Stock Report</h4>
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sl</th>

                                    <th>Supplier</th>
                                    <th>Category</th>
                                    <th>Unit</th>
                                    <th>Reference Number</th>
                                    <th>Product Name</th>
                                    <th>Bought Quantity</th>
                                    <th>Sold Quantity</th>
                                    <th>Product Quantity</th>

                                </tr>
                            </thead>

                            <tbody>

                                @foreach($data as $key => $item)
                                @php
                                $bought_qte = App\Models\Purchase::where('category_id',$item->category_id)->where('product_id',$item->id)->where('status','1')->sum('qte');
                                $sold_qte = App\Models\InvoiceDetail::where('category_id',$item->category_id)->where('product_id',$item->id)->where('status','1')->sum('qte');
                                @endphp
                                <tr>
                                    <td> {{ $key+1}} </td>
                                    <td> {{ $item['suppliers']->name ?? 'deleted' }} </td>
                                    <td> {{ $item['categories']->category_name }} </td>
                                    <td> {{ $item['units']->unit_name }} </td>
                                    <td> {{ $item->ref_num }} </td>
                                    <td> {{ $item->product_name }} </td>
                                    <td> <span class="btn btn-info">{{$bought_qte}}</span> </td>
                                    <td> <span class="btn btn-success">{{ $sold_qte }}</span> </td>
                                    <td> <span class="btn btn-warning">{{ $item->product_qte}} </span> </td>
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