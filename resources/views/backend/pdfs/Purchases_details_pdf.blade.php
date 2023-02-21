<!-- @extends('admin.admin_master')
@section('admin')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Purchases Details</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);"></a></li>
                    <li class="breadcrumb-item active">Purchases Details</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-12">
                        <div class="invoice-title">

                            <h3>
                                <img src="{{asset('backend/assets/images/logo-sm.png')}}" alt="logo" height="24" /> Promed Plannet
                            </h3>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-6 mt-4">
                                <address>
                                    <strong>Promed Plannet</strong><br>
                                    Benni mellal ipse lorem lol <br>
                                    jsmith@email.com
                                </address>
                            </div>
                            <div class="col-6 mt-4 text-end">
                                <address>
                                    <strong>{{ $data['suppliers']['name'] }}</strong><br>
                                    {{ $data['suppliers']['address']  }}<br>
                                    {{ $data['suppliers']['email']  }}<br>
                                    {{ $data['suppliers']['phone']  }}<br>
                                    {{ $data['suppliers']['ice']  }}<br>
                                </address>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div>
                            <div class="p-2">
                                <h3 class="font-size-16"><strong>Purchases Details Date <span class="btn btn-light">{{date('d-m-Y',strtotime($data->date))}}</span></strong></h3>
                            </div>

                        </div>

                    </div>
                </div> <!-- end row -->




                <div class="row">
                    <div class="col-12">
                        <div>
                            <div class="p-2">

                            </div>
                            <div class="">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <td class="text-center"><strong>ID</strong></td>
                                                <td class="text-center"><strong>date</strong>
                                                <td class="text-center"><strong>Purchase Number</strong></td>
                                                <td class="text-center"><strong>Brand</strong></td>
                                                <td class="text-center"><strong>Product Category</strong></td>
                                                <td class="text-center"><strong>Product Name</strong></td>
                                                <td class="text-center"><strong>Quantity</strong></td>
                                                <td class="text-center"><strong>Unit Price</strong>
                                                <td class="text-center"><strong>Description</strong></td>

                                                <td class="text-center"><strong>Total Price</strong>


                                                </td>

                                            </tr>
                                        </thead>
                                        <tbody>


                                            <tr>
                                                <td class="text-center">{{$data->id}}</td>
                                                <td class="text-center">{{date('d-m-Y',strtotime($data->date))}}</td>
                                                <td class="text-center">{{$data->purchase_no}}</td>
                                                <td class="text-center">{{$data['brands']['Brand_name'] ?? 'N/A'}}</td>
                                                <td class="text-center">{{$data['categories']['category_name'] ?? 'N/A'}}</td>
                                                <td class="text-center">{{$data['products']['product_name'] ?? 'N/A'}}</td>

                                                <td class="text-center">{{$data->qte}}</td>
                                                <td class="text-center">{{$data->unit_price}} MAD</td>
                                                <td class="text-center">{{$data->description}}</td>
                                                <td class="text-center">{{$data->buying_price}} MAD</td>


                                            </tr>



                                            <tr class="mt-10">
                                                <td class="no-line"></td>
                                                <td class="no-line"></td>
                                                <td class="no-line"></td>
                                                <td class="no-line"></td>
                                                <td class="no-line"></td>
                                                <td class="no-line"></td>
                                                <td class="no-line"></td>
                                                <td class="no-line"></td>
                                                <td class="no-line text-center">
                                                    <strong>SubTotal:</strong>
                                                </td>
                                                <td class="no-line text-center">
                                                    <h6 class="m-0">{{$data->buying_price}} MAD</h6>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="no-line"></td>
                                                <td class="no-line"></td>
                                                <td class="no-line"></td>
                                                <td class="no-line"></td>
                                                <td class="no-line"></td>
                                                <td class="no-line"></td>
                                                <td class="no-line"></td>
                                                <td class="no-line"></td>
                                                <td class="no-line text-center">
                                                    <strong>TVA 20%:</strong>
                                                </td>
                                                <td class="no-line text-center">
                                                    <h6 class="m-0">{{$data->tax_amount}} MAD</h6>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="no-line"></td>
                                                <td class="no-line"></td>
                                                <td class="no-line"></td>
                                                <td class="no-line"></td>
                                                <td class="no-line"></td>
                                                <td class="no-line"></td>
                                                <td class="no-line"></td>
                                                <td class="no-line"></td>
                                                <td class="no-line text-center">
                                                    <strong>Grand Total:</strong>
                                                </td>
                                                <td class="no-line text-center">
                                                    <h6 class="m-0">{{$data->grand_total}} MAD</h6>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                                @php
                                $totalAmount = $data->grand_total;
                                $amountInWords = ucwords((new NumberFormatter('fr', NumberFormatter::SPELLOUT))->format($totalAmount));
                                @endphp
                                <div class="card card-body">
                                    <p class="card-text text-center">
                                    <h5 class="text-center">Total amount is : <b>{{ $amountInWords}} MAD</b></h5>

                                    </p>
                                </div>
                                <div class="d-print-none">
                                    <div class="float-end">
                                        <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light"><i class="fa fa-print"></i></a>
                                        <a href="#" class="btn btn-primary waves-effect waves-light ms-2">Download</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div> <!-- end row -->





            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->

</div> <!-- container-fluid -->
</div>
<!-- End Page-content -->



@endsection -->