@extends('admin.admin_master')
@section('admin')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{ __('Add New Product') }} </h4><br><br>

                            <form method="post" action="{{ route('append.product') }}" id="myForm">
                                @csrf
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="row mb-3">
                                    <label for="example-text-input"
                                        class="col-sm-2 col-form-label">{{ __('Product Name') }}</label>
                                    <div class="form-group col-sm-10">
                                        <input name="product_name" class="form-control" type="text">
                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="row mb-3">
                                    <label for="example-text-input"
                                        class="col-sm-2 col-form-label">{{ __('Reference Number') }}</label>
                                    <div class="form-group col-sm-10">
                                        <input name="ref_num" class="form-control" type="text">
                                    </div>
                                </div>

                                <!-- end row -->
                                <div class="row mb-3">
                                    <label for="example-number-input"
                                        class="col-sm-2 col-form-label">{{ __('Product Quantity') }}</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="number" value="1" id="example-number-input"
                                            name="product_qte">
                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">{{ __('Supplier Name') }}</label>
                                    <div class="col-sm-10">
                                        <select name="supplier_id" class="form-select " aria-label="Default select example">
                                            <option selected="">{{ __('Open this select menu') }}</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">{{ __('Brand Name') }}</label>
                                    <div class="col-sm-10">
                                        <select name="brand_id" class="form-select" aria-label="Default select example">
                                            <option selected="">{{ __('Open this select menu') }}</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}">{{ $brand->Brand_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">{{ __('Unit Name') }}</label>
                                    <div class="col-sm-10">
                                        <select name="unit_id" class="form-select" aria-label="Default select example">
                                            <option selected="">{{ __('Open this select menu') }}</option>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}">{{ $unit->unit_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">{{ __('Category Name') }}</label>
                                    <div class="col-sm-10">
                                        <select name="category_id" class="form-select" aria-label="Default select example">
                                            <option selected="">{{ __('Open this select menu') }}</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->category_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- end row -->


                                <input type="submit" class="btn btn-info waves-effect waves-light"
                                    value="{{ __('Add Product') }}">
                            </form>



                        </div>
                    </div>
                </div> <!-- end col -->
            </div>



        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    product_name: {
                        required: true,
                    },
                    supplier_id: {
                        required: true,
                    },
                    product_qte: {
                        required: true,
                    },
                    unit_id: {
                        required: true,
                    },
                    category_id: {
                        required: true,
                    },
                    brand_id: {
                        required: true,
                    },
                },
                messages: {
                    product_name: {
                        required: "{{ __('Please Enter Product Name') }}",
                    },
                    product_qte: {
                        required: "{{ __('Please Enter Product Quantity') }}",
                    },
                    supplier_id: {
                        required: "{{ __('Please Enter Product Supplier') }}",
                    },
                    unit_id: {
                        required: "{{ __('Please Enter A Product Unit') }}",
                    },
                    category_id: {
                        required: "{{ __('Please Enter A Product Category') }}",
                    },
                    brand_id: {
                        required: "{{ __('Please Enter A Product Brand') }}",
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });
    </script>

@endsection
