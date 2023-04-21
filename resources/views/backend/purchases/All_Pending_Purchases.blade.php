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
                                    <th>{{ __('Purchase Number') }}</th>
                                    <th>{{ __('Purchase Date') }}</th>
                                    <th>{{ __('Supplier') }}</th>
                                    <th>{{ __('Category') }}</th>
                                    <th>{{ __('Quantity') }}</th>
                                    <th>{{ __('Product Name') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Action') }}</th>
                            </thead>

                            <tbody>

                                @foreach ($purchases as $key => $item)
                                <tr>
                                    <td> <a href="{{ route('Purchases.details', $item->id) }}" class="text-reset !important"> {{ $key + 1 }} </a> </td>
                                    <td> <a href="{{ route('Purchases.details', $item->id) }}" class="text-reset !important"> {{ $item->purchase_no }} </a></td>
                                    <td> <a href="{{ route('Purchases.details', $item->id) }}" class="text-reset !important">
                                            {{ date('d-m-Y', strtotime($item->date)) }} </a></td>
                                    <td> <a href="{{ route('Purchases.details', $item->id) }}" class="text-reset !important"> {{ $item['suppliers']->name }}</a> </td>
                                    <td> <a href="{{ route('Purchases.details', $item->id) }}" class="text-reset !important"> {{ $item['categories']->category_name }}
                                        </a></td>
                                    <td> <a href="{{ route('Purchases.details', $item->id) }}" class="text-reset !important"> {{ $item->qte }} </a></td>
                                    <td> <a href="{{ route('Purchases.details', $item->id) }}" class="text-reset !important">
                                            {{ $item['products']->product_name }}</a> </td>
                                    <td>
                                        @if ($item->status == '0')
                                        <span class="btn btn-warning">{{ __('Pending') }}</span>
                                        @elseif($item->status == '1')
                                        <span class="btn btn-success">{{ __('Approved') }}</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($item->status == '0')
                                        <a href="{{ route('approve.purchase', $item->id) }}" class="btn btn-success sm" title="Approve Purchase" id="approve">
                                            <i class="fas fa-check-circle"></i> </a>
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