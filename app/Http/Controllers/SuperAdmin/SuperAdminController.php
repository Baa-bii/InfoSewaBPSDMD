<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Ruang;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SuperAdminController extends Controller
{
    public function index()
    {
        // Ambil tanggal sekarang atau tanggal tertentu
        $currentDate = Carbon::now();

        // Query untuk mendapatkan data booking berdasarkan tanggal
        $bookings = Booking::where(function($query) use ($currentDate) {
            $query->whereDate('tanggal_start', '<=', $currentDate) // Booking yang mulai sebelum atau pada tanggal sekarang
                ->whereDate('tanggal_end', '>=', $currentDate); // Booking yang berakhir setelah atau pada tanggal sekarang
        })->get();

        // Return view dengan data bookings
        if (Auth::guard('sup-admin')->check()) {
            return view('superAdmin.dashboard', compact('bookings'));
        } elseif (Auth::guard('admin')->check()) {
            return view('admin.dashboard', compact('bookings'));
        }
    }

    public function getBookingsByDate($date)
    {
        try {
            $tanggal = Carbon::parse($date)->toDateString();
            
            // Log query yang dijalankan
            Log::info("Tanggal yang dicari: " . $tanggal);
            
            $bookings = Booking::whereRaw("? BETWEEN tanggal_start AND tanggal_end", [$tanggal]);
            
            // Log query SQL yang dihasilkan
            Log::info($bookings->toSql());
            Log::info($bookings->getBindings());
            
            $result = $bookings->select('nama_ruang', 'kluster', 'gedung')->get();
            
            // Log hasil query
            Log::info("Hasil query:", $result->toArray());
            
            return response()->json($result);
        } catch (\Exception $e) {
            Log::error("Error in getBookingsByDate: " . $e->getMessage());
            return response()->json(['error' => 'Invalid date format'], 400);
        }
    }

    public function getBookingsForMonth(Request $request)
    {
        $year = $request->input('year');
        $month = $request->input('month');

        $startOfMonth = Carbon::create($year, $month, 1)->startOfMonth();
        $endOfMonth = Carbon::create($year, $month, 1)->endOfMonth();

        // Ambil data booking pada bulan tersebut
        $bookings = Booking::whereBetween('tanggal_start', [$startOfMonth, $endOfMonth])
                            ->orWhereBetween('tanggal_end', [$startOfMonth, $endOfMonth])
                            ->get();

        return response()->json($bookings);
    }

    public function booking_data():View{
        $bookings = Booking::all();
        return view('superAdmin.booking.data_booking', compact('bookings'));
    }

    public function booking_riwayat():View{
        return view('superAdmin.booking.riwayat_booking');
    }
}
