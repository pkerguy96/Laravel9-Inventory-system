@extends('admin.admin_master')
@section('admin')

@php
Cache::forget('invoice')
@endphp
<div class="page-content">
    <div class="container-fluid">
        {{ cache('invoices:v1') }}{{ cache('invoices:v1') }}{{ cache('invoices:v1') }}{{ cache('invoices:v1') }}{{ cache('invoices:v1') }}
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Dashboard {{ Cache::get('totalsells') }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Upcube</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>

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
                                <p class="text-truncate font-size-14 mb-2">Total Sales</p>
                                <h4 class="mb-2" id="totalsells"></h4>
                                <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>9.23%</span>from previous period</p>
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
                                <p class="text-truncate font-size-14 mb-2">New Orders</p>
                                <h4 class="mb-2" id="neworder">938</h4>
                                <p class="text-muted mb-0"><span class="text-danger fw-bold font-size-12 me-2"><i class="ri-arrow-right-down-line me-1 align-middle"></i>1.09%</span>from previous period</p>
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
                                <p class="text-truncate font-size-14 mb-2">Total Customers</p>
                                <h4 class="mb-2" id="customers"></h4>
                                <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>16.2%</span>from previous period</p>
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
                                <p class="text-truncate font-size-14 mb-2">Products Out Of Stock</p>
                                <h4 class="mb-2" id="outofstock"></h4>
                                <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>11.7%</span>from previous period</p>
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

                            <h4 class="card-title mb-4">Latest Transactions</h4>

                            <div class="table-responsive">
                                <table class="table table-centered mb-0 align-middle table-hover table-nowrap" id="invoices">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Invoice Number</th>
                                            <th>name</th>
                                            <th>Date</th>
                                            <th>Due Date</th>
                                            <th>Status</th>
                                            <th>Description</th>
                                            <th style="width: 120px;">Salary</th>
                                        </tr>
                                    </thead><!-- end thead -->
                                    <tbody>
                                        <tr>
                                            <td>
                                                <h6 class="mb-0">Charles Casey</h6>
                                            </td>
                                            <td>Web Developer</td>
                                            <td>
                                                <div class="font-size-13"><i class="ri-checkbox-blank-circle-fill font-size-10 text-success align-middle me-2"></i>Active</div>
                                            </td>
                                            <td>
                                                23
                                            </td>
                                            <td>
                                                04 Apr, 2021
                                            </td>
                                            <td>$42,450</td>
                                        </tr>
                                        <!-- end -->

                                        <!-- end -->
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
                console.log(data);
                document.getElementById('totalsells').textContent = data.totalsells + ' MAD';
                document.getElementById('neworder').textContent = data.neworders + ' This Week';
                document.getElementById('outofstock').textContent = data.outofstocks;
                document.getElementById('customers').textContent = data.totalCustomers;
                const table = document.getElementById('invoices');
                const tbody = table.querySelector('tbody');

                let rows = '';
                let total = 0;
                data.invoices.forEach(invoice => {
                    const invoiceTotal = invoice.invoice_details.reduce((total, detail) => {
                        return total + detail.grand_total;
                    }, 0);
                    total += invoiceTotal;
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
                                                <div class="font-size-13"><i class="ri-checkbox-blank-circle-fill font-size-10 ${invoice.status === 1 ? 'text-success' : 'text-danger'}  align-middle me-2"></i>${invoice.status === 1 ? 'Approved' : 'Pending'}</div>
                                            </td>
                                            <td>
                                            ${invoice.description == null ? '' : invoice.description}
                                            </td>
                                            
                                            <td>${total.toFixed(2)} MAD</td>
                                        </tr>`;
                });
                tbody.innerHTML = rows;
            } catch (error) {
                console.log(error);
            }



        }
    </script>
    @endsection