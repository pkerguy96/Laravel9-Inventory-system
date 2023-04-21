@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __("Modify Customer") }} </h4><br><br>
                        <form method="post" action="{{ route('modify.customer') }}" id="myForm">
                            @csrf
                            <input type="hidden" value="{{$customerinfo->id}}" name="supplierId">
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">{{ __("Customer Name") }}</label>
                                <div class="form-group col-sm-10">
                                    <input name="name" class="form-control" type="text" value="{{$customerinfo->name}}">
                                </div>
                            </div>
                            <!-- end row -->


                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">{{ __("Customer Phone Number") }}</label>
                                <div class="form-group col-sm-10">
                                    <input name="phone" class="form-control" type="text" value="{{$customerinfo->phone}}">
                                </div>
                            </div>
                            <!-- end row -->



                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">{{ __("Customer Email") }}</label>
                                <div class="form-group col-sm-10">
                                    <input name="email" class="form-control" type="email" value="{{$customerinfo->email}}">
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">{{ __("Customer Address") }}</label>
                                <div class="form-group col-sm-10">
                                    <input name="address" class="form-control" type="text" value="{{$customerinfo->address}}">
                                </div>
                            </div>
                            <!-- end row -->


                            <input type="submit" class="btn btn-info waves-effect waves-light" value="{{ __('Modify Customer') }}">
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
            },
            messages: {
                name: {
                    required: '{{ __("Please Enter customer Name") }}',
                },
                phone: {
                    required: '{{ __("Please Enter customer Phone Number") }}',
                },
                email: {
                    required: '{{ __("Please Enter customer Email") }}',
                },
                address: {
                    required: '{{ __("Please Enter customer Address") }}',
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