@extends('admin.admin_master')
@section('admin')


<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{ __("All Invoices") }}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-row-reverse mb-md-3">
                            <a href="{{route('add.invoice')}}" class="btn btn-dark btn-rounded waves-effect waves-light"><i class="fas fa-plus-circle"><span class="d-none d-sm-inline">{{ __("Add Invoice") }}</span></i></a>
                            <h4 class="card-title">{{ __("All Invoices Data") }} </h4>
                        </div>
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>{{ __("Invoice Number") }}</th>
                                        <th>{{ __("Customer Name") }}</th>
                                        <th>{{ __("Date") }}</th>
                                        <th>{{ __("Description") }}</th>
                                        <th>{{ __("Total Amount") }}</th>
                                        <th>{{ __("Status") }}</th>
                                        <th>{{ __("Action") }}</th>
                                </thead>

                                <tbody>

                                    @foreach($allinvoices as $key => $item)
                                    <tr>
                                        <td> {{ $key+1}} </td>
                                        <td> {{ $item->invoice_no }} </td>
                                        <td> {{ $item['payements']['customers']['name'] }} </td>
                                        <td> {{ date('d-m-Y',strtotime($item->date))}} </td>
                                        <td> {{ $item->description}} </td>
                                        <td> {{ number_format(  $item['payements']['total_amount'], 2, '.', ',') }} MAD</td>
                                        <td> @if($item->status == '0' )
                                            <span class="btn btn-warning">Pending</span>
                                            @elseif($item->status == '1')
                                            <span class="btn btn-success">Approved</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->status == '0' )
                                            <a href="{{route('Approve.invoice',$item->id)}}" class="btn btn-success waves-effect waves-light" title="{{ __('Approve Data') }}"> <i class="fas fa-check-circle"></i> </a>
                                            <a href="{{route('delete.invoice',$item->id)}}" class="btn btn-danger sm" title="{{ __('Delete Data') }}" id="delete"> <i class="fas fa-trash-alt"></i> </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->



    </div> <!-- container-fluid -->
</div>


@endsection