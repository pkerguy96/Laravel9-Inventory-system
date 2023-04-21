@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{ __('Add New Supplier') }} </h4><br><br>

                            <form method="post" action="{{ route('append.supplier') }}" id="myForm"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <label for="example-text-input"
                                        class="col-sm-2 col-form-label">{{ __('Supplier Name') }}</label>
                                    <div class="form-group col-sm-10">
                                        <input name="name" class="form-control" type="text">
                                    </div>
                                </div>
                                <!-- end row -->


                                <div class="row mb-3">
                                    <label for="example-text-input"
                                        class="col-sm-2 col-form-label">{{ __('Supplier Phone Number') }}</label>
                                    <div class="form-group col-sm-10">
                                        <input name="phone" class="form-control" type="text">
                                    </div>
                                </div>
                                <!-- end row -->



                                <div class="row mb-3">
                                    <label for="example-text-input"
                                        class="col-sm-2 col-form-label">{{ __('Supplier Email') }}</label>
                                    <div class="form-group col-sm-10">
                                        <input name="email" class="form-control" type="email">
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label for="example-text-input"
                                        class="col-sm-2 col-form-label">{{ __('Supplier Address') }}</label>
                                    <div class="form-group col-sm-10">
                                        <input name="address" class="form-control" type="text">
                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="row mb-3">
                                    <label for="example-text-input"
                                        class="col-sm-2 col-form-label">{{ __('Supplier Ice') }}</label>
                                    <div class="form-group col-sm-10">
                                        <input name="ice" class="form-control" type="text">
                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="row mb-3">
                                    <label for="formFile"
                                        class="col-sm-2 col-form-label">{{ __('Upload Suppliers by csv') }}</label>
                                    <div class="form-group col-sm-10">
                                        <input class="form-control" type="file" name="suppliers_csv" id="formFile">
                                    </div>
                                </div>

                                <input type="submit" class="btn btn-info waves-effect waves-light"
                                    value="{{ __('Add Supplier') }}">
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
                    name: {
                        required: true,
                    },
                    phone: {
                        required: true,
                    },
                    email: {
                        required: true,
                    },
                    address: {
                        required: true,
                    },
                    ice: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: "{{ __('Please Enter Supplier Name') }}",
                    },
                    phone: {
                        required: "{{ __('Please Enter Supplier Phone Number') }}",
                    },
                    email: {
                        required: "{{ __('Please Enter Supplier Email') }}",
                    },
                    address: {
                        required: "{{ __('Please Enter Supplier Address') }}",
                    },
                    ice: {
                        required: "{{ __('Please Enter Company Ice') }}",
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
                invalidHandler: function(event) {
                    if ($("#formFile").prop("files").length) event.target.submit();
                },
            });
        });
    </script>
@endsection
