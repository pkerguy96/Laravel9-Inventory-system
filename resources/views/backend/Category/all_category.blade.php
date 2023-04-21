@extends('admin.admin_master')
@section('admin')


<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{ __("All Categories") }}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-row-reverse mb-md-3">
                            <a href="{{route('add.category')}}" class="btn btn-dark btn-rounded waves-effect waves-light"><i class="fas fa-plus-circle"><span class="d-none d-sm-inline">{{ __("Add New Category") }}</span></i></a>
                            <h4 class="card-title">{{ __("All Categories Data") }}</h4>
                        </div>
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th width="8%">N.B</th>
                                    <th>{{ __("Category Name") }}</th>
                                    <th width="15%">{{ __("Action") }}</th>

                            </thead>


                            <tbody>

                                @foreach($categories as $key => $item)
                                <tr>
                                    <td> {{ $key+1}} </td>
                                    <td> {{ $item->category_name }} </td>
                                    <td>
                                        <a href="{{ route('edit.category',$item->id) }}" class="btn btn-info sm" title="{{ __('Edit Data') }}"> <i class="fas fa-edit"></i> </a>

                                        <a href="{{route('delete.category',$item->id)}}" class="btn btn-danger sm" title="{{ __('Delete Data') }}" id="delete"> <i class="fas fa-trash-alt"></i> </a>

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