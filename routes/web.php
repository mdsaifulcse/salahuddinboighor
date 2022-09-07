<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/login/admin', 'Auth\LoginController@showAdminLoginForm');
Route::get('/login/staff', 'Auth\LoginController@showStaffLoginForm');

Route::post('/login/staff', 'Auth\LoginController@staffLogin');
Route::post('/login/admin', 'Auth\LoginController@adminLogin');

Route::get('/load-sub-head-by-head/{headId}', '\App\CustomFacades\DataLoadController@loadSubHeadsByHeadId');

Route::get('/load-sub-cat-by-cat/{categoryId}', '\App\CustomFacades\DataLoadController@loadSubCatsByCat');
Route::get('/load-third-sub-cat-by-sub-cat/{subCategoryId}', '\App\CustomFacades\DataLoadController@loadThirdSubCatsByCat');
Route::get('/load-fourth-sub-cat-by-third-sub-cat/{thirdSubCategoryId}', '\App\CustomFacades\DataLoadController@loadFourthSubCatsByCat');

Route::get('load-purchase-number-by-vendor/{vendorId}','\App\CustomFacades\DataLoadController@loadPurchaseNumbersByVendor');
Route::get('load-purchase-info-by-purchase-id-to-return/{purchaseId}','\App\Http\Controllers\Admin\PurchaseReturnController@getPurchaseInfoByPurchaseId');

