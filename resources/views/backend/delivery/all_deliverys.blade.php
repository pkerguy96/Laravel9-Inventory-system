@extends('admin.admin_master')
@section('admin')


<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{ __("All Delivery Receipts") }}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-row-reverse mb-md-3">
                            <a href="{{route('add.delivery')}}" class="btn btn-dark btn-rounded waves-effect waves-light"><i class="fas fa-plus-circle"> <span class="d-none d-sm-inline">{{ __("Add Delivery Receipt") }} </span></i></a>
                            <h4 class="card-title">{{ __("All Delivery Receipts") }} </h4>
                        </div>
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>{{ __("Delivery Number") }}</th>
                                    <th>{{ __("Date") }}</th>
                                    <th>{{ __("Total Quantity") }}</th>
                                    <th>{{ __("Discount") }}</th>
                                    <th>{{ __("Grand Total") }}</th>
                                    <th>{{ __("Action") }}</th>
                            </thead>

                            <tbody>

                                @foreach($deliverys as $key => $item)
                                @php
                                $deliveryDiscount = $item->discount;
                                $deliveryDetails = $item->DeliveryDetails->where('delivery_id', $item->id);
                                $sellingPrices = $deliveryDetails->pluck('selling_price')->toArray();
                                // calculate tax for the selling prices
                                $Grand_total = CalculateGrandTotal($sellingPrices, $deliveryDiscount , $item->tax_rate);
                                @endphp

                                <tr>
                                    <td> {{ $key+1}} </td>
                                    <td> <a href="{{ route('print.delivery',$item->id) }}" class="text-reset !important">{{ $item->delivery_no }} </a></td>
                                    <td> <a href="{{ route('print.delivery',$item->id) }}" class="text-reset !important">{{ date('d-m-Y',strtotime($item->date))}}</a> </td>
                                    <td> <a href="{{ route('print.delivery',$item->id) }}" class="text-reset !important">{{ $item->total_qte}} </a></td>
                                    <td> <a href="{{ route('print.delivery',$item->id) }}" class="text-reset !important">{{ $item->discount > 0 ? number_format($item->discount, 2, '.', ',') .' MAD' : 'N/A' }} </a></td>

                                    <td> <a href="{{ route('print.delivery',$item->id) }}" class="text-reset !important">{{ number_format($Grand_total['grand_total'], 2, '.', ',') }} MAD</a></td>
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