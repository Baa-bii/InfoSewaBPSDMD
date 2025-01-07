<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index():View{
        $user = Auth::user();
        $admin = $user->dosen;
        return view('admin.dashboard', compact('user'));
    }
}
