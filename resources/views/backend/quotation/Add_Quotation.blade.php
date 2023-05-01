@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<style>
    @media screen and (max-width: 928) {
        .eeventmore {
            width: 300px;
            margin-top: 5px;
        }
    }
</style>
<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('Add New Quotation') }} </h4><br><br>



                        <div class="row justify-content-center justify-content-md-center justify-content-sm-between gap-sm-3 gap-md-5 flex-wrap">
                            <div class="col-md-2 col-sm-12 mb-3 mb-sm-0">
                                <div class="md-3">
                                    <label for="example-text-input" class="form-label" style="white-space: nowrap;">{{ __('Quotation Number') }}</label>
                                    <input class="form-control" type="text" value="{{ $quotation_no }}" name="quotation_no" id="quotation_no" readonly style="background-color: #ddd;">
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12 mb-3 mb-sm-0">
                                <div class="md-3">
                                    <label for="example-text-input" class="form-label">{{ __('Date') }}</label>
                                    <input class="form-control lowl " type="date" value="{{ $date }}" name="date" id="date">
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="md-3">
                                    <label for="example-text-input" class="form-label">{{ __('Due Date') }}</label>
                                    <input class="form-control tani" type="date" value="{{ $date }}" name="due_date" id="due_date">
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center  mt-2 mt-sm-1 mt-md-2 mt-lg-3 mt-xl-3 flex-wrap">
                            <!-- brand start -->
                            <div class=" col-md-3 col-sm-12">
                                <div class="mb-3">
                                    <label for="Brand_id" class="form-label">{{ __('Brand') }}</label>
                                    <select id="Brand_id" name="Brand_id" class="form-select" aria-label="Default select example">
                                        @foreach ($brands as $key)
                                        <option value="{{ $key->id }}">{{ $key->Brand_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- brand end -->
                            <div class="col-md-3 col-sm-12">
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">{{ __('Category') }}</label>
                                    <select id="category_id" name="category_id" class="form-select" aria-label="Default select example">
                                        @foreach ($categories as $key)
                                        <option value="{{ $key->id }}">{{ $key->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-12">
                                <div class="mb-3">
                                    <label for="product_id" class="form-label">{{ __('Product Name') }}</label>
                                    <select id="product_id" name="product_id" class="form-select" aria-label="Default select example">
                                        <option selected="">{{ __('Open this select menu') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="mb-3">
                                    <label for="stock_qte" class="form-label">{{ __('Stock') }}</label>
                                    <input class="form-control" type="text" name="stock_qte" id="stock_qte" readonly style="background-color: #ddd;">
                                </div>
                            </div>
                        </div>

                        <div class="row float-end mt-0 ">


                            <div class="col-md-12">
                                <div class="md-3">
                                    <label for="example-text-input" class="form-label" style="margin-top: 32px;"></label>

                                    <i class="btn btn-info   btn-rounded waves-effect waves-light fas fa-plus-circle eeventmore">
                                        {{ __('Add More') }}</i>
                                </div>
                            </div>

                        </div>


                    </div>
                    <!-- End of card body -->
                    <div class="card-body">
                        <form action="{{ route('store.quotation') }}" method="post" action="">
                            @csrf
                            <div class="table-responsive">
                                <table class="table-sm table-bordered" width="100%" style="border-color:#ddd ;">
                                    <thead>
                                        <tr class="text-center">
                                            <th>{{ __('Brand') }}</th>
                                            <th>{{ __('Product Name') }}</th>
                                            <th>{{ __('Category') }}</th>
                                            <th width="7%">{{ __('Pieces') }}</th>
                                            <th width="10%">{{ __('Unit Price') }}</th>
                                            <th width="15%">{{ __('Total Price') }}</th>
                                            <th width="7%">{{ __('Action') }}</th>

                                        </tr>
                                    </thead>
                                    <tbody id="rowAdd" class="rowAdd">

                                    </tbody>
                                    <tr>
                                        <td colspan="5" style="text-align: right;"><strong class="text-right">{{ __('Discount') }} </strong></td>
                                        <td>
                                            <input type="text" name="discount_amount" id="discount_amount" class="form-control" placeholder="{{ __('Discount Amount') }}">
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tbody id=" rowAdd" class="rowAdd">
                                        <tr>
                                            <td colspan="5" style="text-align: right;"> <strong class="text-right">{{ __('Subtotal') }}</strong></td>

                                            <td>
                                                <input type="text" name="amount" value="0" id="amount" class="form-control amount" readonly style="background-color: #ddd;">
                                                <input type="hidden" name="amountrd" id="amountrd" class="amountrd">
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" style="text-align: right;">
                                                <strong class="text-right">{{ __('Tax') }}</strong>
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
                                            <td colspan="5" style="text-align: right;"><strong class="text-right">{{ __('Grand Total estimated amount') }}</strong>
                                            </td>
                                            <td>
                                                <input type="text" name="Gtotal" value="0" id="Gtotal" class="form-control Gtotal" readonly style="background-color: #ddd;">
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
                                <div class="form-group col-md-12">
                                    <label for="">{{ __('Payement Status') }}</label>
                                    <div class="form-group col-sm-12">
                                        <input name="payement_status" class="form-control" type="text">
                                    </div>
                                </div>



                            </div><br>

                            <div class="form-group">
                                <button type="submit" class="btn btn-info" id="addButton">{{ __('Add Quotation') }}</button>
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
        <input type="hidden" name="quotation_no" value="@{{quotation_no}}">
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
            var quotation_no = $('#quotation_no').val();
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
                quotation_no: quotation_no,
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
            var total = unit_price * buying_qte;

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
            if (onlytax !== undefined && onlytax !== null) {
                $('#tax').val(onlytax.toLocaleString("en-US", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }));
            }
            var Gtotal = parseFloat(onlytax + sum);
            $('#Gtotal').val(Gtotal.toLocaleString("en-US", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            })); // round grand total to 2 decimal places
        }


    });
</script>
<script type="text/javascript">
    document.getElementById('category_id').addEventListener('change', function() {
        var category_id = this.value;
        fetch(`{{ route('fetch-product') }}?category_id=${category_id}`, {
                method: "GET",
            })
            .then(response => response.json())
            .then(data => {
                let html = '<option value="">Select Category</option>';
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
            let html = '<option value="">Select Category</option>';
            data.forEach(function(v) {
                html += `<option value="${v.id}"> ${v.product_name} </option>`;
            });
            document.getElementById('product_id').innerHTML = html;
        })
        .catch(error => console.log(error));
</script>
<script type="text/javascript">
    document.getElementById('product_id').addEventListener('change', function() {
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
    const dateInput = document.querySelector('.lowl');
    const dueDateInput = document.querySelector('.tani');

    dueDateInput.addEventListener('change', () => {
        const date = new Date(dateInput.value);
        const dueDate = new Date(dueDateInput.value);
        if (dueDate < date) {
            toastr.error('Due date cannot be earlier than the selected date');
            dueDateInput.value = dateInput.value;
        }
    });
</script>
@endsection