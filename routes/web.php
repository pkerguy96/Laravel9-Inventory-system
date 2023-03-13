<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Demo\DemoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\sop\BrandsController;
use App\Http\Controllers\sop\CategoryController;
use App\Http\Controllers\sop\CustomerController;
use App\Http\Controllers\sop\DeliveryController;
use App\Http\Controllers\sop\FetchController;
use App\Http\Controllers\sop\InvoiceController;
use App\Http\Controllers\sop\ProductController;
use App\Http\Controllers\sop\PurchaseController;
use App\Http\Controllers\sop\StockController;
use App\Http\Controllers\sop\SupplierController;
use App\Http\Controllers\sop\UnitController;
use App\Models\DeliveryReceipt;
use App\Models\Invoice;

Route::get('/', function () {
    return view('welcome');
});


route::middleware('auth')->group(function () {

    // All Admin Routes 
    Route::controller(AdminController::class)->group(function () {
        Route::get('/admin/logout', 'destroy')->name('admin.logout');
        Route::get('/admin/profile', 'Profile')->name('admin.profile');
        Route::get('/edit/profile', 'EditProfile')->name('edit.profile');
        Route::post('/store/profile', 'StoreProfile')->name('store.profile');

        Route::get('/change/password', 'ChangePassword')->name('change.password');
        Route::post('/update/password', 'UpdatePassword')->name('update.password');
    });

    /* All Suppliers Routes here: */
    Route::controller(SupplierController::class)->group(function () {
        /* Get all suppliers */
        Route::get('/suplliers/all', 'Allsuppliers')->name('all.suppliers');
        /* Add new supplier */
        Route::get('/supplier/add', 'Addsupplier')->name('add.supplier');
        /* stores new supplier */
        Route::post('/supplier/store', 'Storesupplier')->name('append.supplier');
        /* edit supplier page */
        Route::get('/supplier/edit/{id}', 'EditSupplier')->name('edit.supplier');
        /* modify supplier  */
        Route::post('/supplier/modify', 'ModifySupplier')->name('modify.supplier');
        /* delete supplier */
        Route::get('/supplier/delete/{id}', 'DeleteSupplier')->name('delete.supplier');
    });

    /* All Customers Routes here: */
    Route::controller(CustomerController::class)->group(function () {
        /* Get all customers */
        Route::get('/customers/all', 'Allcustomers')->name('all.customers');
        /* Add new customer */
        Route::get('/customers/add', 'AddCustomer')->name('add.customer');
        /* stores new supplier */
        Route::post('/customers/store', 'StoreCustomer')->name('append.customer');
        /* edit customer page */
        Route::get('/customers/edit/{id}', 'EditCustomer')->name('edit.customer');
        /* modify supplier  */
        Route::post('/customers/modify', 'ModifyCustomer')->name('modify.customer');
        /* delete supplier */
        Route::get('/customers/delete/{id}', 'DeleteCustomer')->name('delete.customer');
        Route::get('/customers/credit', 'CustomersCredit')->name('customers.credit');
        /* print pdf ccustomers */
        Route::get('/customers/Print/Pdf', 'CustomersPrintPdf')->name('customer.pdf.print');
        Route::get('/customers/Invoice/Edit/{inv_id}', 'EditCustomersInvoice')->name('edit.customer.invoice');
        /* update customer payement invoice  */
        Route::post('/customers/Invoice/Payment/{inv_id}', 'UpdateCustomerPayement')->name('update.customer.payement');
        /* customer customer invoices details */
        Route::get('/customers/Invoice/details/{inv_id}', 'InvoicesDetailsCustomers')->name('customer.invoices.detail');
        Route::get('/customers/Paid', 'Allpaidcustomers')->name('customers.Paid');
        Route::get('/customers/print/paid/pdf', 'PrintCustomersPaid')->name('print.paid.customers');
        /* Customers Wise report route  */
        Route::get('/customers/wise/report', 'CustomerWiseReports')->name('customers.wise.report');
        /* grabs all customers with credit due not paid */
        Route::get('/customers/wise/credit/report', 'CustomerWisecredit')->name('customers.wise.credit.report');
        /* grabs all paid customers data */
        Route::get('/customers/wise/payment/report', 'CustomerWisepayement')->name('customers.wise.payement.report');
    });
    /* All unit Routes here: */
    Route::controller(UnitController::class)->group(function () {
        /* Get all Units */
        Route::get('/units/all', 'Allunits')->name('all.Units');;
        /* Add new unit */
        Route::get('/units/add', 'AddUnit')->name('add.unit');
        /* stores new unit */
        Route::post('/units/store', 'StoreUnit')->name('append.unit');
        /* edit unit page */
        Route::get('/units/edit/{id}', 'EditUnit')->name('edit.unit');
        /* modify supplier  */
        Route::post('/units/modify', 'ModifyUnit')->name('modify.unit');
        /* delete supplier */
        Route::get('/units/delete/{id}', 'DeleteUnit')->name('delete.unit');
    });
    /* All Categories Routes here: */
    Route::controller(CategoryController::class)->group(function () {
        /* Get all Categories */
        Route::get('/categories/all', 'AllCategories')->name('all.Categories');
        /* Add new Category */
        Route::get('/categories/add', 'Addcategory')->name('add.category');
        /* stores new Category */
        Route::post('/categories/store', 'Storecategory')->name('append.category');
        /* edit unit page */
        Route::get('/categories/edit/{id}', 'Editcategory')->name('edit.category');
        /* modify supplier  */
        Route::post('/categories/modify', 'Modifycategory')->name('modify.category');
        /* delete supplier */
        Route::get('/categories/delete/{id}', 'Deletecategory')->name('delete.category');
    });
    /* All Products Routes here: */
    Route::controller(ProductController::class)->group(function () {
        /* Get all Products */
        Route::get('/Products/all', 'AllProducts')->name('all.Products');;
        /* Add new Products */
        Route::get('/Products/add', 'Addproduct')->name('add.product');
        /* stores new Products */
        Route::post('/Products/store', 'Storeproduct')->name('append.product');
        /* edit Products page */
        Route::get('/Products/edit/{id}', 'Editproduct')->name('edit.product');
        /* modify Products  */
        Route::post('/Products/modify', 'Modifyproduct')->name('modify.product');
        /* delete supplier */
        Route::get('/Products/delete/{id}', 'Deleteproduct')->name('delete.product');
    });

    /* All Products Purchases here: */
    Route::controller(PurchaseController::class)->group(function () {
        /* Get all Purchases */
        Route::get('/Purchases/all', 'AllPurchases')->name('all.Purchases');
        /* Add new Purchases */
        Route::get('/Purchases/add', 'Addpurchase')->name('add.purchase');
        /* stores purchase */
        Route::post('/Purchases/store', 'storepurchase')->name('store.purchase');
        Route::get('/Purchases/delete/{id}', 'Deletepurchase')->name('delete.purchase');
        Route::get('/Purchases/Pending/purchase', 'Pendingpurchase')->name('all.Pending.Purchases');
        Route::get('/Purchases/approve/purchase/{id}', 'approvepurchase')->name('approve.purchase');
        Route::get('/Purchases/Search/', 'SearchPurchases')->name('all.Purchases.search');
        Route::get('/Purchases/Search/Pdf', 'SearchPurchasesPdfPage')->name('search.date.purchases');
        /* get purchases details */
        Route::get('/Purchases/details/{id}', 'ViewPurchasesDetails')->name('Purchases.details');
    });
    /* All  Invoices REQUESTS here: */
    Route::controller(InvoiceController::class)->group(function () {
        /* Get all Invoices */
        Route::get('/Invoices/All', 'AllInvoices')->name('all.invoices');
        Route::get('/Invoices/Add', 'AddInvoices')->name('add.invoice');
        Route::post('/Invoices/Store', 'storeInvoices')->name('store.invoice');
        Route::get('/Invoices/Pending', 'PendingInvoices')->name('all.pending.invoices');
        Route::get('/Invoices/delete/{id}', 'DeleteInvoices')->name('delete.invoice');
        Route::get('/Invoices/Approve/{id}', 'ApproveInvoices')->name('Approve.invoice');
        Route::post('/Invoices/Accept/{id}', 'AcceptInvoices')->name('accept.invoice');
        Route::get('/Invoices/Print/page', 'PrintInvoicePage')->name('all.invoices.print');
        Route::get('/Invoices/Report/daily', 'DailyInvoicePage')->name('all.invoices.daily');
        Route::get('/Invoices/Daily/search', 'SearchByDateInvoice')->name('search.date.invoice');
        Route::get('/Invoices/Print/{id}', 'PrintInvoice')->name('Print.invoice');
        /* print client invoice */
        Route::get('/Invoices/Print/client/{id}', 'PrintClientInvoice')->name('Print.invoice.client');
    });



    /* All stocks routs */
    Route::controller(StockController::class)->group(function () {
        Route::get('/Stock/Report', 'Stockreport')->name('stock.report');
        Route::get('/Stock/Print/Report', 'PrintStockreport')->name('print.stock.report.pdf');
        Route::get('/Stock/search/filter', 'Searchbysuporstock')->name('Search.Stock.supplier');
        Route::get('/Stock/supplier/filter', 'Searchbysupplier')->name('supplier.report.pdf');
        Route::get('/Stock/product/filter', 'Searchbyproduct')->name('product.report.pdf');
    });

    /* All brands routes here */
    Route::controller(BrandsController::class)->group(function () {
        Route::get('/All/Brands', 'Allbrands')->name('all.Brands');
        Route::get('/Add/Brands', 'AddBrand')->name('add.brand');
        /* store new brand */
        Route::post('/Store/Brands', 'StoreBrand')->name('append.brand');
        /* Edit brand view */
        Route::get('/Brands/Edit/{id}', 'EditBrand')->name('edit.Brand');
        /* Edit brand */
        Route::post('/Modify/Brands', 'ModifyBrand')->name('modify.Brand');
        /* delete brand */
        Route::get('/Brands/delete/{id}', 'Deletebrand')->name('delete.brand');
    });

    Route::controller(DeliveryController::class)->group(function () {
        Route::get('/All/delivery', 'Alldelivery')->name('all.delivery.receipt');
        Route::get('/add/delivery', 'AddDelivery')->name('add.delivery');
        Route::post('/store/delivery', 'storedevlivery')->name('store.delivery');
        Route::get('/print/delivery/{id}', 'PrintDelivery')->name('print.delivery');
        Route::get('/delete/delivery/{id}', 'DeleteDelivery')->name('delete.delivery');
    });


    /* All API FETCH REQUESTS here: */
    Route::controller(FetchController::class)->group(function () {
        /* Get all categories when person clicks select */
        Route::get('/fetch-category', 'FetchCategory')->name('fetch-category');
        /* Get all products when person clicks select */
        Route::get('/fetch-product', 'FetchProduct')->name('fetch-product');
        /* Get product stock */
        Route::get('/get-product-info', 'ProductStock')->name('get-product-info');
        /* get customers delivery receipt in invoice */
        Route::get('/get-delivery-slip', 'CustomerDelivery')->name('get-customer-delivery-receipt');
    });



    /* Language routes here */
    Route::get('{prefix?}/language/{locale}', function ($locale) {
        app()->setLocale($locale);
        session()->put('locale', $locale);
        return redirect()->back();
    })->where('prefix', '.*');

    Route::get('language/{locale}', function ($locale) {
        app()->setLocale($locale);
        session()->put('locale', $locale);
        return redirect()->back();
    });
});

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';


// Route::get('/contact', function () {
//     return view('contact');
// });
