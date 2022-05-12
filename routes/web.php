<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\client\ClientController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\CategoryController;
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


Route::get('/',[ClientController::class,'index']);
//IS ADMIN NEED LOGIN
Route::middleware(['isadminneedlogged'])->group(function(){
    Route::get('/admin/login',[AdminController::class,'login']);
    Route::post('/admin/login',[AdminController::class,'loginValidate']);

});
// IS ADMIN ALREADY LOGGED
Route::middleware(['isadminlogged'])->group(function(){
    Route::get('/admin',[AdminController::class,'index']);
    Route::get('/admin/settings',[AdminController::class,'settings']);
    Route::post('/admin/settings',[AdminController::class,'updateSettings']);
    Route::get('/admin/category',[CategoryController::class,'index']);
    Route::get('/admin/category/add/{id?}',[CategoryController::class,'add']);
    Route::post('/admin/category/add',[CategoryController::class,'save']);    
});
Route::get('/admin/logout',[AdminController::class,'logout']);



/*
/
/   CLIENT ROUTE
/
*/

