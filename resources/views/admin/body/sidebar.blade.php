 <div class="vertical-menu">

     <div data-simplebar class="h-100">

         <!-- User details -->
         <!--- Sidemenu -->
         <div id="sidebar-menu">
             <!-- Left Menu Start -->
             <ul class="metismenu list-unstyled" id="side-menu">
                 <li class="menu-title">{{ __("Menu") }}</li>

                 <li>
                     <a href="{{ route('dashboard') }}" class="waves-effect">
                         <i class="ri-dashboard-line"></i>
                         <span>{{ __("Dashboard") }}</span>
                     </a>
                 </li>

                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class="fas fa-user-tie"></i>
                         <span>{{ __("Manage Suppliers") }}</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="{{route('all.suppliers')}}">{{ __("All Suppliers") }}</a></li>
                     </ul>
                 </li>
                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class="fas fa-users"></i>
                         <span>{{ __("Manage Customers") }}</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="{{route('all.customers')}}">{{ __("All Customers") }}</a></li>
                         <li><a href="{{route('customers.credit')}}">{{ __("Customers Credit") }} </a></li>
                         <li><a href="{{route('customers.Paid')}}">{{ __("Customers Payments") }}</a></li>
                         <li><a href="{{route('customers.wise.report')}}">{{ __("Customers Wise Report") }}</a></li>

                     </ul>
                 </li>
                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class="fas fa-vial "></i>
                         <span>{{ __("Manage Units") }}</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="{{route('all.Units')}}">{{ __("All Units") }}</a></li>
                     </ul>
                 </li>
                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class="fas fa-layer-group"></i>
                         <span>{{ __("Manage Brands") }}</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="{{route('all.Brands')}}">{{ __("All Brands") }}</a></li>
                     </ul>
                 </li>
                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class=" fas fa-sign"></i>
                         <span>{{ __("Manage Categories") }}</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="{{route('all.Categories')}}">{{ __("All Categories") }}</a></li>
                     </ul>
                 </li>
                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class="ri-shopping-basket-2-fill"></i>
                         <span>{{ __("Manage Products") }}</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="{{route('all.Products')}}">{{ __("All Products") }}</a></li>
                     </ul>
                 </li>
                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class="ri-shopping-cart-2-fill"></i>
                         <span>{{ __("Manage Purchases") }}</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="{{route('all.Purchases')}}">{{ __("All Purchases") }}</a></li>
                         <li><a href="{{route('all.Pending.Purchases')}}">{{ __("Pending Purchases") }}</a></li>
                         <li><a href="{{route('all.Purchases.search')}}">{{ __("Search Purchases") }}</a></li>

                     </ul>
                 </li>
                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class="ri-survey-fill"></i>
                         <span>{{ __("Manage Order Forms") }}</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="{{route('all.order.forms')}}">{{ __("All Order Forms") }}</a></li>


                     </ul>
                 </li>
                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class="ri-file-2-fill"></i>
                         <span>{{ __("Manage Qotations") }}</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="{{route('all.quotations')}}">{{ __("All Quotations") }}</a></li>


                     </ul>
                 </li>
                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class="ri-truck-fill"></i>
                         <span>{{ __("Delivery Receipt") }}</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="{{route('all.delivery.receipt')}}">{{ __("All Receipt") }}</a></li>


                     </ul>
                 </li>
                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class=" fas fa-file-invoice-dollar"></i>
                         <span>{{ __("Invoice Management") }}</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="{{route('all.invoices')}}">{{ __("All Invoices") }}</a></li>
                         <li><a href="{{route('all.invoices.daily')}}">{{ __("Daily Invoices Report") }}</a></li>
                         <li><a href="{{route('all.pending.invoices')}}">{{ __("Pending Invoices") }}</a></li>

                     </ul>
                 </li>
                 <li class="menu-title">{{ __("Stock") }}</li>

                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class="fas fa-box-open"></i>
                         <span>{{ __("Stock Management") }}</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="{{route('stock.report')}}">{{ __("Stock Report") }}</a></li>
                         <li><a href="{{route('Search.Stock.supplier')}}">{{ __("Suppliers/Products Search") }}</a></li>

                     </ul>
                 </li>

                 <li class="menu-title">{{ __("Admin Section") }}</li>

                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class=" ri-vip-crown-2-fill"></i>
                         <span>{{ __("Roles Management") }}</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">

                         <li><a href="{{route('all.roles')}}">{{ __("All Roles") }}</a></li>
                         <li><a href="{{route('view.rolespermissions')}}">{{ __("Roles And Permissions") }}</a></li>


                     </ul>
                 </li>
                 <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                         <i class="ri-user-star-fill"></i>
                         <span>{{ __('Admin Management') }}</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                         <li><a href="{{route('all.admins')}}">{{ __("All Admins") }}</a></li>



                     </ul>
                 </li>

             </ul>
         </div>
         <!-- Sidebar -->
     </div>
 </div>