<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index():View{
        return view('admin.dashboard');
    }

    public function tambah_ruang():View{
        return view('admin.tambah_ruang');
    }

    public function daftar_ruang():View{
        return view('admin.daftar_ruang');
    }
}
