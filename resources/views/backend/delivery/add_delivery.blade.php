@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __("Add New Delivery Receipt") }} </h4><br><br>
                        <div class="row justify-content-center justify-content-md-center justify-content-sm-between gap-sm-3 gap-md-5 flex-wrap">
                            <div class="col-md-2 col-sm-12 mb-3 mb-sm-0">
                                <div class="md-3">
                                    <label for="example-text-input" class="form-label" style="white-space: nowrap;">{{ __("Receipt Number") }}</label>
                                    <input class="form-control" type="text" value="{{$delivery_no}}" name="delivery_no" id="delivery_no" readonly style="background-color: #ddd;">
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12 mb-3 mb-sm-0">
                                <div class="md-3">
                                    <label for="example-text-input" class="form-label">{{ __("Date") }}</label>
                                    <input class="form-control" type="date" value="{{$date}}" name="date" id="date">
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center  mt-2 mt-sm-1 mt-md-2 mt-lg-3 mt-xl-3 flex-wrap">
                            <!-- brand start -->
                            <div class=" col-md-3 col-sm-12">
                                <div class="mb-3">
                                    <label for="Brand_id" class="form-label">{{ __("Brand") }}</label>
                                    <select x-select placeholder="{{ __('Select Brand') }}" id="Brand_id" name="Brand_id" class="form-select" aria-label="Default select example">
                                        @foreach ($brands as $key )
                                        <option value="{{$key->id}}">{{$key->Brand_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- brand end -->
                            <div class="col-md-3 col-sm-12">
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">{{ __("Category") }}</label>
                                    <select x-select placeholder="{{ __('Select Category') }}" id="category_id" name="category_id" class="form-select" aria-label="Default select example">
                                        @foreach ($categories as $key )
                                        <option value="{{$key->id}}">{{$key->category_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="mb-3">
                                    <label for="product_id" class="form-label">{{ __("Product Name") }}</label>
                                    <select x-select placeholder="{{ __('Select Product') }}" id="product_id" name="product_id" class="form-select" aria-label="Default select example">
                                        <option selected="">Open this select menu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="mb-3">
                                    <label for="stock_qte" class="form-label">{{ __("Stock") }}</label>
                                    <input class="form-control" type="text" name="stock_qte" id="stock_qte" readonly style="background-color: #ddd;">
                                </div>
                            </div>
                        </div>
                        <div class="row float-end mt-0 ">
                            <div class="col-md-12">
                                <div class="md-3">
                                    <label for="example-text-input" class="form-label" style="margin-top: 32px;"></label>

                                    <i class="btn btn-info   btn-rounded waves-effect waves-light fas fa-plus-circle eeventmore">{{ __("Add More") }}</i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of card body -->
                    <div class="card-body">
                        <form action="{{route('store.delivery')}}" method="post" action="">
                            @csrf
                            <div class="table-responsive">
                                <table class="table-sm table-bordered" width="100%" style="border-color:#ddd ;">
                                    <thead>
                                        <tr>
                                            <th>{{ __("Brand") }}</th>
                                            <th>{{ __("Product Name") }}</th>
                                            <th>{{ __("Category") }}</th>
                                            <th width="7%">{{ __("Pieces") }}</th>
                                            <th width="10%">{{ __("Unit Price") }}</th>
                                            <th width="15%">{{ __("Total Price") }}</th>
                                            <th width="7%">{{ __("Action") }}</th>

                                        </tr>
                                    </thead>
                                    <tbody id="rowAdd" class="rowAdd">

                                    </tbody>

                                    <tbody id=" rowAdd" class="rowAdd">
                                        <tr>
                                            <td colspan="5" style="text-align: right;"><strong class="text-right">{{ __("Discount") }} </strong></td>
                                            <td>
                                                <input type="text" name="discount_amount" id="discount_amount" class="form-control" placeholder="Discount Amount">
                                            </td>
                                            <td></td>
                                        </tr>
                                    <tbody id=" rowAdd" class="rowAdd">
                                        <tr>
                                            <td colspan="5" style="text-align: right;"> <strong class="text-right">{{ __("Subtotal") }}</strong></td>

                                            <td>
                                                <input type="text" name="amount" value="0" id="amount" class="form-control amount" readonly style="background-color: #ddd;">
                                                <input type="hidden" name="amountrd" id="amountrd" class="amountrd">
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" style="text-align: right;">
                                                <strong class="text-right mr-sm-2">{{ __('Tax') }}</strong>
                                                <select name="tax_rate" class="btn btn-light dropdown-toggle" id="tax_rate">
                                                    <option value="20">20%</option>
                                                    <option value="7">7%</option>
                                                </select>
                                            </td>


                                            <td>
                                                <input type="text" name="tax" value="0" id="tax" class="form-control amount" readonly style="background-color: #ddd;">

                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" style="text-align: right;"><strong class="text-right">{{ __("Grand Total estimated amount") }}</strong></td>
                                            <td>
                                                <input type="text" name="Gtotal" value="0" id="Gtotal" class="form-control Gtotal" readonly style="background-color: #ddd;">
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" style="text-align: right;"><strong class="text-right">{{ __("Total Quantity") }}</strong></td>
                                            <td>
                                                <input type="text" name="Qtotal" value="0" id="Qtotal" class="form-control Gtotal" readonly style="background-color: #ddd;">
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table><br>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <textarea name="description" class="form-control" id="description" placeholder="{{ __('Enter description here') }}"></textarea>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="">{{ __("customer Name") }}</label>
                                    <select x-select placeholder="{{ __('Select Customer') }}" name="customer_id" id="customer_id" class="form-select">
                                        <option value="">{{ __("Select Customer") }}</option>
                                        @foreach ( $customers as $key)
                                        <option value="{{$key->id}}"> {{ $key->name  }} - {{ $key->email }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div><br>
                            <div class="form-group">
                                <button type="{{ __('submit') }}" class="btn btn-info" id="addButton">{{ __("Add Invoice") }}</button>
                            </div>
                        </form>

                    </div>
                    <!-- End of card body -->
                </div>
            </div> <!-- end col -->
        </div>
    </div>
</div>
<script id="document-template" type="text/x-handlebars-template">

    <tr class="delete_add_more_item" id="delete_row">
        <input type="hidden" name="date" value="@{{date}}">
        <input type="hidden" name="due_date" value="@{{due_date}}">
        <input type="hidden" name="delivery_no" value="@{{delivery_no}}">
        <td>
        <input type="hidden" name="brand_id[]" value="@{{brand_id}}">
        @{{ brand_name }}
        </td>
        <td>
        <input type="hidden" name="product_id[]" value="@{{product_id}}">
        @{{ product_name }}
        </td>
       
        
    
    <td>
        <input type="hidden" name="category_id[]" value="@{{category_id}}">
        @{{ category_name }}
    </td>

   

     <td>
        <input type="number" min="1" class="form-control qte text-right" name="qte[]" value=""> 
    </td>

    <td>
        <input type="number" class="form-control unit_price text-right" name="unit_price[]" value="" max=""> 
    </td>



     <td>
     <input type="hidden"  class="form-control unit_pricerd text-right" name="unit_pricerd[]" value=""> 
    
    <input type="hidden"  class="form-control selling_pricerd text-right" name="selling_pricerd[]" value=""> 
        <input type="text" class="form-control selling_price text-right" name="selling_price[]" value="0" readonly> 
    </td>
    
   
     <td>
        <i class="btn btn-danger btn-sm fas fa-window-close removedeletebtn"></i>
    </td>

    </tr>
 
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on("click", ".eeventmore", function() {
            var date = $('#date').val();
            var due_date = $('#due_date').val();
            var delivery_no = $('#delivery_no').val();
            var brand_id = $('#Brand_id').val();
            var brand_name = $('#Brand_id').find('option:selected').text();
            var category_id = $('#category_id').val();
            var category_name = $('#category_id').find('option:selected').text();
            var product_id = $('#product_id').val();
            var product_name = $('#product_id').find('option:selected').text();
            if (date == '') {
                $.notify("Date is Required", {
                    globalPosition: 'top right',
                    className: 'error'
                });
                return false;
            }

            if (category_id == '') {
                $.notify("Category is Required", {
                    globalPosition: 'top right',
                    className: 'error'
                });
                return false;
            }
            if (product_id == '') {
                $.notify("Product Field is Required", {
                    globalPosition: 'top right',
                    className: 'error'
                });
                return false;
            }
            var source = $("#document-template").html();
            var template = Handlebars.compile(source);
            var data = {
                date: date,
                due_date: due_date,
                delivery_no: delivery_no,
                brand_id: brand_id,
                brand_name: brand_name,
                category_id: category_id,
                category_name: category_name,
                product_id: product_id,
                product_name: product_name
            };
            var html = template(data);

            $("#rowAdd").append(html);
        });
        document.addEventListener('click', function(event) {
            if (event.target.matches('.removedeletebtn')) {
                event.target.closest('.delete_add_more_item').remove();
                totalAmountPrice();
            }
        });

        $(document).on('keyup click', '.unit_price, .qte', function() {
            var currentStock = document.getElementById('stock_qte').value;
            var $row = $(this).closest("tr");
            var unit_price = $row.find("input.unit_price").val();


            var buying_qte = $row.find("input.qte").val();
            $row.find("input.qte").attr("max", currentStock);
            var qte = parseInt($row.find('input.qte').val()) || 0;
            if (qte > currentStock) {
                // Set the qte value to current stock and trigger a change event to recalculate total qte
                $row.find('input.qte').val(currentStock).change();
            }
            totalqte();
            var total = unit_price * buying_qte;
            /* get data that would be sent to controller  */

            /* get data that would be sent to controller  */
            $row.find('.selling_pricerd').val(total);
            $row.find("input.selling_price").val(total.toLocaleString("en-US", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));
            $('#discount_amount').trigger('keyup');
        });
        $(document).on('keyup', '#discount_amount', function() {
            totalAmountPrice();
        });
        /* Quantity total */
        function totalqte() {
            var totalQte = 0;
            var $qtotal = $('#Qtotal');
            $('.qte').each(function() {
                // add the value of each qte input to the total
                totalQte += parseInt($(this).val()) || 0;
            });
            // set the total qte to the qtotal input 
            $qtotal.val(totalQte);
        }
        document.getElementById('tax_rate').addEventListener('change', function() {
            totalAmountPrice()
        });

        function taxRate(subtotal, selecttaxRate) {
            let taxRate = parseFloat(selecttaxRate);

            if (taxRate == 7) return 0.07 * subtotal;
            if (taxRate == 20) return 0.20 * subtotal;
        }
        /* calculater total */
        function totalAmountPrice() {
            var sum = 0;
            $(".selling_price").each(function() {
                var value = +$(this).val().replaceAll(",", "");
                if (!isNaN(value) && value.length != 0) {
                    sum += parseFloat(value);
                }
            });
            var discount = $('#discount_amount').val();
            if (!isNaN(discount) && discount.length != 0) {
                if (parseFloat(discount) >= sum) {
                    sum = 0;
                } else {
                    sum -= parseFloat(discount);
                }
            }
            $('#amountrd').val(sum);
            $('#amount').val(sum.toLocaleString("en-US", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            })); // round subtotal to 2 decimal places

            // Calculate tax amount as 20% of subtotal
            var taxRateValue = $('#tax_rate').val();
            var onlytax = taxRate(sum, taxRateValue);
            $('#tax').val(onlytax.toLocaleString("en-US", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            })); // round tax to 2 decimal places

            var Gtotal = parseFloat(onlytax + sum);
            $('#Gtotal').val(Gtotal.toLocaleString("en-US", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            })); // round grand total to 2 decimal places
        }


    });
