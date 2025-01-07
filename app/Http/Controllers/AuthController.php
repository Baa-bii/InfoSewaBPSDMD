<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UserAuthVerifyRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index():View
    {
        return view('auth.login');
    }

    public function verify(UserAuthVerifyRequest $request) : RedirectResponse{
        $data = $request->validated();

        if (Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password'], 'role'=>'admin'])){
            $request->session()->regenerate();
            return redirect()->intended('/admin/home');
        }
        else if (Auth::guard('sup-admin')->attempt(['email'=>$data['email'],'password'=>$data['password'], 'role'=>'sup-admin'])){
            $request->session()->regenerate();
            return redirect()->intended('/sup-admin/home');
        }
        else{
            return redirect(route('login'))->with('msg', 'Email dan password salah');
        }
    }

    public function logout():RedirectResponse{
        if (Auth::guard('admin')->check()){
            Auth::guard('admin')->logout();
        }
        else if (Auth::guard('sup-admin')->check()){
            Auth::guard('sup-admin')->logout();
        }
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login')->with('msg', 'You have been logged out.');
    }
}

