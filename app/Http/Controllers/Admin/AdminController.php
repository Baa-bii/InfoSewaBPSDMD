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

    public function data_ruang():View{
        return view('admin.data_ruang');
    }
}
