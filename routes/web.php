<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\SuperAdmin\SuperAdminController;
use App\Http\Controllers\SuperAdmin\RuangController;
use App\Http\Controllers\Admin\AdminRuangController;
use App\Http\Controllers\SuperAdmin\UserController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'verify'])->name('auth.verify');

Route::get('/api/bookings/{year}/{month}', [SuperAdminController::class, 'getBookingsForMonth']);
Route::get('/api/get-gedung', [BookingController::class, 'getGedung']);
Route::get('/api/get-available-rooms', [BookingController::class, 'getAvailableRooms']);
Route::post('/booking/update-status/{id}', [BookingController::class, 'updateStatus'])->name('booking.updateStatus');

Route::group(['middleware'=>'auth:admin'], function(){
    Route::get('/admin/home', [AdminController::class, 'index'])->name('admin.dashboard.index');
    Route::get('/admin/data-ruang', [AdminRuangController::class, 'index'])->name('admin.data-ruang');
    Route::get('/admin/booking-ruang', [BookingController::class, 'index'])->name('admin.booking-ruang');
    Route::get('/admin/booking-ruang/create', [BookingController::class, 'create'])->name('admin.booking.create');
    Route::post('/admin/booking-ruang/store', [BookingController::class, 'store'])->name('admin.booking.store');
    Route::get('/admin/booking-data', [AdminController::class, 'booking_data'])->name('admin.booking-data');
});

Route::group(['middleware'=>'auth:sup-admin'], function(){
    Route::get('/sup-admin/home', [SuperAdminController::class, 'index'])->name('sup-admin.dashboard.index');
    Route::get('/sup-admin/booking_ruang', [BookingController::class, 'index'])->name('sup-admin.booking-ruang');
    Route::get('/sup-admin/booking-ruang/create', [BookingController::class, 'create'])->name('sup-admin.booking.create');
    Route::post('/sup-admin/booking-ruang/store', [BookingController::class, 'store'])->name('sup-admin.booking.store');
    Route::get('/sup-admin/booking', [SuperAdminController::class, 'booking_data'])->name('sup-admin.booking-data');
    Route::get('/sup-admin/booking/booking_data', [SuperAdminController::class, 'getData'])->name('sup-admin.get.data');
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
    Route::get('/sup-admin/get-gedung/{kluster}', [RuangController::class, 'getGedung'])->name('sup-admin.ruang.getGedung');
    Route::resource('/sup-admin/data-user', UserController::class, [
        'names' => [
            'index' => 'sup-admin.user.index',
            'create' => 'sup-admin.user.create',
            'store' => 'sup-admin.user.store',
            'edit' => 'sup-admin.user.edit',
            'update' => 'sup-admin.user.update',
            'destroy' => 'sup-admin.user.destroy',
        ],
    ])->except(['show']);
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');