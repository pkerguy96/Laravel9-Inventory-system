 @extends('admin.admin_master')
 @section('admin')
 <div class="page-content">
     <div class="container-fluid">
         <!-- start page title -->
         <div class="row">
             <div class="col-12">
                 <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                     <h4 class="mb-sm-0">{{ __('Invoice Report By Date') }}</h4>

                     <div class="page-title-right">
                         <ol class="breadcrumb m-0">
                             <li class="breadcrumb-item"><a href="javascript: void(0);"></a></li>
                             <li class="breadcrumb-item active">{{ __('Invoice Report By Date') }}</li>
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
                                         <h3 class="font-size-16"><strong>{{ __('Invoices Date Report') }}<span class="btn btn-info">{{ date('d-m-Y', strtotime($startdate)) }}</span>--
                                                 <span class="btn btn-success">{{ date('d-m-Y', strtotime($enddate)) }}</span></strong>
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
                                                         <td><strong>{{ __('Sl') }}</strong></td>
                                                         <td class="text-center"><strong>{{ __('Customer Name') }}</strong></td>
                                                         <td class="text-center"><strong>{{ __('Invoice No') }}</strong></td>
                                                         <td class="text-center"><strong>{{ __('Date') }}</strong></td>
                                                         <td class="text-center"><strong>{{ __('Description') }}</strong></td>
                                                         <td class="text-center"><strong>{{ __('Amount') }}</strong>
                                                         </td>
                                                     </tr>
                                                 </thead>
                                                 <tbody>
                                                     @php
                                                     $total_price = '0';
                                                     @endphp
                                                     @foreach ($data as $key => $item)
                                                     <tr>
                                                         <td class="text-center"><a href="{{ route('Print.invoice.client', $item->id) }}" class="text-reset !important">{{ $key + 1 }} </a></td>
                                                         <td class="text-center"><a href="{{ route('Print.invoice.client', $item->id) }}" class="text-reset !important">{{ $item['payements']['customers']['name'] }}</a>
                                                         </td>
                                                         <td class="text-center"><a href="{{ route('Print.invoice.client', $item->id) }}" class="text-reset !important">{{ $item->invoice_no }}</a>
                                                         </td>

                                                         <td class="text-center"><a href="{{ route('Print.invoice.client', $item->id) }}" class="text-reset !important">{{ date('d-m-Y', strtotime($item->date)) }}</a>
                                                         </td>
                                                         <td class="text-center"><a href="{{ route('Print.invoice.client', $item->id) }}" class="text-reset !important">{{ $item->description }}</a>
                                                         </td>
                                                         <td class="text-center"><a href="{{ route('Print.invoice.client', $item->id) }}" class="text-reset !important">
                                                                 {{ number_format($item['payements']['total_amount'], 2, '.', ',') }}
                                                                 MAD</a></td>

                                                     </tr>
                                                     @php
                                                     $total_price += $item['payements']['total_amount'];
                                                     @endphp
                                                     @endforeach

                                                     <tr>
                                                         <td class="no-line"></td>
                                                         <td class="no-line"></td>
                                                         <td class="no-line"></td>

                                                         <td class="no-line"></td>
                                                         <td class="no-line text-center">
                                                             <strong>{{ __('Total') }}</strong>
                                                         </td>
                                                         <td class="no-line text-end">
                                                             <h4 class="m-0"> {{ number_format($total_price, 2, '.', ',') }}
                                                                 MAD</h4>
                                                         </td>
                                                     </tr>

                                                 </tbody>
                                             </table>
                                         </div>
                                         <div class="d-print-none">
                                             <div class="float-end">
                                                 <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light"><i class="fa fa-print"></i></a>

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