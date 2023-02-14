@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Search Purchases Report</h4><br><br>


                        <form method="GET" action="{{route('search.date.purchases')}}" id="promedform" target="_blank">
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="md-3 form-group">
                                        <label for="example-text-input" class="form-label"> Start Date</label>
                                        <input class="form-control" type="date" name="startdate" id="startdate" placeholder="YY-MM-DD">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="md-3 form-group">
                                        <label for="example-text-input" class="form-label"> End Date</label>
                                        <input class="form-control" type="date" name="enddate" id="enddate" placeholder="YY-MM-DD">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="md-3 ">
                                        <label for="example-text-input" class="form-label" style="margin-top: 32px;"></label>
                                        <button type="submit" class="btn btn-info">Search</button>
                                    </div>
                                </div>


                            </div>

                        </form>
                    </div>
                    <!-- End of card body -->

                </div>
            </div> <!-- end col -->
        </div>



    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#promedform').validate({
            rules: {
                startdate: {
                    required: true,
                },
                enddate: {
                    required: true,
                },

            },
            messages: {
                startdate: {
                    required: 'Please Select A Start Date',
                },
                enddate: {
                    required: 'Please Select An End Date',
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