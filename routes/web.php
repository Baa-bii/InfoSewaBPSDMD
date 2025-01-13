<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperAdmin\SuperAdminController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'verify'])->name('auth.verify');


Route::group(['middleware'=>'auth:admin'], function(){
    Route::get('/admin/home', [AdminController::class, 'index'])->name('admin.dashboard.index');
    Route::get('/admin/data-ruang', [AdminController::class, 'data_ruang'])->name('admin.data-ruang');
    Route::get('/admin/booking-ruang', [AdminController::class, 'booking_ruang'])->name('admin.booking-ruang');
    Route::get('/admin/booking-data', [AdminController::class, 'booking_data'])->name('admin.booking-data');
});

Route::group(['middleware'=>'auth:sup-admin'], function(){
    Route::get('/sup-admin/home', [SuperAdminController::class, 'index'])->name('sup-admin.dashboard.index');
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');