<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\client\ClientController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\CustomerController;
use App\Http\Controllers\admin\SubcategoryController;
use App\Http\Controllers\admin\DiscountController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\client\UserController;
use App\Http\Controllers\admin\OrderController;

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



/*
/
/   ADMIN ROUTE
/
*/

//IS ADMIN NEED LOGIN
Route::middleware(['isadminneedlogged'])->group(function () {
    Route::get('/admin/login', [AdminController::class, 'login']);
    Route::post('/admin/login', [AdminController::class, 'loginValidate']);
});
// IS ADMIN ALREADY LOGGED
Route::middleware(['isadminlogged'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index']);
    Route::get('/admin/logout', [AdminController::class, 'logout']);
    Route::get('/admin/settings', [AdminController::class, 'settings']);
    Route::post('/admin/settings', [AdminController::class, 'updateSettings']);
    Route::get('/admin/category', [CategoryController::class, 'index']);
    Route::get('/admin/category/add/{id?}', [CategoryController::class, 'add']);
    Route::get('/admin/category/delete/{id}', [CategoryController::class, 'delete']);
    Route::post('/admin/category/add', [CategoryController::class, 'save']);
    Route::get('admin/subcategory', [SubcategoryController::class, 'index']);
    Route::get('admin/subcategory/add/{id?}', [SubcategoryController::class, 'add']);
    Route::get('admin/subcategory/delete/{id}', [SubcategoryController::class, 'delete']);
    Route::post('/admin/subcategory/add', [SubcategoryController::class, 'save']);
    Route::get('admin/discount', [DiscountController::class, 'index']);
    Route::get('admin/discount/add/{id?}', [DiscountController::class, 'add']);
    Route::post('admin/discount/add', [DiscountController::class, 'save']);
    Route::get('/admin/discount/delete/{id}', [DiscountController::class, 'delete']);
    Route::get('admin/product', [ProductController::class, 'index']);
    Route::get('admin/product/add/{id?}', [ProductController::class, 'add']);
    Route::post('admin/product/add', [ProductController::class, 'save']);
    Route::get('/admin/product/delete/{id}', [ProductController::class, 'delete']);
    Route::post('/admin/subcategory/get', [ProductController::class, 'get_subcategory']);
    Route::get('/admin/customer',[CustomerController::class,'index']);
    Route::get('/admin/customer/edit/{id}',[CustomerController::class,'edit']);
    Route::post('/admin/customer/edit',[CustomerController::class,'edit_customer']);
    Route::post('/admin/customer/edit_address',[CustomerController::class,'edit_address']);
    Route::get('/admin/customer/delete/{id}',[CustomerController::class,'delete']);
    Route::get('/admin/customer/order/{id}',[CustomerController::class,'order']);
    Route::post('/admin/order/cancel',[OrderController::class,'cancel']);
    Route::get('/admin/order/delete/{id}',[OrderController::class,'delete']);
    Route::get('admin/order',[OrderController::class,'index']);
    Route::get('admin/order/edit/{id}',[OrderController::class,'edit']);
    Route::post('admin/order/edit',[OrderController::class,'edit_order']);
});



/*
/
/   CLIENT ROUTE
/
*/


Route::middleware(['isuserneedlogged'])->group(function () {
    Route::get('/login', [UserController::class, 'index']);
    Route::post('/login', [UserController::class, 'login_validation']);
    Route::get('/register', [UserController::class, 'register_view']);
    Route::post('/register', [UserController::class, 'register']);
});
Route::middleware(['isuserlogged'])->group(function(){
    Route::get('/logout', [UserController::class, 'logout']);
    Route::get('/shipping',[ClientController::class, 'shipping']);
    Route::post('/shipping',[ClientController::class, 'set_shipping']);
    Route::get('/billing',[ClientController::class, 'billing']);
    Route::post('/billing',[ClientController::class, 'set_billing']);
    Route::get('/payment',[ClientController::class, 'payment']);
    Route::post('/payment',[ClientController::class, 'place_order']);
    Route::get('/cancel_order',[ClientController::class, 'cancel_order']);
    Route::get('/success',[ClientController::class, 'success']);
    Route::post('/add_address',[ClientController::class, 'add_address']);
});
Route::get('/', [ClientController::class, 'index']);
Route::post('/add_to_cart', [ClientController::class, 'add_to_cart']);
Route::post('/remove_cart', [ClientController::class, 'remove_cart']);
Route::post('/update_cart', [ClientController::class, 'update_cart']);
Route::post('/coupon', [ClientController::class, 'validate_coupon']);
Route::post('/checkout', [ClientController::class, 'checkout']);
Route::get('/cart', [ClientController::class, 'cart']);

Route::get('/session', [ClientController::class, 'get_session']);
Route::get('/cat/{uri}/{uri2?}', [ClientController::class, 'category']);
Route::get('/{uri}', [ClientController::class, 'product']);
