<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

// Precoding
// Route::get('/', function () {
//     return redirect()->route('dashboard');
// });
// 

Route::get('/', 'DashboardController@index')->name('dashboard');
Auth::routes();
// Front End Start

Route::post('data-insert', 'FrontEnd\MenuCardController@dataInsert')->name('data.insert');



Route::get('menu/{url}', 'FrontEnd\MenuCardController@index')->middleware('subscription');
Route::get('menu/takeaway/{url}', 'FrontEnd\MenuCardController@takeaway')->middleware('subscription');
Route::get('menu/{url}/cart', 'FrontEnd\MenuCardController@cart')->middleware('subscription');
Route::post('placeOrder/{slug}/{type}', 'FrontEnd\MenuCardController@placeOrder');

Route::middleware('ajaxCheck')->group(function(){
	// Cart controller
	Route::get('addCart/{id}/{type}', 'FrontEnd\CartController@addCart');
	Route::get('loadCart/{id}', 'FrontEnd\CartController@loadCart');
	Route::get('deleteCartItem/{id}/{itemId}', 'FrontEnd\CartController@deleteCartItem');
	Route::get('updateQty/{id}/{itemId}/{action}', 'FrontEnd\CartController@updateQty');
});

// Front End End

	// My Common Laravel start
	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('dashboard', 'DashboardController@index')->name('dashboard');
	
	// Route::get('dashboard/profile', 'ProfileController@index')->name('');
	// Route::get('dashboard/invoice', 'DashboardController@invoice')->name('');
	// Route::get('dashboard/permission', 'DashboardController@permission')->name('');

	// Route::get('dashboard/user', 'UserController@index')->name('');
	// Route::get('dashboard/user/add', 'UserController@add')->name('');
	// Route::get('dashboard/user/edit/{user}', 'UserController@edit')->name('');
	// Route::get('dashboard/user/view/{user}', 'UserController@view')->name('');
	// Route::post('dashboard/user/submit', 'UserController@insert')->name('');
	// Route::post('dashboard/user/update', 'UserController@update')->name('');
	// Route::post('dashboard/user/softdelete', 'UserController@softdelete')->name('');
	// Route::post('dashboard/user/restore', 'UserController@restore')->name('');
	// Route::post('dashboard/user/delete', 'UserController@delete')->name('');

	// Route::get('dashboard/recycle', 'RecycleController@index')->name('');
	// Route::get('dashboard/recycle/user', 'RecycleController@user')->name('');
	// My Common Laravel End

	// Restaurant Start

	Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'subscription']], function(){
		Route::get('settings', 'ProfileController@settings');
		Route::put('settings/{id}', 'ProfileController@profileSetting');
		// resources
		Route::group(['middleware' => 'any_role:Superadmin'], function () {
		    Route::resource('client', 'Admin\ClientController');
		    Route::resource('package', 'Admin\PackageController');
		    Route::get('edit-package/{id}', 'Admin\ClientController@editPackage');
		    Route::put('edit-package/{id}', 'Admin\ClientController@updatePackage');
		});

		Route::group(['middleware' => 'any_role:Superadmin,Admin,Manager'], function () {
		    Route::resource('restaurant', 'Admin\RestaurantController');
		});
		
		Route::group(['middleware' => 'any_role:Admin,Manager'], function () {
			// Order Controller
		    Route::get('delivered-order', 'Admin\OrderController@delivered');
		    Route::get('delivered-order/{slug}', 'Admin\OrderController@allDelivered');
		    Route::post('custom-order-report/{status}/{slug}', 'Admin\OrderController@customOrderReport');
		    Route::get('cancelled-order', 'Admin\OrderController@cancelled');
		    Route::get('cancelled-order/{slug}', 'Admin\OrderController@allCancelled');
		    // Report Controller
		    Route::get('report', 'Admin\ReportController@index');
		    Route::get('report/gateway/{gateway}', 'Admin\ReportController@gateway');

		    Route::get('report/{slug}', 'Admin\ReportController@report');
		    Route::post('custom-report/{slug}', 'Admin\ReportController@customReport');
		    Route::get('bill/invoice/{slug}', 'Admin\BillController@invoice');

		    //Expense Controller
		    Route::get('expense', 'Admin\ExpenseController@index');
		    Route::get('expense/gateway/{gateway}', 'Admin\ExpenseController@gateway');
		    Route::post('expense', 'Admin\ExpenseController@store');
		    Route::delete('expense/{id}','Admin\ExpenseController@destroy');
		    Route::put('expense/edit/{id}', 'Admin\ExpenseController@update');
		    Route::post('custom-expense-report/{slug}', 'Admin\ExpenseController@report');

			
			//Income Controller
		    Route::get('incomes', 'Admin\IncomeController@index');
		    Route::get('incomes/gateway/{gateway}', 'Admin\IncomeController@gateway');
		    Route::post('incomes', 'Admin\IncomeController@store');
		    Route::delete('incomes/{id}','Admin\IncomeController@destroy');
		    Route::put('incomes/edit/{id}', 'Admin\IncomeController@update');
		    Route::post('custom-incomes-report/{slug}', 'Admin\IncomeController@report');

		    //Restaurant Controller
		    Route::get('qrcode/{rstrt_slug}', 'Admin\RestaurantController@qrcode');
		});

		Route::group(['middleware' => 'any_role:Admin,Manager,Waiter'], function () {
		    Route::get('order-request', 'Admin\OrderController@orderRequest');
		    Route::post('order-request', 'Admin\OrderController@typrWiseorderRequest')->name('typrWiseOrderRequest');
		    Route::get('order-serve', 'Admin\OrderController@orderServe');
		    Route::post('order-serve', 'Admin\OrderController@typrWiseOrdeOrderServe')->name('typrWiseOrderServe');
		    Route::get('order-serve/{slug}', 'Admin\OrderController@allServe');
			Route::get('order-request/{slug}', 'Admin\OrderController@allRequest');
			Route::get('add-more/{slug}/{rstrt_slug}', 'Admin\OrderController@addMore');
		    Route::get('order-request/edit/{slug}', 'Admin\OrderController@editRequest');
		    Route::get('order-request/cart/{slug}', 'Admin\OrderController@editedCart');
		    Route::get('submit-edit/{slug}/{rstrt_slug}', 'Admin\OrderController@submitEdit');

		});

		Route::group(['middleware' => 'any_role:Admin,Manager,Chef'], function () {
		    Route::get('confirmed-order', 'Admin\OrderController@confirmed');
		    Route::post('confirmed-order', 'Admin\OrderController@typrWiseOrderConfirmed')->name('typrWiseOrderConfirmed');
			Route::get('confirmed-order/{slug}', 'Admin\OrderController@allConfirmed');
		});

		Route::group(['middleware' => 'any_role:Admin,Manager,Waiter,Chef'], function () {
		    Route::get('order-request/view/{slug}/{status}', 'Admin\OrderController@viewRequest');
		    Route::delete('order/{slug}','Admin\OrderController@destroy');
		});

		Route::group(['middleware' => 'any_role:Manager'], function () {
			// Bill Controller
		    Route::get('bill', 'Admin\BillController@index');
			Route::post('bill', 'Admin\BillController@typeWiseOrder')->name('typeWiseOrder.info');
		    Route::get('bill/view/{slug}', 'Admin\BillController@show');
		    Route::get('bill/pendings/{slug}', 'Admin\BillController@pendings');
		    Route::post('bill/pendings/{slug}', 'Admin\BillController@updateBill');
		    // Order Controller
		    Route::get('create-order', 'Admin\OrderController@createOrderByManager');
		    Route::post('cart', 'Admin\OrderController@cart')->name('cart.view.page');
		    // Route::get('cart/{rstrt_slug}', 'Admin\OrderController@cart');
		    Route::get('menucard/{rstrt_slug}', 'Admin\OrderController@menucard');
		    Route::get('place-order/{rstrt_slug}', 'Admin\OrderController@placeOrder');
		});

		Route::group(['middleware' => 'any_role:Admin'], function () {
			Route::get('statistics', 'DashboardController@statistics');
			Route::get('statistics/{slug}', 'DashboardController@restaurantStatistics');
		});

		

		Route::middleware('ajaxCheck')->group(function(){
			Route::group(['middleware' => 'any_role:Superadmin,Admin,Manager'], function () {
				// Restaurant Controller
			    Route::post('addCate/{slug}', 'Admin\RestaurantController@addCate');
			    Route::put('editCate/{id}', 'Admin\RestaurantController@updateCate');
			    Route::get('editCate/{id}', 'Admin\RestaurantController@editCate');
			    Route::post('restaurant/setting/{slug}', 'Admin\RestaurantController@setting');

			    // Menu controller
			    Route::get('all_menu/{slug}', 'Admin\MenuController@index');
			    Route::get('menu/create/{slug}', 'Admin\MenuController@create');
			    Route::get('menu/create/stock/{slug}', 'Admin\MenuController@createStock');
			    Route::post('menu/{slug}', 'Admin\MenuController@store');
			    Route::get('menu/edit/{id}', 'Admin\MenuController@edit');
			    Route::post('menu/edit/{id}', 'Admin\MenuController@update');
			    Route::get('menu/delete/{slug}/{id}', 'Admin\MenuController@destroy');

			    // Employee Controller
			    Route::get('employee/{slug}', 'Admin\EmployeeController@index');
			    Route::get('employee/create/{slug}', 'Admin\EmployeeController@create');
			    Route::post('employee/{slug}', 'Admin\EmployeeController@store');
			    Route::get('employee/edit/{id}', 'Admin\EmployeeController@edit');
			    Route::post('employee/edit/{id}', 'Admin\EmployeeController@update');
			    Route::get('employee/delete/{id}', 'Admin\EmployeeController@destroy');
			    Route::get('employee/inactivate/{id}', 'Admin\EmployeeController@inactivate');
			    Route::get('employee/activate/{id}', 'Admin\EmployeeController@activate');
			});

			// Order Controller
			Route::group(['middleware' => 'any_role:Admin,Manager,Waiter'], function () {
			    Route::get('order-request/data/{rstrtSlug}/{orderSlug}/{action}','Admin\OrderController@requestData');
			    Route::get('order-request/loadData/{slug}','Admin\OrderController@requestLoad');

			    Route::get('serve-order/data/{rstrtSlug}/{orderSlug}/{action}','Admin\OrderController@serveData');
			    Route::get('serve-order/loadData/{slug}','Admin\OrderController@serveLoad');

			    Route::get('updateQty/{itemId}/{action}', 'Admin\OrderController@updateQty');
			    Route::get('deleteCartItem/{itemId}', 'Admin\OrderController@deleteCartItem');

			    Route::get('cateItem/{id}/{rstrt_slug}/{type}', 'Admin\OrderController@cateItem');

			    Route::post('addToCart', 'Admin\OrderController@addToCartWithCrust');

			    Route::get('addToCart/{id}/{slug}', 'Admin\OrderController@addToCart');
			    Route::get('menu/for/addToCart/{id}/{slug}', 'Admin\OrderController@addToCartMenu');

			    Route::get('searchItem', 'Admin\OrderController@searchItem');
			});

			Route::group(['middleware' => 'any_role:Admin,Manager,Chef'], function () {
			    Route::get('confirmed-order/data/{rstrtSlug}/{orderSlug}/{action}','Admin\OrderController@confirmedData');
			    Route::get('confirmed-order/loadData/{slug}','Admin\OrderController@confirmedLoad');
			});

			// Bill Controller
			Route::group(['middleware' => 'any_role:Manager'], function () {
			    Route::post('bill/{slug}', 'Admin\BillController@create');
			});
			// Add Stock
			
		});
	});



	Route::group(['middleware' => 'any_role:Manager'], function () {
		Route::post('bill', 'Admin\BillController@create');
	});




	Route::middleware('auth')->prefix('dashboard')->group(function () {
		Route::get('category/add', 'Admin\CategoryController@add')->name('category.add');
		Route::get('category/edit/{id}', 'Admin\CategoryController@edit')->name('category.edit');
		Route::post('category/add', 'Admin\CategoryController@store')->name('category.store');
		Route::post('category/edit', 'Admin\CategoryController@update')->name('category.update');

	
		Route::get('brand/add', 'Admin\BrandController@add')->name('brand.add');
		Route::get('brand/edit/{id}', 'Admin\BrandController@edit')->name('brand.edit');
		Route::post('brand/add', 'Admin\BrandController@store')->name('brand.store');
		Route::post('brand/edit', 'Admin\BrandController@update')->name('brand.update');
		// ajax route
		Route::post('category-wise-brand', 'Admin\BrandController@categoryWiseBrand')->name('Category-wise-Brand');
		// ajax route

		Route::get('size/add', 'Admin\SizeController@add')->name('size.add');
		Route::get('size/edit/{id}', 'Admin\SizeController@edit')->name('size.edit');
		Route::post('size/add', 'Admin\SizeController@store')->name('size.store');
		Route::post('size/edit', 'Admin\SizeController@update')->name('size.update');
		// ajax route
		Route::post('brand-wise-size', 'Admin\SizeController@brandWiseSize')->name('Brand-wise-size');
		// ajax route
		// ajax route
		Route::post('size-wise-thickness', 'Admin\ThicknessController@sizeWiseThickness')->name('size-wise-thickness');
		// ajax route
	
		Route::get('stock/add', 'Admin\StockController@add')->name('stock.add');
		Route::get('stock/edit/{id}', 'Admin\StockController@edit')->name('stock.edit');
		Route::get('stock/getBrand/{id}', 'Admin\StockController@getBrand')->name('stock.getBrand');
		Route::get('stock/getSize/{id}', 'Admin\StockController@getSize')->name('stock.getSize');
		Route::get('stock/getThick/{id}', 'Admin\StockController@getThick')->name('stock.getThick');
		Route::post('stock/add', 'Admin\StockController@store')->name('stock.store');
		Route::post('stock/edit', 'Admin\StockController@update')->name('stock.update');
	});
	
