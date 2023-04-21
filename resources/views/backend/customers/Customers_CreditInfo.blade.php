@extends('admin.admin_master')
@section('admin')


<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{ __("All Customers Credit Status") }}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-row-reverse mb-md-3">
                            <a href="{{route('customer.pdf.print')}}" class="btn btn-dark btn-rounded waves-effect waves-light" target="_blank"><i class="fas fa-plus-circle"> <span class="d-none d-sm-inline">{{ __("Print Customers Credit") }}</span> </i></a>
                            <h4 class="card-title">{{ __("All Customers Credit") }} </h4>
                        </div>
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>{{ __("Customer Name") }}</th>
                                    <th>{{ __("Invoice Number") }}</th>
                                    <th>{{ __("Date") }}</th>
                                    <th>{{ __("Due Amount") }}</th>
                                    <th>{{ __("Action") }}</th>

                            </thead>


                            <tbody>

                                @foreach($data as $key => $item)
                                <tr>
                                    <td> {{ $key+1}} </td>
                                    <td> {{ $item['customers']['name'] }} </td>
                                    <td> {{ $item['Invoices']['invoice_no'] }} </td>
                                    <td> {{ date('d-m-Y',strtotime( $item['Invoices']['date'] ))}} </td>
                                    <td> {{ $item->due_amount }} </td>


                                    <td>
                                        <a href="{{ route('edit.customer.invoice',$item->invoice_id) }}" class="btn btn-info sm" title="{{ __('Edit Data') }}"> <i class="fas fa-edit"></i> </a>

                                        <a href="{{route('customer.invoices.detail',$item->invoice_id)}}" class="btn btn-danger sm" title="{{ __('Customers Invoice Details') }}" target="_blank"> <i class="fas fa-eye"></i> </a>

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