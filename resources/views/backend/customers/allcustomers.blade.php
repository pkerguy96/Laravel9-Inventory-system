@extends('admin.admin_master')
@section('admin')


<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{ __("All Customers") }}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-row-reverse mb-md-3">
                            <a href="{{route('add.customer')}}" class="btn btn-dark btn-rounded waves-effect waves-light"><i class="fas fa-plus-circle"> <span class="d-none d-sm-inline">{{ __("Add Customer") }}</span> </i></a>
                            <h4 class="card-title">{{ __("All Customers Data") }} </h4>
                        </div>
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>{{ __("Name") }}</th>
                                    <th>{{ __("Phone Number") }}</th>
                                    <th>{{ __("Email") }}</th>
                                    <th>{{ __("Address") }}</th>
                                    <th>{{ __("Ice") }}</th>
                                    <th>{{ __("Action") }}</th>

                            </thead>


                            <tbody>

                                @foreach($customers as $key => $item)
                                <tr>
                                    <td> {{ $key+1}} </td>
                                    <td> {{ $item->name }} </td>
                                    <td> {{ $item->phone }} </td>
                                    <td> {{ $item->email }} </td>
                                    <td> {{ $item->address }} </td>
                                    <td> {{ $item->ice ?? 'N/A' }} </td>


                                    <td>
                                        <a href="{{ route('edit.customer',$item->id) }}" class="btn btn-info sm" title="{{ __('Edit Data') }}"> <i class="fas fa-edit"></i> </a>

                                        <a href="{{route('delete.customer',$item->id)}}" class="btn btn-danger sm" title="{{ __('Delete Data') }}" id="delete"> <i class="fas fa-trash-alt"></i> </a>

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