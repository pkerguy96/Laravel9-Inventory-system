@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{ __("Customers Wise Report") }}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <strong>{{ __("Customer Credit Report") }}</strong>
                                <input type="radio" name="customers_report" value='customer_true' class="search_value">&nbsp;&nbsp;
                                <strong>{{ __("Customer Payment Report") }}</strong>
                                <input type="radio" name="customers_report" value='payment_true' class="search_value">
                            </div>
                        </div>
                        <div class="customer_list" style="display: none;">
                            <form action="{{route('customers.wise.credit.report')}}" method="GET" id="promform" target="_blank">
                                <div class="row">
                                    <div class="col-sm-8 form-group">
                                        <label for="">{{ __("Customer Name") }}</label>
                                        <select name="customer_id" class="form-select" aria-label="Default select example">
                                            <option value="">{{ __("Open this select menu") }}</option>
                                            @foreach ( $customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-4" style="padding-top: 22px;">
                                        <button type="{{ __('submit') }}" class="btn btn-primary">{{ __("Search") }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="payment_list" style="display: none;">
                            <form action="{{route('customers.wise.payement.report')}}" method="GET" id="promform" target="_blank">
                                <div class="row">
                                    <div class="col-sm-8 form-group">
                                        <label for="">{{ __("Customer Name") }}</label>
                                        <select name="customer_id" class="form-select" aria-label="Default select example">
                                            <option value="">{{ __("Open this select menu") }}</option>
                                            @foreach ( $customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-4" style="padding-top: 22px;">
                                        <button type="{{ __('submit') }}" class="btn btn-primary">{{ __("Search") }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->



        </div> <!-- container-fluid -->
    </div>

    <script type="text/javascript">
        $(document).on('change', '.search_value', function() {
            var search_value = $(this).val();
            if (search_value == 'customer_true') {
                $('.customer_list').show();
            } else {
                $('.customer_list').hide();
            }
        });
    </script>
    <script type="text/javascript">
        $(document).on('change', '.search_value', function() {
            var search_value = $(this).val();
            if (search_value == 'payment_true') {
                $('.payment_list').show();
            } else {
                $('.payment_list').hide();
            }
        });
    </script>

    @endsection