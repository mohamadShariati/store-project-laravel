<?php

use App\Http\Controllers\Admin\BrandController;
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


Route::prefix('/admin-panel/management')->group(function(){
    Route::prefix('/brands')->group(function(){
        Route::get('/',[BrandController::class,'index'])->name('admin.brands.index');
        Route::get('/create',[BrandController::class,'create'])->name('admin.brands.create');
        Route::post('/store',[BrandController::class,'store'])->name('admin.brands.store');
        Route::get('/edit/{brand}',[BrandController::class,'edit'])->name('admin.brands.edit');
        Route::post('/update/{brand}',[BrandController::class,'update'])->name('admin.brands.update');
        Route::delete('/destroy',[BrandController::class,'destroy'])->name('admin.brands.destroy');
    });
});



Route::get('/admin-panel/dashboard', function () {
    return view('admin.dashboard')->name('dashboard');
});


