@extends('admin.admin_master')
@section('admin')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{ __('Purchases Details') }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);"></a></li>
                            <li class="breadcrumb-item active">{{ __('Purchases Details') }}</li>
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
                                        <img src="{{ asset('backend/assets/images/logo.png') }}" alt="logo" height="24" /> Promed Plannet
                                    </h3>
                                </div>
                                <hr>

                                <div class="row">
                                    <div class="col-6 mt-4">
                                        <address>
                                            @php
                                            $adminData = App\Models\User::find($data->created_by);
                                            @endphp
                                            <strong>Created By: {{ $adminData->name}}</strong><br>
                                        </address>
                                    </div>
                                    <div class="col-6 mt-4 text-end">
                                        <address>
                                            @if(count($data->PurchaseDetails) > 0)
                                            @php $supplier = $data->PurchaseDetails[0]->suppliers @endphp
                                            <strong>{{ $supplier->name }}</strong><br>
                                            {{ $supplier->address }}<br>
                                            {{ $supplier->email }}<br>
                                            {{ $supplier->phone }}<br>
                                            {{ $supplier->ice }}<br>
                                            @endif
                                        </address>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <div class="p-2">
                                        <h3 class="font-size-16"><strong>{{ __('Purchases Details Date') }} <span class="btn btn-light">{{ date('d-m-Y', strtotime($data->date)) }}</span></strong>
                                        </h3>
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
                                                        <td class="text-center"><strong>{{ __('ID') }}</strong></td>
                                                        <td class="text-center"><strong>{{ __('Date') }}</strong></td>
                                                        <td class="text-center"><strong>{{ __('Purchase Number') }}</strong> </td>
                                                        <td class="text-center"><strong>{{ __('Brand') }}</strong></td>
                                                        <td class="text-center"><strong>{{ __('Product Category') }}</strong> </td>
                                                        <td class="text-center"><strong>{{ __('Product Name') }}</strong></td>
                                                        <td class="text-center"><strong>{{ __('Quantity') }}</strong></td>
                                                        <td class="text-center"><strong>{{ __('Unit Price') }}</strong> </td>
                                                        <td class="text-center"><strong>{{ __('Total Price') }}</strong> </td>

                                                    </tr>
                                                </thead>
                                                <tbody>


                                                    @foreach($data->PurchaseDetails as $purchaseDetail)
                                                    <tr>
                                                        <td class="text-center">{{ $data->id }}</td>
                                                        <td class="text-center">{{ date('d-m-Y', strtotime($data->date)) }}</td>
                                                        <td class="text-center">{{ $data->purchase_no }}</td>
                                                        <td class="text-center">{{ $purchaseDetail->brands->Brand_name ?? 'N/A' }}</td>
                                                        <td class="text-center">{{ $purchaseDetail->categories->category_name ?? 'N/A' }}</td>
                                                        <td class="text-center">{{ $purchaseDetail->products->product_name ?? 'N/A' }}</td>
                                                        <td class="text-center">{{ $purchaseDetail->qte }}</td>
                                                        <td class="text-center">{{ number_format($purchaseDetail->unit_price, 2, '.', ',') }} MAD</td>
                                                        <td class="text-center">{{ number_format($purchaseDetail->buying_price, 2, '.', ',') }} MAD</td>
                                                    </tr>
                                                    @endforeach
                                                    @php
                                                    $buyingprices = $data['PurchaseDetails']->pluck('buying_price')->toArray();
                                                    $Subtotal = CalculateGrandTotal($buyingprices,0, 0);
                                                    $Grandtotal = CalculateGrandTotal($buyingprices, 0,$data->tax_rate);
                                                    @endphp
                                                    <tr class="mt-10">

                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line text-center">
                                                            <strong>{{ __('SubTotal') }}:</strong>
                                                        </td>
                                                        <td class="no-line text-center">
                                                            <h6 class="m-0"> {{ number_format($Subtotal['grand_total'], 2, '.', ',') }}
                                                                MAD</h6>
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
                                                        <td class="no-line text-center">
                                                            <strong>{{ __('Tax') }} {{ $data->tax_rate }}%:</strong>
                                                        </td>
                                                        <td class="no-line text-center">
                                                            <h6 class="m-0"> {{ number_format($Grandtotal['tax_amount'], 2, '.', ',') }}
                                                                MAD</h6>
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
                                                        <td class="no-line text-center">
                                                            <strong>{{ __('Grand Total') }}:</strong>
                                                        </td>
                                                        <td class="no-line text-center">
                                                            <h6 class="m-0">{{ number_format($Grandtotal['grand_total'], 2, '.', ',') }}
                                                                MAD</h6>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                        @if (!is_null($data->description))
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <div class="card card-body ">
                                                    <p class="card-text">{{ __('Description') }}:
                                                        <b>{{ $data->description }}</b>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @php
                                        $amountInWords = ucwords((new NumberFormatter(__('en'), NumberFormatter::SPELLOUT))->format($Grandtotal['grand_total']));
                                        @endphp
                                        <div class="row ">
                                            <div class="col-md-12 text-center  ">
                                                <div class="card card-body border-1 border-dark">
                                                    <p class="card-text ">{{ __('Current invoice total') }}:
                                                        <b> {{ $amountInWords }}</b>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-print-none">
                                            <div class="float-end">
                                                <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light"><i class="fa fa-print"></i></a>
                                                <a href="#" class="btn btn-primary waves-effect waves-light ms-2">{{ __('Download') }}</a>
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
@endsection