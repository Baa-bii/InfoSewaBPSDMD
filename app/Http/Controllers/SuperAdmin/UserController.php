<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(): View {
        $users = User::orderBy('name', 'asc')->get();
        return view('superAdmin.data_user', compact('users'));
    }
    
}
