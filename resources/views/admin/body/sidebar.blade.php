 <div class="vertical-menu">

     <div data-simplebar class="h-100">

         <!-- User details -->


         <!--- Sidemenu -->
         <div id="sidebar-menu">
             <!-- Left Menu Start -->
             <ul class="metismenu list-unstyled" id="side-menu">
                 <li class="menu-title">Menu</li>

                 <li>
                     <a href="{{ route('dashboard') }}" class="waves-effect">
                         <i class="ri-dashboard-line"></i>
                         <span>Dashboard</span>
                     </a>
                 </li>

                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class="fas fa-user-tie"></i>
                         <span>Manage Suppliers</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="{{route('all.suppliers')}}">All Suppliers</a></li>
                     </ul>
                 </li>
                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class="fas fa-users"></i>
                         <span>Manage Customers</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="{{route('all.customers')}}">All Customers</a></li>
                         <li><a href="{{route('customers.credit')}}">Customers Credit </a></li>
                         <li><a href="{{route('customers.Paid')}}">Paid Customers</a></li>
                         <li><a href="{{route('customers.wise.report')}}">Customers Wise Report</a></li>

                     </ul>
                 </li>
                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class="fas fa-vial "></i>
                         <span>Manage Units</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="{{route('all.Units')}}">All Units</a></li>
                     </ul>
                 </li>
                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class="fas fa-layer-group"></i>
                         <span>Manage Brands</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="{{route('all.Brands')}}">All Brands</a></li>
                     </ul>
                 </li>
                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class=" fas fa-sign"></i>
                         <span>Manage Categories</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="{{route('all.Categories')}}">All Categories</a></li>
                     </ul>
                 </li>
                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class=" fas fa-box-open"></i>
                         <span>Manage Products</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="{{route('all.Products')}}">All Products</a></li>
                     </ul>
                 </li>
                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class=" fas fa-credit-card"></i>
                         <span>Manage Purchases</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="{{route('all.Purchases')}}">All Purchases</a></li>
                         <li><a href="{{route('all.Pending.Purchases')}}">Pending Purchases</a></li>
                         <li><a href="{{route('all.Purchases.search')}}">Search Purchases</a></li>

                     </ul>
                 </li>
                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class=" fas fa-credit-card"></i>
                         <span>Manage Order Forms</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="{{route('all.order.forms')}}">All Order Forms</a></li>


                     </ul>
                 </li>
                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class=" fas fa-credit-card"></i>
                         <span>Manage Qotations</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="{{route('all.quotations')}}">All Quotations</a></li>


                     </ul>
                 </li>
                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class=" fas fa-credit-card"></i>
                         <span>Delivery Receipt</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="{{route('all.delivery.receipt')}}">All Receipt</a></li>


                     </ul>
                 </li>
                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class=" fas fa-file-invoice-dollar"></i>
                         <span>Invoice Management</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="{{route('all.invoices')}}">All Invoices</a></li>
                         <li><a href="{{route('all.invoices.daily')}}">Daily Invoices Report</a></li>
                         <li><a href="{{route('all.pending.invoices')}}">Pending Invoices</a></li>
                         <li><a href="{{route('all.invoices.print')}}">Print Invoices</a></li>
                     </ul>
                 </li>
                 <li class="menu-title">Stock</li>

                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class="ri-account-circle-line"></i>
                         <span>Stock Management</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="{{route('stock.report')}}">Stock Report</a></li>
                         <li><a href="{{route('Search.Stock.supplier')}}">Suppliers/Products Search</a></li>

                     </ul>
                 </li>

                 <li class="menu-title">Admin Section</li>

                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class="ri-account-circle-line"></i>
                         <span>Roles Management</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">

                         <li><a href="{{route('all.roles')}}">All Roles</a></li>
                         <li><a href="{{route('view.rolespermissions')}}">Roles And Permissions</a></li>


                     </ul>
                 </li>
                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class="ri-account-circle-line"></i>
                         <span>Admin Management</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="{{route('all.admins')}}">All Admins</a></li>



                     </ul>
                 </li>








             </ul>
         </div>
         <!-- Sidebar -->
     </div>
 </div>