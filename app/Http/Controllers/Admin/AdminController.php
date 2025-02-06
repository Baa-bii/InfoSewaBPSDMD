<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Booking;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index():View{
        // Ambil tanggal sekarang atau tanggal tertentu
        $currentDate = Carbon::now();

        // Query untuk mendapatkan data booking berdasarkan tanggal
        $bookings = Booking::where(function($query) use ($currentDate) {
            $query->whereDate('tanggal_start', '<=', $currentDate) // Booking yang mulai sebelum atau pada tanggal sekarang
                ->whereDate('tanggal_end', '>=', $currentDate); // Booking yang berakhir setelah atau pada tanggal sekarang
        })->get();

        return view('admin.dashboard', compact('bookings'));
    }
    public function booking_data():View{
        return view('admin.booking.data_booking');
    }
}
