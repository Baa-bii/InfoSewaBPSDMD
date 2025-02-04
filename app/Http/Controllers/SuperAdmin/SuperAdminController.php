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
use Yajra\DataTables\Facades\DataTables;

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
        return view('superAdmin.booking.data_booking');
    }

    public function getData()
    {
        $bookings = Booking::select([
            'id', 'nama_pemesan', 'nama_ruang', 'kluster', 'gedung', 'tanggal_start', 'tanggal_end', 'status'
        ]);

            return DataTables::of($bookings)
            ->addColumn('validasi', function ($row) {
                return '<button class="bg-blue-500 hover:bg-blue-700 px-1 m-1 rounded-lg text-white font-medium validasi-btn" onclick="validasi(' . $row->id . ')">'
                    . ($row->status === 'belum' ? 'Validasi' : 'Validasi') .
                    '</button>';
            })
            ->addColumn('status', function ($row) {
                // Add the status column with a class to easily identify it
                $statusClass = $row->status === 'belum' ? 'text-red-500' : 'text-green-500';
                return '<span class="status-text ' . $statusClass . '">' . ($row->status === 'belum' ? 'Belum' : 'Sudah') . '</span>';
            })
            ->addColumn('aksi', function ($row) {
                return '<button class="bg-green-500 hover:bg-green-600 rounded-md text-white px-1 font-medium" onclick="aksi(' . $row->id . ')">Edit</button> 
                        <button class="bg-red-500 hover:bg-red-600 rounded-md text-white px-1 font-medium" onclick="aksi(' . $row->id . ')">Hapus</button>';
            })
            ->rawColumns(['aksi', 'validasi', 'status'])
            ->make(true);
    }

    public function booking_riwayat():View{
        return view('superAdmin.booking.riwayat_booking');
    }
}
