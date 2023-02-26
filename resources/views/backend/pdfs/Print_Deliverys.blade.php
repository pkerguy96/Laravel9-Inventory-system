<!-- @extends('admin.admin_master')

@section('admin')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
<style>
    .custom-margin {
        margin-bottom: 8%;
    }
</style>

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
                                <h3>Client:</h3>
                                <address>
                                    <strong>{{ $data['customers']['name'] }}</strong><br>
                                    {{ $data['customers']['address']  }}<br>
                                    {{ $data['customers']['email']  }}<br>
                                    {{ $data['customers']['phone']  }}<br>
                                    {{ $data['customers']['ice']  }}<br>
                                </address>
                            </div>
                            <div class="col-6 mt-4 text-end">
                                <h3>Delivery Receipt N: {{$data->delivery_no}}</h3>
                                <b>Date : {{date('Y-m-d',strtotime($data->date))}}</b><br>
                                <b>Due date: {{date('Y-m-d',strtotime($data->due_date))}}</b>
                            </div>
                        </div>

                    </div>
                </div>






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
                                                <td class="text-center"><strong>Reference</strong></td>
                                                <td class="text-center"><strong>Brand</strong>
                                                <td class="text-center"><strong>Category</strong></td>
                                                <td class="text-center"><strong>Product Name</strong></td>
                                                <td class="text-center"><strong>Quantity</strong></td>



                                                </td>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($delivery_details as $detail)


                                            <tr>
                                                <td class="text-center">{{$detail['products']['ref_num']}}</td>
                                                <td class="text-center">{{$detail['brands']['Brand_name']}}</td>
                                                <td class="text-center">{{$detail['categories']['category_name']}}</td>
                                                <td class="text-center">{{$detail['products']['product_name']}}</td>
                                                <td class="text-center">{{$detail->qte}}</td>



                                            </tr>
                                            @endforeach


                                            <tr class="mt-10">

                                                <td class="no-line"></td>
                                                <td class="no-line"></td>
                                                <td class="no-line"></td>
                                                <td class="no-line text-center">
                                                    <strong>Total Quantity:</strong>
                                                </td>
                                                <td class="no-line text-center">
                                                    <h6 class="m-0"> {{$data->total_qte}}</h6>
                                                </td>
                                            </tr>


                                        </tbody>
                                    </table>
                                </div>
                                <div class="pt-3">
                                    <h5 class="fw-bold fs-4 fs-md-3 fs-sm-2">NOTE:</h5>

                                    Promed Planet Sarl Au <font>Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem praesentium sequi dignissimos quis ab officiis vitae culpa dolor, pariatur quod itaque ipsam commodi quibusdam harum similique vel eaque est magnam!</font>

                                </div>
                                <div class="row pt-3 custom-margin ">
                                    <div class="mb-5">
                                        <h2 style="text-align: right; margin-right:20px;">signature</h2>

                                    </div>

                                </div>
                                <div class="text-center">
                                    <hr class="p-1  text-dark " style="margin-left: 8%; margin-right:8%">
                                    <p class=" text-center" style="margin-left: 8%; margin-right:8%"> Lorem, ipsum dolor sit amet consectetur adipisicing elit. Porro reprehenderit omnis eaque aliquam assumenda itaque doloremque illo voluptate suscipit. Soluta dolores maxime placeat sit sequi doloremque accusamus repellat commodi nesciunt?</p>
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