@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('Add New Purchase') }} </h4><br><br>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="md-3">
                                    <label for="example-text-input" class="form-label">{{ __('Date') }}</label>
                                    <input class="form-control" type="date" name="date" id="date">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="md-3">
                                    <label for="example-text-input" class="form-label">{{ __('Purchase Number') }}</label>
                                    <input class="form-control" type="text" name="purchase_no" id="purchase_no">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="md-3">
                                    <label for="example-text-input" class="form-label">{{ __('Supplier Name') }}</label>
                                    <select x-select placeholder="{{ __('Select Supplier') }}" id="supplier_id" name="supplier_id" class="form-select  " aria-label="Default select example">
                                        @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 1%;">
                            <div class="col-md-4">
                                <div class="md-3">
                                    <label for="example-text-input" class="form-label">{{ __('Brand Name') }}</label>
                                    <select x-select placeholder="{{ __('Select Brand') }}" id="brand_id" name="brand_id" class="form-select  " aria-label="Default select example">
                                        @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->Brand_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="md-3">
                                    <label for="example-text-input" class="form-label">{{ __('Category') }}</label>
                                    <select x-select placeholder="{{ __('Select Category') }}" id="category_id" name="category_id" class="form-select " aria-label="Default select example">
                                        <option selected="">{{ __('Open this select menu') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="md-3">
                                    <label for="example-text-input" class="form-label">{{ __('Product Name') }}</label>
                                    <select x-select placeholder="{{ __('Select Product') }}" id="product_id" name="product_id" class="form-select" aria-label="Default select example">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="md-3">
                                    <label for="example-text-input" class="form-label" style="margin-top: 32px;"></label>
                                    <i class="btn btn-info btn-rounded waves-effect waves-light fas fa-plus-circle eeventmore float-right">
                                        {{ __('Add More') }}</i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of card body -->
                    <div class="card-body">
                        <form action="{{ route('store.purchase') }}" method="post" action="">
                            @csrf
                            <table class="table-sm table-bordered" width="100%" style="border-color:#ddd ;">
                                <thead>
                                    <tr>
                                        <th>{{ __('Brand Name') }}</th>
                                        <th>{{ __('Product Name') }}</th>
                                        <th>{{ __('Category') }}</th>
                                        <th>{{ __('Pieces') }}</th>
                                        <th>{{ __('Unit Price') }}</th>

                                        <th>{{ __('Total Price') }}</th>

                                        <th>{{ __('Action') }}</th>

                                    </tr>
                                </thead>
                                <tbody id="rowAdd" class="rowAdd">

                                </tbody>
                                <tbody id="rowAdd" class="rowAdd">
                                    <tr>
                                        <td colspan="5" style="text-align: right;"> <strong class="text-right">{{ __('Subtotal') }}</strong></td>

                                        <td>
                                            <input type="text" name="amount" value="0" id="amount" class="form-control amount" readonly style="background-color: #ddd;">
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
                                        <td colspan="5" style="text-align: right;">
                                            <strong>{{ __('Grand Total') }}</strong>
                                        </td>


                                        <td>

                                            <input type="text" name="Gtotal" value="0" id="Gtotal" class="form-control amount" readonly style="background-color: #ddd;">
                                        </td>
                                    </tr>
                                </tbody>
                            </table><br>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <textarea name="description" class="form-control" id="description" placeholder="{{ __('Enter description here') }}"></textarea>
                                </div>
                            </div><br>
                            <div class="form-group">
                                <button type="submit" class="btn btn-info" id="addButton">{{ __('Add Purchase') }}</button>
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
        <input type="hidden" name="purchase_no" value="@{{purchase_no}}">
        <input type="hidden" name="supplier_id[]" value="@{{supplier_id}}">
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
        <input type="number" min="1" class="form-control buying_qty text-right" name="buying_qty[]" value=""> 
    </td>

    <td>
        <input type="number" step="0.5" class="form-control unit_price text-right" name="unit_price[]" value=""> 
    </td>

 

     <td>
 
    
    <input type="hidden"  class="form-control buying_pricerd text-right" name="buying_pricerd[]" value=""> 
        <input type="number" class="form-control buying_price text-right"  name="buying_price[]" value="0" readonly> 
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
            var purchase_no = $('#purchase_no').val();
            var supplier_id = $('#supplier_id').val();
            var category_id = $('#category_id').val();
            var category_name = $('#category_id').find('option:selected').text();
            var brand_id = $('#brand_id').val();
            var brand_name = $('#brand_id').find('option:selected').text();

            var product_id = $('#product_id').val();
            var product_name = $('#product_id').find('option:selected').text();
            if (date == '') {
                $.notify("Date is Required", {
                    globalPosition: 'top right',
                    className: 'error'
                });
                return false;
            }
            if (purchase_no == '') {
                $.notify("Purchase No is Required", {
                    globalPosition: 'top right',
                    className: 'error'
                });
                return false;
            }
            if (supplier_id == '') {
                $.notify("Supplier is Required", {
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
            var tamplate = Handlebars.compile(source);
            var data = {
                date: date,
                purchase_no: purchase_no,
                brand_id: brand_id,
                brand_name: brand_name,
                supplier_id: supplier_id,
                category_id: category_id,
                category_name: category_name,
                product_id: product_id,
                product_name: product_name
            };
            var html = tamplate(data);

            $("#rowAdd").append(html);
        });
        document.addEventListener('click', function(event) {
            if (event.target.matches('.removedeletebtn')) {
                event.target.closest('.delete_add_more_item').remove();
                totalAmountPrice();
            }
        });
        /* calculate unit * buyingp rice  the unit dosnt update*/
        $(document).on('keyup click', '.unit_price, .buying_qty', function() {
            var $row = $(this).closest("tr");
            var unit_price = $row.find("input.unit_price").val();
            var buying_qte = $row.find("input.buying_qty").val();
            var total = unit_price * buying_qte;
            $row.find('.buying_pricerd').val(total);
            $row.find("input.buying_price").val(total.toFixed(2));
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


        function totalAmountPrice() {
            var sum = 0;
            $(".buying_price").each(function() {
                var value = +$(this).val().replaceAll(",", "");
                if (!isNaN(value) && value.length != 0) {
                    sum += parseFloat(value);
                    console.log(sum);
                }
            });
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
    document.getElementById('brand_id').addEventListener('select', function() {
        var brand_id = this.value;
        console.log("brand id", brand_id);
        fetch(`{{ route('fetch-category') }}?brand_id=${brand_id}`, {
                method: "GET",
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                let html = '66';
                data.forEach(function(v) {
                    html +=
                        `<option value="${v.category_id}"> ${v.categories.category_name} </option>`;
                });
                document.getElementById('category_id').innerHTML = html;
            })
            .catch(error => console.log(error));
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

@endsection