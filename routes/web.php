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
    Route::get('/admin/daftar-ruang', [AdminController::class, 'daftar_ruang'])->name('admin.daftar-ruang');
    Route::get('/admin/tambah-ruang', [AdminController::class, 'tambah_ruang'])->name('admin.tambah-ruang');
});

Route::group(['middleware'=>'auth:sup-admin'], function(){
    Route::get('/sup-admin/home', [SuperAdminController::class, 'index'])->name('sup-admin.dashboard.index');
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');