@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Supplier And Product Report</h4>
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
                                <strong>Supplier Report</strong>
                                <input type="radio" name="supplier_info" id="supplier_info" value='supplier_true' class="search_value">&nbsp;&nbsp;
                                <strong>Product Report</strong>
                                <input type="radio" name="supplier_info" id="product_info" value='product_true' class="search_value">
                            </div>
                        </div>
                        <div class="supplier_list" style="display: none;">
                            <form action="{{route('supplier.report.pdf')}}" method="GET" id="promform" target="_blank">
                                <div class="row">
                                    <div class="col-sm-8 form-group">
                                        <label for="">Supplier Name</label>
                                        <select name="supplier_id" class="form-select" aria-label="Default select example">
                                            <option value="">Open this select menu</option>
                                            @foreach ( $suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-4" style="padding-top: 22px;">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="product_list" style="display: none;">
                            <form action="{{route('product.report.pdf')}}" method="GET" id="promform" target="_blank">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="md-3">
                                            <label for="example-text-input" class="form-label">Category</label>
                                            <select id="category_id" name="category_id" class="form-select " aria-label="Default select example">
                                                @foreach ($categories as $key )
                                                <option value="{{$key->id}}">{{$key->category_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="md-3">
                                            <label for="example-text-input" class="form-label">Product Name</label>
                                            <select id="product_id" name="product_id" class="form-select" aria-label="Default select example">
                                                <option selected="">Open this select menu</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4" style="padding-top: 22px;">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->



    </div> <!-- container-fluid -->
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#promform').validate({
            rules: {
                supplier_id: {
                    required: true,
                },

            },
            messages: {
                supplier_id: {
                    required: 'Please Select A Supplier',
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
<script type="text/javascript">
    $(document).on('change', '.search_value', function() {
        var search_value = $(this).val();
        if (search_value == 'supplier_true') {
            $('.supplier_list').show();
        } else {
            $('.supplier_list').hide();
        }
    });
</script>
<script type="text/javascript">
    $(document).on('change', '.search_value', function() {
        var search_value = $(this).val();
        if (search_value == 'product_true') {
            $('.product_list').show();
        } else {
            $('.product_list').hide();
        }
    });
</script>
<script type="text/javascript">
    window.addEventListener('load', function() {
        var category_id = document.getElementById('category_id').value;
        if (category_id) {
            fetchProducts(category_id);
        }
    });

    function fetchProducts(category_id) {
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
    }
</script>
@endsection