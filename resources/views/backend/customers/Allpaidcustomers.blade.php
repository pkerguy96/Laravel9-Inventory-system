@extends('admin.admin_master')
@section('admin')


<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{ __("All Paid Customers") }}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-row-reverse mb-md-3">
                            <a href="{{route('print.paid.customers')}}" class="btn btn-dark btn-rounded waves-effect waves-light"><i class="fas fa-print"> <span class="d-none d-sm-inline">{{ __("Print Paid Customers") }}</span> </i></a>
                            <h4 class="card-title">{{ __("All Paid Customers") }} </h4>
                        </div>
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>{{ __("Invoice Number") }}</th>
                                    <th>{{ __("Date") }}</th>
                                    <th>{{ __("Name") }}</th>
                                    <th>{{ __("Phone Number") }}</th>
                                    <th>{{ __("Email") }}</th>
                                    <th>{{ __("Due Amount") }}</th>
                                    <th>{{ __("Action") }}</th>

                            </thead>


                            <tbody>

                                @foreach($data as $key => $item)
                                <tr>
                                    <td> {{ $key+1}} </td>
                                    <td> {{ $item['invoices']['invoice_no'] }} </td>
                                    <td> {{ date('d-m-y',strtotime($item['invoices']['date'])) }} </td>
                                    <td> {{ $item['customers']['name'] }} </td>
                                    <td> {{ $item['customers']['phone']  }} </td>
                                    <td> {{ $item['customers']['email']  }} </td>
                                    <td> {{ $item->due_amount }} </td>


                                    <td>
                                        <a href="{{ route('customer.invoices.detail',$item->invoice_id) }}" class="btn btn-info sm" title="{{ __('Customer Details') }}" target="_bla
                                        "> <i class="fas fa-eye"></i> </a>



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