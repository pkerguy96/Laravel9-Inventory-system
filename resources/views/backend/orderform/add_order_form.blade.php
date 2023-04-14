@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add New Order Form </h4><br><br>



                        <div class="row justify-content-center justify-content-md-center justify-content-sm-between gap-sm-3 gap-md-5 flex-wrap">
                            <div class="col-md-2 col-sm-12 mb-3 mb-sm-0">
                                <div class="md-3">
                                    <label for="example-text-input" class="form-label" style="white-space: nowrap;">Receipt Number</label>
                                    <input class="form-control" type="text" value="{{$orderform_no}}" name="orderform_no" id="orderform_no" readonly style="background-color: #ddd;">
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12 mb-3 mb-sm-0">
                                <div class="md-3">
                                    <label for="example-text-input" class="form-label">Date</label>
                                    <input class="form-control" type="date" value="{{$date}}" name="date" id="date">
                                </div>
                            </div>
                            <div class=" col-md-3 col-sm-12">
                                <div class="mb-3">
                                    <label for="Brand_id" class="form-label">Brand</label>
                                    <select id="Brand_id" name="Brand_id" class="form-select" aria-label="Default select example">
                                        @foreach ($brands as $key )
                                        <option value="{{$key->id}}">{{$key->Brand_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center  mt-2 mt-sm-1 mt-md-2 mt-lg-3 mt-xl-3 flex-wrap">
                            <!-- brand start -->

                            <!-- brand end -->
                            <div class="col-md-3 col-sm-12">
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select id="category_id" name="category_id" class="form-select" aria-label="Default select example">
                                        @foreach ($categories as $key )
                                        <option value="{{$key->id}}">{{$key->category_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-12">
                                <div class="mb-3">
                                    <label for="product_id" class="form-label">Product Name</label>
                                    <select id="product_id" name="product_id" class="form-select" aria-label="Default select example">
                                        <option selected="">Open this select menu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="mb-3">
                                    <label for="stock_qte" class="form-label">Stock</label>
                                    <input class="form-control" type="text" name="stock_qte" id="stock_qte" readonly style="background-color: #ddd;">
                                </div>
                            </div>
                        </div>

                        <div class="row float-end mt-0 ">


                            <div class="col-md-12">
                                <div class="md-3">
                                    <label for="example-text-input" class="form-label" style="margin-top: 32px;"></label>

                                    <i class="btn btn-info   btn-rounded waves-effect waves-light fas fa-plus-circle eeventmore"> Add More</i>
                                </div>
                            </div>

                        </div>


                    </div>

                    <!-- End of card body -->
                    <div class="card-body">
                        <form action="{{route('store.order.form')}}" method="post" action="">
                            @csrf
                            <table class="table-sm table-bordered" width="100%" style="border-color:#ddd ;">
                                <thead>
                                    <tr>
                                        <th>Brand</th>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th width="7%">Pieces</th>

                                        <th width="7%">Action</th>

                                    </tr>
                                </thead>
                                <tbody id="rowAdd" class="rowAdd">

                                </tbody>

                                <tbody id=" rowAdd" class="rowAdd">

                                    <tr>
                                        <td colspan="3" style="text-align: right;"><strong class="text-right">Total Quantity</strong></td>
                                        <td>
                                            <input type="text" name="Gtotal" value="0" id="Gtotal" class="form-control Gtotal" readonly style="background-color: #ddd;">
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table><br>



                            <div class="form-group">
                                <button type="submit" class="btn btn-info" id="addButton">Add Order Form</button>
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
      
        <input type="hidden" name="orderform_no" value="@{{orderform_no}}">
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
        <i class="btn btn-danger btn-sm fas fa-window-close removedeletebtn"></i>
    </td>

    </tr>
 
</script>


<script type="text/javascript">
    $(document).ready(function() {
        $(document).on("click", ".eeventmore", function() {
            var date = $('#date').val();
            var due_date = $('#due_date').val();
            var orderform_no = $('#orderform_no').val();
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
                orderform_no: orderform_no,
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
                totalqte();
            }
        });



        $(document).on('keyup click', '.qte', function() {
            var $row = $(this).closest("tr");
            var currentStock = document.getElementById('stock_qte').value;
            $row.find("input.qte").attr("max", currentStock);
            var buying_qte = $row.find("input.qte").val();
            var qte = parseInt($row.find('input.qte').val()) || 0;
            if (qte > currentStock) {
                // Set the qte value to current stock and trigger a change event to recalculate total qte
                $row.find('input.qte').val(currentStock).change();
            }
            totalqte();
        });

        function totalqte() {
            var totalQte = 0;
            var $gtotal = $('#Gtotal');
            $('.qte').each(function() {
                // add the value of each qte input to the total
                totalQte += parseInt($(this).val()) || 0;
            });
            // set the total qte to the gtotal input
            $gtotal.val(totalQte);
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
    // Call the fetch-product API with the default value of the category_id select element
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


@endsection