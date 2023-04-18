@extends('admin.admin_master')
@section('admin')

@php
Cache::forget('invoice');
@endphp
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Dashboard </h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2"> {{ __('Total Sales') }}</p>
                                <h4 class="mb-2" id="totalsells"></h4>
                                <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>9.23%</span>{{ __('from previous period') }}</p>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="mdi mdi-currency-usd font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">{{ __('New Orders') }}</p>
                                <h4 class="mb-2" id="neworder">938</h4>
                                <p class="text-muted mb-0"><span class="text-danger fw-bold font-size-12 me-2"><i class="ri-arrow-right-down-line me-1 align-middle"></i>1.09%</span>{{ __('from previous period') }}</p>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-success rounded-3">

                                    <i class="ri-shopping-cart-2-line font-size-24"></i>

                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">{{ __('Total Customers') }}</p>
                                <h4 class="mb-2" id="customers"></h4>
                                <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>16.2%</span>{{ __('from previous period') }}</p>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="ri-user-3-line font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">{{ __('Products Out Of Stock') }}</p>
                                <h4 class="mb-2" id="outofstock"></h4>
                                <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>11.7%</span>{{ __('from previous period') }}</p>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-success rounded-3">
                                    <i class="mdi mdi-parking font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->
        </div><!-- end row -->

        <div class="row">


            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dropdown float-end">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>

                            </div>

                            <h4 class="card-title mb-4">{{ __('Latest Transactions') }}</h4>

                            <div class="table-responsive">
                                <table class="table table-centered mb-0 align-middle table-hover table-nowrap" id="invoices">
                                    <thead class="table-light">
                                        <tr>
                                            <th>{{ __('Invoice Number') }}</th>
                                            <th>{{ __('name') }}</th>
                                            <th>{{ __('Date') }}</th>
                                            <th>{{ __('Due Date') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Description') }}</th>
                                            <th style="width: 120px;">{{ __('Latest Transactions') }}</th>
                                        </tr>
                                    </thead><!-- end thead -->
                                    <tbody>

                                    </tbody><!-- end tbody -->
                                </table> <!-- end table -->
                            </div>
                        </div><!-- end card -->
                    </div><!-- end card -->
                </div>
                <!-- end col -->



            </div>
            <!-- end row -->
        </div>

    </div>
    <script>
        window.addEventListener('load', function() {
            getTotalSells();
        });
        async function getTotalSells() {
            try {
                const response = await fetch('{{route("get-total-sells")}}');
                const data = await response.json();

                document.getElementById('totalsells').textContent = data.totalsells + ' MAD';
                document.getElementById('neworder').textContent = data.neworders + ' This Week';
                document.getElementById('outofstock').textContent = data.outofstocks;
                document.getElementById('customers').textContent = data.totalCustomers;
                const table = document.getElementById('invoices');
                const tbody = table.querySelector('tbody');

                let rows = '';
                let total = 0;
                data.invoices.forEach(invoice => {


                    rows += `<tr>
                                            <td>
                                                <h6 class="mb-0">${invoice.invoice_no}</h6>
                                            </td>
                                            <td>${invoice.clients.name}</td>
                                            <td>${invoice.date}</td>
                                            <td>
                                            ${invoice.due_date}
                                            </td>
                                            <td>
                                                <div class="font-size-13"><i class="ri-checkbox-blank-circle-fill font-size-10 ${invoice.status === 1 ? 'text-success' : 'text-danger'}  align-middle me-2"></i>${invoice.status === 1 ? "{{__('Approved')}}" : "{{__('Pending')}}"}</div>
                                            </td>
                                            <td>
                                            ${invoice.description == null ? '' : invoice.description}
                                            </td>
                                            
                                            <td>${invoice.payements.total_amount.toFixed(2)} MAD</td>
                                        </tr>`;
                });
                tbody.innerHTML = rows;
            } catch (error) {
                console.log(error);
            }



        }
    </script>
    @endsection