// ----------- Admin System Area  ------------
Route::group(['middleware' => ['auth'],'namespace'=>'Admin','prefix' => 'admin'], function() {

//    Route::get('demo-route',function (){
//        return view('admin.demo-view');
//    });

    Route::get('/home', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('home');

    /*-- Sale Return Related --*/
     Route::resource('sale-return','SaleReturnController');//->middleware('permission:sale-return-list|sale-return-create|sale-return-edit|sale-return-delete');
     Route::get('sale-return-data','SaleReturnController@getSaleReturnData');//->middleware('permission:sale-return-list|sale-return-create|sale-return-edit|sale-return-delete');
     Route::get('load-order-detail-by-orderid/{orderId}','SaleReturnController@getOrderDetailData');//->middleware('permission:sale-return-list|sale-return-create|sale-return-edit|sale-return-delete');

    /*---  Order Delivery  ---*/
    Route::resource('order-assign','OrderDelivery\OrderAssignDeliveryController');//->middleware('permission:order-delivery-list|order-delivery-create|order-delivery-edit|order-delivery-delete');
    Route::get('order-assign-data','OrderDelivery\OrderAssignDeliveryController@getOrderAssignData');//->middleware('permission:order-delivery-list|order-delivery-create|order-delivery-edit|order-delivery-delete');
    Route::get('search-order-by-orderId','OrderDelivery\OrderAssignDeliveryController@getOrderDataByOrderId');//->middleware('permission:order-delivery-list|order-delivery-create|order-delivery-edit|order-delivery-delete');

    /*-- Order Related --*/
    Route::get('/orders-recent','OrderManagementController@recentOrders');//->middleware('permission:order-list|order-create|order-edit|order-delete');

    Route::get('/orders-search','OrderManagementController@orderSearch');//->middleware('permission:order-list|order-create|order-edit|order-delete');

    Route::get('/orders','OrderManagementController@index')->middleware('permission:order-list|order-create|order-edit|order-delete');
    Route::get('/orders/history-data','OrderManagementController@create');//->middleware('permission:order-list|order-create|order-edit|order-delete');

    Route::get('/orders/{orderId}','OrderManagementController@show');//->middleware('permission:order-list|order-create|order-edit|order-delete');
    Route::get('/orders/edit/{orderId}','OrderManagementController@edit');//->middleware('permission:order-list|order-create|order-edit|order-delete');
    Route::put('/orders/update/{orderId}','OrderManagementController@update')->name('admin.orders.update');//->middleware('permission:order-list|order-create|order-edit|order-delete');
    Route::delete('/orders/remove/{orderId}','OrderManagementController@destroy')->name('admin.orders.remove');//->middleware('permission:order-list|order-create|order-edit|order-delete');

    /*  Adjustment Product ----------   */
    Route::resource('product-adjustment','AdjustMentController');//->middleware('permission:product-adjustment-list|product-adjustment-create|product-adjustment-edit|product-adjustment-delete');
    Route::get('product-adjustment-data','AdjustMentController@getProductPurchaseData');//->middleware('permission:product-adjustment-list|product-adjustment-create|product-adjustment-edit|product-adjustment-delete');

    Route::get('search-products-for-adjustment','AdjustMentController@getProductData');//->middleware('permission:product-adjustment-list|product-adjustment-create|product-adjustment-edit|product-adjustment-delete');

    Route::get('add-product-to-adjustment-list','AdjustMentController@addProductToAdjustmentList');//->middleware('permission:product-adjustment-list|product-adjustment-create|product-adjustment-edit|product-adjustment-delete');

    Route::get('remove-product-from-adjustment-list-update','AdjustMentController@removeProductFromUpdateAdjustmentList');//->middleware('permission:product-adjustment-list|product-adjustment-create|product-adjustment-edit|product-adjustment-delete');
    Route::get('remove-product-from-adjustment-list','AdjustMentController@removeProductFromAdjustmentList');//->middleware('permission:product-adjustment-list|product-adjustment-create|product-adjustment-edit|product-adjustment-delete');

    /*-- Product --*/
    Route::resource('products','ProductController');//->middleware('permission:product-list|product-create|product-edit|product-delete');
    Route::get('get-products','ProductController@getProductData')->middleware('permission:product-list');

    /*-- Product Report --*/
    Route::get('inventory-stock-report','InventoryReportController@getInventoryStockReport')->middleware('permission:product-list');
    Route::get('search-products-for-inventory-report','InventoryReportController@getProductData')->middleware('permission:product-list');

    /*-- Supplier / Vendor Payment --*/
    Route::resource('vendor-payments','VendorPaymentController');//->middleware('permission:vendor-payment-list|vendor-payment-create|vendor-payment-edit|vendor-payment-delete');
    Route::get('calculate-vendor-remaining-due/{vendorId}','VendorPaymentController@vendorRemainingDueCalculation');//->middleware('permission:vendor-payment-list|vendor-payment-create|vendor-payment-edit|vendor-payment-delete');
    Route::get('vendor-payments-data','VendorPaymentController@getVendorPaymentData');//->middleware('permission:vendor-payment-list|vendor-payment-create|vendor-payment-edit|vendor-payment-delete');
    Route::get('vendor-payments-report','VendorPaymentController@paymentReport');//->middleware('permission:vendor-payments-report');

    Route::resource('vendors','VendorController')->middleware('permission:vendor-list|vendor-create|vendor-list-edit|vendor-delete');
    Route::get('vendors-data','VendorController@getVendorData');//->middleware('permission:vendors');


    /*   Product Purchasing  Return----------   */
    Route::resource('purchase-return','PurchaseReturnController');//->middleware('permission:purchase-return-list|purchase-return-create|purchase-return-edit|purchase-return-delete');
    Route::get('purchase-return-data','PurchaseReturnController@getPurchaseReturnData');//->middleware('permission:product-purchase-list|product-purchase-create|product-purchase-edit|product-purchase-delete');

    /*   Product Purchasing ----------   */
    Route::resource('product-purchases','ProductPurchaseController');//->middleware('permission:product-purchases');
    Route::get('product-purchases-data','ProductPurchaseController@getProductPurchaseData');//->middleware('permission:product-purchases');

    Route::get('search-products','ProductPurchaseController@getProductData');//->middleware('permission:product-purchases');

    Route::get('add-product-to-purchase-list','ProductPurchaseController@addProductToPurchaseList');//->middleware('permission:product-purchases');

    Route::get('remove-product-from-purchase-list-update','ProductPurchaseController@removeProductFromUpdatePurchaseList');//->middleware('permission:product-purchases');
    Route::get('remove-product-from-purchase-list','ProductPurchaseController@removeProductFromPurchaseList');//->middleware('permission:product-purchases');

    /*  Income Expense   */
    Route::resource('expenditures','ExpenditureController');//->middleware('permission:expenditure-list|expenditure-create|expenditure-edit|expenditure-delete');
    Route::get('expenditures-data','ExpenditureController@getExpenditureData');//->middleware('permission:expenditure-list|expenditure-create|expenditure-edit|expenditure-delete');
    Route::get('expenditures-report','ExpenditureController@createExpenditureReport');//->middleware('permission:expenditures-report');

    Route::resource('bank-accounts','BankAccountController');//->middleware('permission:bank-accounts');
    Route::resource('income-expense-heads','IncomeExpenseHeadController')->middleware('permission:income-expense-heads');
    Route::resource('income-expense-sub-heads','IncomeExpenseSubHeadController')->middleware('permission:income-expense-sub-heads');


    Route::resource('shipping-method','ShippingMethodController')->middleware('permission:shipping-method');
    Route::resource('biggapons','BiggaponController')->middleware('permission:biggapons');
    Route::resource('client','OurClientController')->middleware('permission:client');
    Route::resource('faq','FaqController')->middleware('permission:faq');
    Route::resource('testimonial','TestimonialController')->middleware('permission:testimonial');
    Route::resource('social-icon','SocialIconController')->middleware('permission:social-icon');
    Route::resource('slider','SliderController')->middleware('permission:slider');

    Route::resource('districts','DistrictController')->middleware('permission:districts');
    Route::resource('divisions','DivisionController')->middleware('permission:divisions');
    Route::resource('countries','CountryController');//->middleware('permission:countries');
    Route::resource('languages','LanguageController');//->middleware('permission:languages');


    Route::resource('size-units','PackSizeUnitController')->middleware('permission:size-units');
    Route::resource('length-units','LengthUnitController')->middleware('permission:length-units');
    Route::resource('weight-units','WeightUnitController')->middleware('permission:weight-units');
    Route::resource('collections','CollectionController')->middleware('permission:collections');
    Route::resource('attributes','AttributeController')->middleware('permission:attributes');

    Route::resource('vat-taxes','VatTaxController')->middleware('permission:vat-taxes');
    Route::resource('tags','TagController')->middleware('permission:tags');
    Route::resource('origins','OriginController')->middleware('permission:origins');
    Route::resource('brands','BrandController')->middleware('permission:brand');

    Route::resource('categories','CategoryController')->middleware('permission:categories');
    Route::resource('sub-categories','SubCategoryController')->middleware('permission:sub-categories');
    Route::resource('third-sub-categories','ThirdSubCategoryController');//->middleware('permission:third-sub-categories');
    Route::resource('fourth-sub-categories','FourthSubCategoryController')->middleware('permission:fourth-sub-categories');

    Route::resource('publishers','PublisherController');//->middleware('permission:publishers');
    Route::get('get-publishers','PublisherController@getpublishersData');//->middleware('permission:pages');

    Route::resource('authors','AuthorController');//->middleware('permission:authors');
    Route::get('get-authors','AuthorController@getAuthorsData');//->middleware('permission:pages');

    Route::resource('pages','PageController')->middleware('permission:pages');


    Route::resource('setting','SettingController')->middleware('permission:setting');

    Route::get('/password', 'ProfileController@changeMyPassword');
    Route::post('/password-change', 'ProfileController@resetMyPassword');

    Route::get('/profile', 'ProfileController@myProfile');
    Route::post('/profile-update', 'ProfileController@updateMyProfile');

    Route::resource('customers','ClientController')->middleware('permission:customers-list|customers-create|customers-edit|customers-delete');
    Route::get('customers-data','ClientController@getCustomerDataList')->middleware('permission:customers-list|customers-create|customers-edit|customers-delete');

    Route::get('/user-password/{userId}', 'UserController@changeUserPassword')->middleware('permission:user-list|user-create|user-edit|user-delete');
    Route::put('/user-password', 'UserController@resetUserPassword')->name('user-password.change')->middleware('permission:user-list|user-create|user-edit|user-delete');

    Route::resource('users','UserController')->middleware('permission:user-list|user-create|user-edit|user-delete');
    Route::resource('news-letters','NewsLetterController')->middleware('permission:news-letters');

});
Route::group(['middleware' => ['auth'],'namespace'=>'Menu','prefix' => 'admin'], function() {

    Route::resource('menu','MenuController')->middleware('permission:menu');
    Route::resource('sub-menu','SubMenuController')->middleware('permission:menu');
    Route::resource('sub-sub-menu','SubSubMenuController')->middleware('permission:menu');

});
Route::group(['middleware' => ['auth'],'namespace'=>'Spatie','prefix' => 'admin'], function() {

    Route::resource('roles','RoleController')->middleware('permission:role-list|role-create|role-edit|role-delete');
    Route::resource('permission','AclPermissionController')->middleware('role:developer');

});

// ----------- Delivery System Area  ------------
Route::group(['middleware' => ['auth'],'namespace'=>'OrderDelivery','prefix' => 'order-delivery'], function() {

    Route::get('dashboard','DashboardController@dashboard')->middleware('permission:delivery-dashboard');
    Route::get('order-assign-to-me','DashboardController@index')->middleware('permission:delivery-dashboard');
    Route::get('order-assign-to-me-data','DashboardController@getOrderAssignData')->middleware('permission:delivery-dashboard');
    Route::get('order-assign-to-me-show/{orderAssignId}','DashboardController@changeDeliveryStatus')->middleware('permission:delivery-dashboard');
    Route::post('order-assign-to-me-update-order-status','DashboardController@updateDeliveryStatus')->middleware('permission:delivery-dashboard');

    Route::get('order-detail/{id}','\App\Http\Controllers\Admin\OrderManagementController@show');

});


Auth::routes([
    'register' => true, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

// -------------  Client Area  -----------------
Route::get('clear-all','CacheClearController@clearAllAndReset');
Route::get('/register.html', 'Auth\RegisterController@showRegistrationForm');

Route::post('news-letter-save','Admin\NewsLetterController@store');

Route::group(['namespace'=>'Client\userResource','middleware' => ['auth','client']], function() {

    Route::get('account/account','UserDashboardController@index')->middleware('role:general-customer');
    Route::get('account/password','ProfileController@changeMyPassword')->middleware('role:general-customer');
    Route::post('account/password','ProfileController@updateMyPassword')->name('account.password')->middleware('role:general-customer');

    Route::get('account/profile','ProfileController@myProfile')->middleware('role:general-customer');
    Route::post('account/profile','ProfileController@updateMyProfile')->name('account.profile')->middleware('role:general-customer');
});


Route::group(['namespace'=>'Client','middleware' => ['auth','client']], function() {

    Route::get('orders/history','FrontendOrderController@index');
    Route::get('orders/create','FrontendOrderController@create');

    Route::get('orders/{orderId}','FrontendOrderController@show');
    Route::delete('orders/remove/{orderId}','FrontendOrderController@destroy')->name('orders.remove');
    Route::post('orders/confirm','FrontendOrderController@store')->name('orders.confirm');

    Route::get('checkout/add-shipping-cost/{shippingId}','CheckoutController@addShippingCost');
    Route::get('checkout/product-update/{id}/{qty}/{shippingId?}','CheckoutController@update');
    Route::get('checkout/product-delete/{id}/{shippingId?}','CheckoutController@destroy');
    Route::get('checkout/checkout','CheckoutController@showCheckOutPage');

    Route::post('product-rating','ProductReviewController@store')->name('product.rating');//->middleware('role:general-customer');

});


Route::group(['namespace'=>'Client'], function() {


    Route::resource('cart-products','CartProductController');//->middleware('role:general-customer');
    Route::get('wish-list-products','CartProductController@getWithListProducts');//->middleware('role:general-customer');

    Route::get('/', 'HomeController@index');

    Route::get('/archive', 'ArchiveController@archiveNews');

    Route::get('/about-us.html', 'PageController@aboutUs');

    Route::get('/contact.htm', 'PageController@contactUs');

    Route::post('/user-feedback', 'PageController@saveUserFeedBack');

    Route::get('/page/{link}', 'PageController@pageView');

    Route::get('/topic/{topic}', 'CategoryNewsController@topicalNews');

    Route::get('/book/details/{productId}/{productName?}', 'SearchProductController@singleProductDetails');

    Route::get('/book/category/{categoryId?}', 'SearchProductController@index');
    Route::get('/book/categories', 'SearchProductController@categoryListShow');
    Route::get('/book/search-category', 'SearchProductController@returnCategoryData');

    Route::get('/book/author/{authorId?}', 'SearchAuthorBooksController@index');
    Route::get('/book/authors', 'SearchAuthorBooksController@authorListShow');
    Route::get('/book/search-author', 'SearchAuthorBooksController@returnAuthorData');

    Route::get('/book-search', 'SearchProductController@searchProduct')->name('book.search');

});




//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
