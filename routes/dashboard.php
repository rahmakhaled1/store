<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\Dashboard\RolesController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware'=>['auth:admin,web'],
    'as'=>'dashboard.',
    'prefix'=>'admin/dashboard'
],function (){
    Route::get('/' ,[DashboardController::class,'index'])
        ->name('dashboard');

    Route::get('/categories/trash' ,[CategoryController::class,'trash'])
        ->name('categories.trash');

    Route::put('/categories/{category}/restore' ,[CategoryController::class,'restore'])
        ->name('categories.restore');

    Route::delete('/categories/{category}/force-delete' ,[CategoryController::class,'forceDelete'])
        ->name('categories.force-delete');

    Route::resource('/categories',CategoryController::class);
    Route::resource('/products',ProductsController::class);
    Route::resource('/roles',RolesController::class);
//    Route::resource([
//        'products' => ProductsController::class,
//        'categories' => CategoryController::class,
//        'roles' => RolesController::class,
//    ]);


});


