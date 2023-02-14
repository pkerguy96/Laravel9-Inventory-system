@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add New Invoice </h4><br><br>



                        <div class="row">
                            <div class="col-md-1" style="width:10%;">
                                <div class="md-3">
                                    <label for="example-text-input" class="form-label">Invoice Number</label>
                                    <input class="form-control" type="text" value="{{$invoice_no}}" name="invoice_no" id="invoice_no" readonly style="background-color: #ddd;">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="md-3">
                                    <label for="example-text-input" class="form-label">Date</label>
                                    <input class="form-control" type="date" value="{{$date}}" name="date" id="date">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="md-3">
                                    <label for="example-text-input" class="form-label">Category</label>
                                    <select id="category_id" name="category_id" class="form-select " aria-label="Default select example">
                                        @foreach ($categories as $key )
                                        <option value="{{$key->id}}">{{$key->category_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="md-3">
                                    <label for="example-text-input" class="form-label">Product Name</label>
                                    <select id="product_id" name="product_id" class="form-select" aria-label="Default select example">
                                        <option selected="">Open this select menu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="md-3">
                                    <label for="example-text-input" class="form-label">Stock</label>
                                    <input class="form-control" type="text" name="stock_qte" id="stock_qte" readonly style="background-color: #ddd;">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="md-3">
                                    <label for="example-text-input" class="form-label" style="margin-top: 32px;"></label>

                                    <i class="btn btn-info btn-rounded waves-effect waves-light fas fa-plus-circle eeventmore"> Add More</i>
                                </div>
                            </div>
                        </div>


                    </div>
                    <!-- End of card body -->
                    <div class="card-body">
                        <form action="{{route('store.invoice')}}" method="post" action="">
                            @csrf
                            <table class="table-sm table-bordered" width="100%" style="border-color:#ddd ;">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th width="7%">Pieces</th>
                                        <th width="10%">Unit Price</th>
                                        <th width="15%">Total Price</th>
                                        <th width="7%">Action</th>

                                    </tr>
                                </thead>
                                <tbody id="rowAdd" class="rowAdd">

                                </tbody>
                                <tr>
                                    <td colspan="4">Discount</td>
                                    <td>
                                        <input type="text" name="discount_amount" id="discount_amount" class="form-control" placeholder="Discount Amount">
                                    </td>
                                    <td></td>
                                </tr>
                                <tbody id=" rowAdd" class="rowAdd">
                                    <tr>
                                        <td colspan="4">Grand Total estimated amount</td>
                                        <td>
                                            <input type="text" name="amount" value="0" id="amount" class="form-control amount" readonly style="background-color: #ddd;">
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table><br>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <textarea name="description" class="form-control" id="description" placeholder="Enter description here"></textarea>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="">Payement Status</label>
                                    <select name="pay_status" id="pay_status" class="form-select">
                                        <option value="">Select Payement</option>
                                        <option value="full_paid">Full Payement</option>
                                        <option value="full_due">Full due</option>
                                        <option value="partial_paid">Partial Payement</option>
                                    </select>
                                    <input type="text" name="paid_amount" class="form-control paid_amount" placeholder="Enter Amount" style="display: none;">
                                </div>
                                <div class="form-group col-md-9">
                                    <label for="">customer Name</label>
                                    <select name="customer_id" id="customer_id" class="form-select">

                                        <option value="">Select Customer</option>
                                        @foreach ( $customers as $key)
                                        <option value="{{$key->id}}"> {{ $key->name  }} - {{ $key->email }}</option>
                                        @endforeach


                                        <optgroup label="Create new Customer">
                                            <option value="0">New Customer</option>
                                        </optgroup>
                                    </select>
                                </div>

                            </div><br>
                            <div class="row new_customer" style="display: none;">
                                <div class="form-group col-md-4">
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Customer Name">
                                </div>
                                <div class="form-group col-md-4">
                                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Customer Phone">
                                </div>
                                <div class="form-group col-md-4">
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Customer Email">
                                </div>

                            </div><br>
                            <div class="form-group">
                                <button type="submit" class="btn btn-info" id="addButton">Add Invoice</button>
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
        <input type="hidden" name="invoice_no" value="@{{invoice_no}}">
        
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
        <input type="number" class="form-control selling_price text-right" name="selling_price[]" value="0" readonly> 
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
            var invoice_no = $('#invoice_no').val();

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
                invoice_no: invoice_no,

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
        /* calculate unit * buyingp rice  the unit dosnt update*/
        /* $(document).on('keyup click', '.unit_price', '.qte', function() {
            var unit_price = $(this).closest("tr").find("input.unit_price").val();
            var buying_qte = $(this).closest("tr").find("input.qte").val();
            var total = unit_price * buying_qte;
            $(this).closest("tr").find("input.selling_price").val(total);
            $('#discount_amount').trigger('keyup');

        }); */
        $(document).on('keyup click', '.unit_price, .qte', function() {
            var currentStock = document.getElementById('stock_qte').value;
            var $row = $(this).closest("tr");
            var unit_price = $row.find("input.unit_price").val();
            var buying_qte = $row.find("input.qte").val();
            $row.find("input.qte").attr("max", currentStock);
            var total = unit_price * buying_qte;
            $row.find("input.selling_price").val(total);
            $('#discount_amount').trigger('keyup');
        });
        $(document).on('keyup', '#discount_amount', function() {
            totalAmountPrice();
        });

        /* calculater total */
        function totalAmountPrice() {
            var sum = 0;
            $(".selling_price").each(function() {
                var value = $(this).val();
                if (!isNaN(value) && value.length != 0) {
                    sum += parseFloat(value);
                }
            });
            var discount = parseFloat($('#discount_amount').val());
            if (!isNaN(discount) && discount.length != 0) {
                sum -= parseFloat(discount);
            }
            $('#amount').val(sum);
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