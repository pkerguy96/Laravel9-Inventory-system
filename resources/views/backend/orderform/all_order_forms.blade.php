@extends('admin.admin_master')
@section('admin')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{ __('All Order Forms') }}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-row-reverse mb-md-3">
                            <a href="{{ route('add.order.form') }}" class="btn btn-dark btn-rounded waves-effect waves-light"><i class="fas fa-plus-circle"> <span class="d-none d-sm-inline">{{ __('Add Order Form') }} </span> </i></a> <br>
                            <h4 class="card-title">{{ __('All Order Forms Data') }} </h4>
                        </div>
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>{{ __('Sl') }}</th>
                                    <th>{{ __('Order Form Number') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Total Quantity') }}</th>
                                    <th>{{ __('Action') }}</th>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><a href="{{ route('order.form.details', $item->id) }}" class="text-reset !important">{{ $item->orderform_no }}</a></td>
                                    <td><a href="{{ route('order.form.details', $item->id) }}" class="text-reset !important">{{ date('d-m-Y', strtotime($item->date)) }}</a>
                                    </td>
                                    <td><a href="{{ route('order.form.details', $item->id) }}" class="text-reset !important">{{ $item->total_qte }}</a></td>
                                    <td>
                                        <a href="{{ route('delete.quotation', $item->id) }}" class="btn btn-danger sm" title="Delete Data" id="delete"> <i class="fas fa-trash-alt"></i> </a>
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