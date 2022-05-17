<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\client\ClientController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\SubcategoryController;
use App\Http\Controllers\admin\DiscountController;
use App\Http\Controllers\admin\ProductController;
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
Route::middleware(['isadminneedlogged'])->group(function(){
    Route::get('/admin/login',[AdminController::class,'login']);
    Route::post('/admin/login',[AdminController::class,'loginValidate']);

});
// IS ADMIN ALREADY LOGGED
Route::middleware(['isadminlogged'])->group(function(){
    Route::get('/admin',[AdminController::class,'index']);
    Route::get('/admin/logout',[AdminController::class,'logout']);
    Route::get('/admin/settings',[AdminController::class,'settings']);
    Route::post('/admin/settings',[AdminController::class,'updateSettings']);
    Route::get('/admin/category',[CategoryController::class,'index']);
    Route::get('/admin/category/add/{id?}',[CategoryController::class,'add']);
    Route::get('/admin/category/delete/{id}',[CategoryController::class,'delete']);
    Route::post('/admin/category/add',[CategoryController::class,'save']); 
    Route::get('admin/subcategory',[SubcategoryController::class,'index']);  
    Route::get('admin/subcategory/add/{id?}',[SubcategoryController::class,'add']); 
    Route::get('admin/subcategory/delete/{id}',[SubcategoryController::class,'delete']); 
    Route::post('/admin/subcategory/add',[SubcategoryController::class,'save']); 
    Route::get('admin/discount',[DiscountController::class,'index']);
    Route::get('admin/discount/add/{id?}',[DiscountController::class,'add']);
    Route::post('admin/discount/add',[DiscountController::class,'save']);
    Route::get('/admin/discount/delete/{id}',[DiscountController::class,'delete']);
    Route::get('admin/product',[ProductController::class,'index']);
    Route::get('admin/product/add/{id?}',[ProductController::class,'add']);
    Route::post('admin/product/add',[ProductController::class,'save']);
    Route::get('/admin/product/delete/{id}',[ProductController::class,'delete']);
    Route::post('/admin/subcategory/get',[ProductController::class,'get_subcategory']);
});



/*
/
/   CLIENT ROUTE
/
*/

Route::get('/',[ClientController::class,'index']);
Route::get('/cat/{uri}/{uri2?}',[ClientController::class,'category']);
Route::get('/{uri}',[ClientController::class,'product']);
