<!-- @extends('admin.admin_master')
@section('admin')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Stock Report</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);"></a></li>
                    <li class="breadcrumb-item active">Stock Report</li>
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

                                </address>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div>
                            <div class="p-2">

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
                                                <td><strong>Sl</strong></td>
                                                <td class="text-center"><strong>Supplier Name</strong></td>
                                                <td class="text-center"><strong>Category</strong></td>
                                                <td class="text-center"><strong>Unit</strong></td>
                                                <td class="text-center"><strong>Reference Number</strong></td>
                                                <td class="text-center"><strong>Product Name</strong></td>
                                                <td class="text-center"><strong>Bought Quantity</strong></td>
                                                <td class="text-center"><strong>Sold Quantity</strong></td>
                                                <td class="text-center"><strong>Product Quantity</strong>


                                                </td>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ( $data as $key => $item)
                                            @php
                                            $bought_qte = App\Models\Purchase::where('category_id',$item->category_id)->where('product_id',$item->id)->where('status','1')->sum('qte');
                                            $sold_qte = App\Models\InvoiceDetail::where('category_id',$item->category_id)->where('product_id',$item->id)->where('status','1')->sum('qte');
                                            @endphp
                                            <tr>
                                                <td class="text-center">{{$key+1}}</td>
                                                <td class="text-center">{{ $item['suppliers']->name ?? 'deleted' }}</td>
                                                <td class="text-center">{{ $item['categories']->category_name }}</td>

                                                <td class="text-center"> {{ $item['units']->unit_name }}</td>
                                                <td class="text-center">{{ $item->ref_num }}</td>
                                                <td class="text-center">{{ $item->product_name }} </td>
                                                <td class="text-center"> <span class="btn btn-info">{{$bought_qte}}</span> </td>
                                                <td class="text-center"> <span class="btn btn-success">{{ $sold_qte }}</span> </td>
                                                <td class="text-center"><span class="btn btn-warning">{{ $item->product_qte}}</span></td>

                                            </tr>

                                            @endforeach



                                        </tbody>
                                    </table>
                                </div>
                                @php
                                $date = now()->format('Y-m-d, g:i a');
                                @endphp
                                <i>{{$date}}</i>
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