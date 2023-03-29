@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit Admin </h4><br><br>
                        <form method="post" action="{{ route('modify.admin') }}" id="myForm">
                            @csrf
                            <input type="hidden" value="{{$data->id}}" name="adminid">
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Admin Name</label>
                                <div class="form-group col-sm-10">
                                    <input name="name" class="form-control" type="text" value="{{$data->name}}">
                                </div>
                            </div>
                            <!-- end row -->


                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Admin Username</label>
                                <div class="form-group col-sm-10">
                                    <input name="username" class="form-control" type="text" value="{{$data->username}}">
                                </div>
                            </div>
                            <!-- end row -->



                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Admin Email</label>
                                <div class="form-group col-sm-10">
                                    <input name="email" class="form-control" type="email" value="{{$data->email}}">
                                </div>
                            </div>
                            <!-- end row -->
                            <div class="row  mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Admin Role</label>
                                <div class="col-sm-10">
                                    <select name="role" id="role" class="form-select col-md-6">

                                        <option value="" disabled>Select A Role:</option>
                                        <option value="none" {{ $data->roles->isEmpty() ? 'selected' : '' }}>No Role</option>
                                        @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" {{ $data->hasRole($role->name) ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                        @endforeach


                                    </select>
                                </div>
                            </div>



                            <input type="submit" class="btn btn-info waves-effect waves-light" value="Modify Admin">
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
                username: {
                    required: true,
                },
                email: {
                    required: true,
                },

            },
            messages: {
                name: {
                    required: 'Please enter admin Name',
                },
                username: {
                    required: 'Please enter an username',
                },
                email: {
                    required: 'Please Enter admin Email',
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