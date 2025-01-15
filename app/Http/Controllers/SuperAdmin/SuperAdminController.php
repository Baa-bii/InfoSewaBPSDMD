<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuperAdminController extends Controller
{
    public function index():View{
        return view('superAdmin.dashboard');
    }

    public function booking_ruang():View{
        return view('superAdmin.booking.booking_ruang');
    }

    public function booking_data():View{
        return view('superAdmin.booking.data_booking');
    }

    public function booking_riwayat():View{
        return view('superAdmin.booking.riwayat_booking');
    }
}
