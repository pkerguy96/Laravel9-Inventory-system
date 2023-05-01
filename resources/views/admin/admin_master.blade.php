<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Dashboard | Promedplanet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Promedplanet Inventory System" name="description" />
    <meta content="Promedplanet" name="Aymen Elkor" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}">
    <!-- Select 2 -->
    <link href="{{ asset('backend/assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <!-- end Select 2  -->
    <!-- jquery.vectormap css -->
    <link href="{{ asset('backend/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link href="{{ asset('backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('backend/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('backend/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('select.css') }}" />
    <style>
        .page-content {
            margin-left: 0;
            margin-inline-start: ;
        }
    </style>
    <script>
        async function getPrintFunction(type = "facture", data = {}) {
            var path, regex;
            switch (type) {
                case "facture":
                    path = "{{asset('printfiles/facture.txt')}}";
                    regex = {
                        client: /@{{data-client}}/g,
                        address: /@{{data-address}}/g,
                        ice: /@{{data-ice}}/g,
                        phone: /@{{data-tel}}/g,
                        bill: /@{{data-bill}}/g,
                        date: /@{{data-date}}/g,
                        bon: /@{{data-bon}}/g,
                        rows: /@{{data-rows}}/g,
                        tax: /@{{data-tax}}/g,
                        total: /@{{data-total}}/g,
                        sub_total: /@{{data-sub}}/g,
                        total_tax: /@{{data-total-tax}}/g,
                        total_text: /@{{data-total-text}}/g,
                        logo: /@{{data-logo}}/g,
                    };
                    break;
                case "livraison":
                    path = "{{asset('printfiles/livraison.txt')}}";
                    regex = {
                        client: /@{{data-client}}/g,
                        address: /@{{data-address}}/g,
                        ice: /@{{data-ice}}/g,
                        phone: /@{{data-tel}}/g,
                        bon: /@{{data-bon}}/g,
                        date: /@{{data-date}}/g,
                        rows: /@{{data-rows}}/g,
                        total: /@{{data-total}}/g,
                        quantity: /@{{data-quantity}}/g,
                        total_text: /@{{data-total-text}}/g,
                        logo: /@{{data-logo}}/g,
                    };
                    break;
                case "commande":
                    path = "{{asset('printfiles/commande.txt')}}";
                    regex = {
                        date: /@{{data-date}}/g,
                        rows: /@{{data-rows}}/g,
                        logo: /@{{data-logo}}/g,
                    };
                    break;
                case "devis":
                    path = "{{asset('printfiles/devis.txt')}}";
                    regex = {
                        devis: /@{{data-devis}}/g,
                        date: /@{{data-date}}/g,
                        rows: /@{{data-rows}}/g,
                        tax: /@{{data-tax}}/g,
                        total: /@{{data-total}}/g,
                        sub_total: /@{{data-sub}}/g,
                        total_tax: /@{{data-total-tax}}/g,
                        logo: /@{{data-logo}}/g,
                    };
                    break;
            }
            data = {
                ...data,
                logo: "{{asset('/backend/assets/images/logo.png')}}",
            };
            let req = await fetch("{{asset('printfiles/style.txt')}}");
            const css = await req.text();
            req = await fetch(path);
            let code = await req.text();
            for (let name in regex) {
                const cur = regex[name];
                const val = (data && data[name]) || "";
                code = code.replace(cur, val);
            }
            return function Print() {
                var doc = window.open("", "PRINT");
                doc.document.write(`<html>${css}${code}</html>`);
                doc.document.close();
                doc.focus();
                setTimeout(() => {
                    doc.print();
                    //doc.close();
                }, 1000);
            };
        }
    </script>

</head>

<body data-topbar="dark">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">


        @include('admin.body.header')

        <!-- ========== Left Sidebar Start ========== -->
        @include('admin.body.sidebar')
        <!-- Left Sidebar End -->



        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            @yield('admin')
            <!-- End Page-content -->

            @include('admin.body.footer')


        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->

    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('backend/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/node-waves/waves.min.js') }}"></script>

    <!-- apexcharts -->
    <!-- <script src="{{ asset('backend/assets/libs/apexcharts/apexcharts.min.js') }}"></script> -->

    <!-- jquery.vectormap map -->
    <script src="{{ asset('backend/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}"></script>

    <!-- Required datatable js -->
    <script src="{{ asset('backend/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Responsive examples -->
    <script src="{{ asset('backend/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <!--  <script src="{{ asset('backend/assets/js/pages/dashboard.init.js') }}"></script> -->

    <!-- App js -->
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        @if(Session::has('message'))
        var type = "{{ Session::get('alert-type','info') }}"
        switch (type) {
            case 'info':
                toastr.info(" {{ Session::get('message') }} ");
                break;

            case 'success':
                toastr.success(" {{ Session::get('message') }} ");
                break;

            case 'warning':
                toastr.warning(" {{ Session::get('message') }} ");
                break;

            case 'error':
                toastr.error(" {{ Session::get('message') }} ");
                break;
        }
        @endif
    </script>
    <!-- Required datatable js -->
    <script src="{{ asset('backend/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Datatable init js -->
    <script src="{{ asset('backend/assets/js/pages/datatables.init.js') }}"></script>
    <script src="{{ asset('backend/assets/js/validate.min.js') }}"></script>
    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script src="{{ asset('backend/assets/js/sweetAl.js') }}"></script>
    <script src="{{ asset('backend/assets/js/handlebars.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>
    <!-- Form Select 2  JS -->
    <script src="{{ asset('backend/assets/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pages/form-advanced.init.js') }}"></script>
    <script src="{{  asset('select.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#datatab').DataTable({
                autoWidth: false,
                "language": {
                    "lengthMenu": "{{ __('Display _MENU_ records per page') }}",
                    "zeroRecords": "{{ __('Nothing found - sorry') }}",
                    "info": "{{ __('Showing page _PAGE_ of _PAGES_') }}",
                    "infoEmpty": "{{ __('No records available') }}",
                    "infoFiltered": "{{ __('filtered from _MAX_ total records') }}"
                }
            });
        });
        new Select();
    </script>

</body>

</html>