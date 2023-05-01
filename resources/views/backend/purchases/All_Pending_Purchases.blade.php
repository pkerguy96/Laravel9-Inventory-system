@extends('admin.admin_master')
@section('admin')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{ __('All Pending Purchases') }}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-row-reverse mb-md-3">
                            <a href="{{ route('add.purchase') }}" class="btn btn-dark btn-rounded waves-effect waves-light"><i class="fas fa-plus-circle"><span class="d-none d-sm-inline">{{ __('Add Purchase') }}</span></i></a>
                            <h4 class="card-title">{{ __('All Pending Purchases Data') }} </h4>
                        </div>
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>{{ __('Sl') }}</th>
                                    <th>{{ __('Purchase Date') }}</th>
                                    <th>{{ __('Purchase Number') }}</th>
                                    <th>{{ __('Grand Total') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Action') }}</th>
                            </thead>

                            <tbody>

                                @foreach ($purchases as $key => $item)
                                @php
                                $purchaseDetail = $item->PurchaseDetails->where('purchase_id', $item->id);
                                $sellingPrices = $purchaseDetail->pluck('buying_price')->toArray();
                                $Grand_total = CalculateGrandTotal($sellingPrices, 0, $item->tax_rate);
                                @endphp
                                <tr>
                                    <td> {{ $key + 1 }} </td>
                                    <td><a href="{{ route('Purchases.details', $item->id) }}" class="text-reset !important">{{ date('d-m-Y', strtotime($item->date)) }}</a> </td>
                                    <td> <a href="{{ route('Purchases.details', $item->id) }}" class="text-reset !important">{{ $item->purchase_no }} </a></td>
                                    <td> <a href="{{ route('Purchases.details', $item->id) }}" class="text-reset !important">{{ number_format($Grand_total['grand_total'], 2, '.', ',') }} MAD</a></td>
                                    <td>
                                        @if ($item->status == '0')
                                        <a class=" btn btn-warning" disabled style="cursor: not-allowed;">{{ __('Pending') }}</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->status == '0')
                                        <a href="{{ route('approve.purchase', $item->id) }}" class="btn btn-success sm" title="approve Data"> <i class="fas fa-check-circle"></i> </a>
                                        <a href="{{ route('delete.purchase', $item->id) }}" class="btn btn-danger sm" title="Delete Data" id="delete"> <i class="fas fa-trash-alt"></i> </a>
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