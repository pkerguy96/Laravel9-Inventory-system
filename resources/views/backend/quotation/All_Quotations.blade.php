@extends('admin.admin_master')
@section('admin')


<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">All Quotations</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{route('add.quotation')}}" class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right"><i class="fas fa-plus-circle"> Add Quotation </i></a> <br>
                        <h4 class="card-title">All Quotations Data </h4>
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Quotation Number</th>
                                    <th>Date</th>
                                    <th>Due Date</th>
                                    <th>Payement Type</th>
                                    <th>Discount</th>
                                    <th>Total Quantity</th>
                                    <th>Grand Total</th>
                                    <th>Action</th>
                            </thead>

                            <tbody>


                                @foreach ($data as $key => $item)
                                @php
                                $QuotationDiscount = $item->discount;
                                $QuotationDetail = $item->QuotationDetails->where('quotation_id', $item->id);
                                $sellingPrices = $QuotationDetail->pluck('selling_price')->toArray();
                                // calculate tax for the selling prices
                                $Grand_total = CalculateGrandTotal($sellingPrices, $QuotationDiscount , 20);
                                @endphp

                                <tr>
                                    <td><a href="{{ route('quotation.details',$item->id) }}" class="text-reset !important">{{ $key+1 }}</a></td>
                                    <td><a href="{{ route('quotation.details',$item->id) }}" class="text-reset !important">{{ $item->quotation_no }}</a></td>
                                    <td><a href="{{ route('quotation.details',$item->id) }}" class="text-reset !important">{{ date('d-m-Y',strtotime($item->date)) }}</a></td>
                                    <td><a href="{{ route('quotation.details',$item->id) }}" class="text-reset !important">{{ date('d-m-Y',strtotime($item->due_date)) }}</a></td>
                                    <td><a href="{{ route('quotation.details',$item->id) }}" class="text-reset !important">{{ $item->payement_type}}</a></td>
                                    <td><a href="{{ route('quotation.details',$item->id) }}" class="text-reset !important">{{ $item->discount ? number_format($item->discount, 2, '.', ',') . ' MAD' : 'N/A' }} </a></td>
                                    <td><a href="{{ route('quotation.details',$item->id) }}" class="text-reset !important">{{ $item->total_qte }}</a></td>
                                    <td><a href="{{ route('quotation.details',$item->id) }}" class="text-reset !important">{{ number_format( $Grand_total['grand_total'], 2, '.', ',') }} MAD </a></td>
                                    <td>
                                        <a href="{{route('delete.quotation',$item->id)}}" class="btn btn-danger sm" title="Delete Data" id="delete"> <i class="fas fa-trash-alt"></i> </a>
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