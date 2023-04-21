@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <style>
                .custom-margin {
                    margin-bottom: 13%;
                }
            </style>
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('Delivery Receipt') }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);"></a></li>
                                <li class="breadcrumb-item active">{{ __('Delivery Receipt') }} </li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div id="page" class="row">
                <div class="col-12">
                    <div class="card main-bg">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-12">
                                    <div class="invoice-title">
                                        <h4 class="float-end font-size-16"><strong></strong></h4>
                                        <h3>
                                            <img src="{{ asset('backend/assets/images/logo.png') }}" alt="logo"
                                                height="24" /> Promed Plannet
                                        </h3>
                                    </div>
                                    <hr>

                                    <div class="row">
                                        <div class="col-6 mt-4">
                                            <h2>{{ __('Client') }}:</h2>
                                            <address>
                                                <strong>{{ $data['customers']['name'] }}</strong><br>
                                                <strong>{{ $data['customers']['address'] }}</strong> <br>
                                                <strong>{{ $data['customers']['email'] }}</strong><br>
                                                <strong> Ice: {{ $data['customers']['ice'] }}</strong> <br>
                                                <strong> {{ $data['customers']['phone'] }} </strong>
                                            </address>
                                        </div>
                                        <div class="col-6 mt-4 text-end">
                                            <address>
                                                <h5>{{ __('Delivery Number') }}: {{ $data->delivery_no }}</h5>
                                                <strong>{{ __('Date') }}:
                                                    {{ date('d-m-Y', strtotime($data->date)) }}</strong><br>
                                                <strong>{{ __('Description') }}:
                                                    {{ $data->description ?? 'N/A' }}</strong><br>
                                                <br><br>
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
                                        <div class="">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <td><strong>{{ __('Sl') }}</strong></td>
                                                            <td class="text-center"><strong>{{ __('Reference') }}</strong>
                                                            </td>
                                                            <td class="text-center"><strong>{{ __('Category') }}</strong>
                                                            </td>
                                                            <td class="text-center">
                                                                <strong>{{ __('Product Name') }}</strong>
                                                            <td class="text-center"><strong>{{ __('Quantity') }}</strong>
                                                            <td class="text-center">
                                                                <strong>{{ __('Unite Price') }}</strong>
                                                            <td class="text-center">
                                                                <strong>{{ __('Total Price') }}</strong>
                                                            </td>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="body">
                                                        @php
                                                            $qte = 0;
                                                        @endphp
                                                        @foreach ($data['DeliveryDetails'] as $key => $deliverydetail)
                                                            <tr class="to-keep">
                                                                <td class="text-center">{{ $key + 1 }}</td>
                                                                <td class="to-keep text-center">
                                                                    {{ $deliverydetail['products']['ref_num'] }}
                                                                </td>
                                                                <td class="text-center">
                                                                    {{ $deliverydetail['categories']['category_name'] }}
                                                                </td>
                                                                <td class="to-keep text-center">
                                                                    {{ $deliverydetail['products']['product_name'] }}
                                                                </td>
                                                                <td class="to-keep text-center">{{ $deliverydetail->qte }}
                                                                </td>
                                                                <td class="to-keep text-center">
                                                                    {{ $deliverydetail->unit_price }}
                                                                    MAD
                                                                </td>
                                                                <td class="to-keep text-center">
                                                                    {{ number_format($deliverydetail->selling_price, 2, '.', ',') }}
                                                                    MAD
                                                                </td>
                                                            </tr>
                                                            @php
                                                                $qte = $qte + $deliverydetail->qte;
                                                            @endphp
                                                        @endforeach

                                                        @if (is_null($data->discount))
                                                        @else
                                                            <tr>
                                                                <td class="no-line"></td>
                                                                <td class="no-line"></td>
                                                                <td class="no-line"></td>
                                                                <td class="no-line"></td>
                                                                <td class="no-line"></td>
                                                                <td class="no-line text-center">
                                                                    <strong>{{ __('Discount Amount') }}</strong>
                                                                </td>
                                                                <td class="no-line text-center">
                                                                    <b>{{ number_format($data->discount, 2, '.', ',') }}
                                                                        MAD</b>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        @php
                                                            $sellingPrices = $data['DeliveryDetails']->pluck('selling_price')->toArray();
                                                            $subtotal = CalculateGrandTotal($sellingPrices, $data->discount, 0);
                                                            $Grand_total = CalculateGrandTotal($sellingPrices, $data->discount, 20);
                                                        @endphp
                                                        <tr>
                                                            <td class="thick-line"></td>
                                                            <td class="thick-line"></td>
                                                            <td class="thick-line"></td>
                                                            <td class="thick-line"></td>
                                                            <td class="thick-line"></td>
                                                            <td class="thick-line text-center">
                                                                <strong>{{ __('Subtotal') }}</strong>
                                                            </td>
                                                            <td class="thick-line text-center">
                                                                <b>{{ number_format($subtotal['grand_total'], 2, '.', ',') }}
                                                                    MAD</b>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line text-center">
                                                                <strong>{{ __('Tax') }}</strong>
                                                            </td>
                                                            <td class="no-line text-center"><b> 20%</b></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line text-center">
                                                                <strong>{{ __('Total Tax') }}</strong>
                                                            </td>
                                                            <td class="no-line text-center">
                                                                <b>{{ number_format($Grand_total['tax_amount'], 2, '.', ',') }}
                                                                    MAD</b>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line text-center">
                                                                <strong>{{ __('Grand Total') }}</strong>
                                                            </td>
                                                            <td class="no-line text-center">
                                                                <h4 class="m-0">
                                                                    {{ number_format($Grand_total['grand_total'], 2, '.', ',') }}
                                                                    MAD
                                                                </h4>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <hr>
                                            @php
                                                $totalAmount = $Grand_total['grand_total'];
                                                $amountInWords = ucwords((new NumberFormatter('en', NumberFormatter::SPELLOUT))->format($totalAmount));
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
                                                    <a id="print" href="javascript:void()"
                                                        class="btn btn-success waves-effect waves-light"><i
                                                            class="fa fa-print"></i></a>
                                                    <a href="#"
                                                        class="btn btn-primary waves-effect waves-light ms-2">{{ __('Download') }}</a>
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
    <script defer>
        var body = document.querySelector("#body").cloneNode(true);
        [...body.querySelectorAll("*")].forEach(e => {
            if (!e.classList.contains("to-keep")) e.remove();
        });
        getPrintFunction("livraison", {
            client: "{{ $data['customers']['name'] }}",
            address: "{{ $data['customers']['address'] }}",
            ice: "{{ $data['customers']['ice'] }}",
            phone: "{{ $data['customers']['phone'] }}",
            bon: "{{ $data->delivery_no }}",
            date: "{{ date('d-m-Y', strtotime($data->date)) }}",
            total: "{{ number_format($Grand_total['grand_total'], 2, '.', ',') }}",
            quantity: "{{ $qte }}",
            total_text: "{{ $amountInWords }}",
            rows: body.innerHTML,
        }).then((print) => {
            document.querySelector("#print").addEventListener("click", print);
        });
    </script>
@endsection -->
