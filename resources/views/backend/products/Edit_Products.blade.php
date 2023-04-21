@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{ 'Edit Product' }} </h4><br><br>

                            <form method="post" action="{{ route('modify.product') }}" id="myForm">
                                @csrf
                                <input type="hidden" name="productid" value="{{ $productinfo->id }}">
                                <div class="row mb-3">
                                    <label for="example-text-input"
                                        class="col-sm-2 col-form-label">{{ 'Product Name' }}</label>
                                    <div class="form-group col-sm-10">
                                        <input name="product_name" class="form-control"
                                            value="{{ $productinfo->product_name }}" type="text">
                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="row mb-3">
                                    <label for="example-text-input"
                                        class="col-sm-2 col-form-label">{{ 'Reference Number' }}</label>
                                    <div class="form-group col-sm-10">
                                        <input name="ref_num" class="form-control" type="text"
                                            value="{{ $productinfo->ref_num }}">
                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="row mb-3">
                                    <label for="example-number-input"
                                        class="col-sm-2 col-form-label">{{ 'Product Quantity' }}</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="number" value="{{ $productinfo->product_qte }}"
                                            id="example-number-input" name="product_qte">
                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">{{ 'Supplier Name' }}</label>
                                    <div class="col-sm-10">
                                        <select name="supplier_id" class="form-select" aria-label="Default select example">
                                            <option selected="">{{ 'Open this select menu' }}</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}"
                                                    {{ $supplier->id == $productinfo->supplier_id ? 'selected' : '' }}>
                                                    {{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">{{ 'Unit Name' }}</label>
                                    <div class="col-sm-10">
                                        <select name="unit_id" class="form-select" aria-label="Default select example">
                                            <option selected="">{{ 'Open this select menu' }}</option>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}"
                                                    {{ $unit->id == $productinfo->unit_id ? 'selected' : '' }}>
                                                    {{ $unit->unit_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">{{ 'Category Name' }}</label>
                                    <div class="col-sm-10">
                                        <select name="category_id" class="form-select" aria-label="Default select example">
                                            <option selected="">{{ 'Open this select menu' }}</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $category->id == $productinfo->category_id ? 'selected' : '' }}>
                                                    {{ $category->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- end row -->


                                <input type="submit" class="btn btn-info waves-effect waves-light"
                                    value="{{ 'Edit Product' }}">
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
