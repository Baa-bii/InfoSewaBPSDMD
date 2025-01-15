<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperAdmin\SuperAdminController;
use App\Http\Controllers\SuperAdmin\RuangController;
use App\Http\Controllers\SuperAdmin\UserController;

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
    Route::get('/sup-admin/booking_ruang', [SuperAdminController::class, 'booking_ruang'])->name('sup-admin.booking-ruang');
    Route::get('/sup-admin/booking_data', [SuperAdminController::class, 'booking_data'])->name('sup-admin.booking-data');
    Route::get('/sup-admin/booking_riwayat', [SuperAdminController::class, 'booking_riwayat'])->name('sup-admin.booking-riwayat');
    Route::resource('/sup-admin/data-ruang', RuangController::class, [
        'names' => [
            'index' => 'sup-admin.ruang.index',
            'create' => 'sup-admin.ruang.create',
            'store' => 'sup-admin.ruang.store',
            'edit' => 'sup-admin.ruang.edit',
            'update' => 'sup-admin.ruang.update',
            'destroy' => 'sup-admin.ruang.destroy',
        ],
    ])->except(['show']);
    Route::resource('/sup-admin/data-user', UserController::class, [
        'names' => [
            'index' => 'sup-admin.user.index',
            'create' => 'sup-admin.user.create',
            'store' => 'sup-admin.user.store',
            'destroy' => 'sup-admin.user.destroy',
        ],
    ])->except(['show']);
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');