</script>
<script type="text/javascript">
    document.getElementById('category_id').addEventListener('select', function() {
        var category_id = this.value;
        fetch(`{{ route('fetch-product') }}?category_id=${category_id}`, {
                method: "GET",
            })
            .then(response => response.json())
            .then(data => {
                let html = '';
                data.forEach(function(v) {
                    html += `<option value="${v.id}"> ${v.product_name} </option>`;
                });
                document.getElementById('product_id').innerHTML = html;
            })
            .catch(error => console.log(error));
    });
    /* added */
    var default_category_id = document.getElementById('category_id').value;
    fetch(`{{ route('fetch-product') }}?category_id=${default_category_id}`, {
            method: "GET",
        })
        .then(response => response.json())
        .then(data => {
            let html = '';
            data.forEach(function(v) {
                html += `<option value="${v.id}"> ${v.product_name} </option>`;
            });
            document.getElementById('product_id').innerHTML = html;
        })
        .catch(error => console.log(error));
</script>
<script type="text/javascript">
    document.getElementById('product_id').addEventListener('select', function() {
        var product_id = this.value;
        fetch(`{{ route('get-product-info') }}?product_id=${product_id}`, {
                method: "GET",
            })
            .then(response => response.json())
            .then(data => {

                document.getElementById('stock_qte').value = data;
            })
            .catch(error => console.log(error));
    });
</script>
<script type="text/javascript">
    document.getElementById('customer_id').addEventListener('select', function() {
        var customer_id = this.value;
        fetch(`{{ route('get-customer-delivery-receipt') }}?customer_id=${customer_id}`, {
                method: "GET",
            })
            .then(response => response.json())
            .then(data => {
                let html = '<option value="">No delivery receipts</option>';
                if (data.length > 0) {
                    html = '';
                    data.forEach(function(v) {
                        html += `<option value="${v.id}"> ${v.delivery_no} </option>`;
                    });
                }
                document.getElementById('delivery_id').innerHTML = html;
            })
            .catch(error => console.log(error));
    });
</script>
<script type="text/javascript">
    $(document).on('change', '#pay_status', function() {
        var payement_status = $(this).val();
        if (payement_status == 'partial_paid') {
            $('.paid_amount').show();
        } else {
            $('.paid_amount').hide();
        }
    });

    $(document).on('change', '#customer_id', function() {
        var customer_id = $(this).val();
        if (customer_id == '0') {
            $('.new_customer').show();
        } else {
            $('.new_customer').hide();
        }
    });
</script>


@endsection