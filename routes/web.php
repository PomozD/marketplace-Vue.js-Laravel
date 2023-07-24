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

Route::get('/', function () {
    return view('index');
});

Route::group(['prefix' => 'api/categories', 'as' => 'api.categories.'], function() {
    Route::get("/", [\App\Http\Controllers\CategoriesController::class, "getCategory"]);
});

Route::group(['prefix' => 'api/users', 'as' => 'api.users.'], function() {
    Route::post("/", [\App\Http\Controllers\UsersController::class, "postUser"]);
    Route::get("/", [\App\Http\Controllers\UsersController::class, "getUser"]);
    Route::get("/profile", [\App\Http\Controllers\UsersController::class, "getUserInfo"]);
    Route::get("/profile/admin/allProducts", [\App\Http\Controllers\UsersController::class, "getAllProducts"]);
    Route::get("/profile/admin/getCategory", [\App\Http\Controllers\UsersController::class, "getCategory"]);
    Route::get("/profile/admin/getSex", [\App\Http\Controllers\UsersController::class, "getSex"]);
    Route::get("/profile/admin/getSize", [\App\Http\Controllers\UsersController::class, "getSize"]);
    Route::get("/profile/admin/getType", [\App\Http\Controllers\UsersController::class, "getType"]);
    Route::post("/profile/admin/addProduct", [\App\Http\Controllers\UsersController::class, "addProduct"]);
    Route::get("/profile/admin/editProducts", [\App\Http\Controllers\UsersController::class, "editProduct"]);
    Route::delete("/profile/admin/deleteProducts", [\App\Http\Controllers\UsersController::class, "deleteProduct"]);
    Route::post("/profile/admin/addCategory", [\App\Http\Controllers\UsersController::class, "addCategory"]);
    Route::delete("/profile/admin/deleteCategory", [\App\Http\Controllers\UsersController::class, "deleteCategory"]);
    Route::post("/profile/admin/addType", [\App\Http\Controllers\UsersController::class, "addType"]);
    Route::delete("/profile/admin/deleteType", [\App\Http\Controllers\UsersController::class, "deleteType"]);
});

Route::group(['prefix' => 'api/products', 'as' => 'api.products.'], function() {
    Route::get("/", [\App\Http\Controllers\ProductsController::class, "getItem"]);
    Route::get("/sizes", [\App\Http\Controllers\ProductsController::class, "getSize"]);
});

//    Route::get("/{category_id}/products", [\App\Http\Controllers\CategoriesController::class, "getCategoryProducts"]);
//    Route::get("/{category_id}/filters", [\App\Http\Controllers\CategoriesController::class, "getCategoryFilters"]);
//});

//Auth::routes();
//
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
