<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Ruang;
use Illuminate\Support\Facades\Log;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    private $gedungList = [
        'Sumbing' => [
            'I' => 'Sumbing I',
            'II' => 'Sumbing II',
            'III' => 'Sumbing III',
            'IV' => 'Sumbing IV'
        ],
        'Muria' => [
            'I' => 'Muria I',
            'II' => 'Muria II'
        ],
        'Sindoro' => [
            'I' => 'Sindoro I',
            'II' => 'Sindoro II',
            'III' => 'Sindoro III'
        ],
        'Merbabu' => [],
        'Merapi' => ['Merapi']
    ];

    public function index(Request $request)
    {
        $bookings = Booking::with('ruang')->get();
        $klusters = array_keys($this->gedungList); // Get klusters from the array keys
        $rooms = Ruang::all();
        // Convert gedungList to a collection format that matches the view expectations
        $gedungs = collect($this->gedungList)->map(function ($items, $kluster) {
            return (object)['gedung' => $kluster];
        });
        
        if(Auth::guard('sup-admin')->check()) {
            return view('superAdmin.booking.booking_ruang', compact('bookings', 'klusters','gedungs', 'rooms'));
        }
        elseif(Auth::guard('admin')->check()) {
            return view('admin.booking.booking_ruang', compact('bookings', 'klusters', 'gedungs', 'rooms'));
        }
    }
    public function create()
    {
        $klusters = Ruang::select('kluster')->distinct()->get();
        $gedungs = Ruang::select('gedung')->distinct()->get();
        $rooms = Ruang::all();

        if (Auth::guard('sup-admin')->check()) {
            return view('superAdmin.booking.booking_ruang', compact('klusters', 'gedungs', 'rooms'));
        } elseif (Auth::guard('admin')->check()) {
            return view('admin.booking.booking_ruang', compact('klusters', 'gedungs', 'rooms'));
        }
    }

    public function getGedung(Request $request)
    {
        $gedungList = [
            'Sumbing' => ['I', 'II', 'III', 'IV'],
            'Muria' => ['I', 'II'],
            'Sindoro' => ['I', 'II', 'III'],
            'Merbabu' => [],
            'Merapi' => []
        ];

        $kluster = $request->input('kluster');
        return response()->json($gedungList[$kluster] ?? []);
    }
    
    public function getAvailableRooms(Request $request)
    {
        try {
            Log::info('getAvailableRooms called with:', $request->all());

            $kluster = $request->input('kluster');
            $gedung = $request->input('gedung');
            $tanggal_start = $request->input('tanggal_start');
            $tanggal_end = $request->input('tanggal_end');

            if (!$kluster || !$gedung || !$tanggal_start || !$tanggal_end) {
                return response()->json(['error' => 'Kluster, Gedung, Tanggal Start, atau Tanggal End tidak boleh kosong'], 400);
            }

            // Query Ruang yang tidak ada dalam Booking
            $rooms = DB::table('ruang')
                ->select('ruang.id', 'ruang.nama_ruang')
                ->whereNotExists(function ($query) use ($tanggal_start, $tanggal_end) {
                    $query->from('jadwal_booking')
                        ->whereColumn('jadwal_booking.id_ruang', 'ruang.id')
                        ->where(function ($q) use ($tanggal_start, $tanggal_end) {
                            $q->whereBetween('jadwal_booking.tanggal_start', [$tanggal_start, $tanggal_end])
                                ->orWhereBetween('jadwal_booking.tanggal_end', [$tanggal_start, $tanggal_end])
                                ->orWhere(function ($inner) use ($tanggal_start, $tanggal_end) {
                                    $inner->where('jadwal_booking.tanggal_start', '<=', $tanggal_start)
                                        ->where('jadwal_booking.tanggal_end', '>=', $tanggal_end);
                                });
                        });
                })
                ->where('ruang.kluster', $kluster)
                ->where('ruang.gedung', $gedung)
                ->get();
    
            return response()->json($rooms);
        } catch (\Exception $e) {
            Log::error('Error in getAvailableRooms:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Terjadi kesalahan server. Cek log untuk detail.'], 500);
        }
    }



    /**
     * Menyimpan booking baru.
     */
    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'no_hp' => 'required|string|max:255',
            'no_ktp' => 'required|string|max:255',
            'keperluan' => 'required|string|max:255',
            'id_ruang' => 'required|exists:ruang,id',
            'tanggal_start' => 'required|date|after_or_equal:today',
            'tanggal_end' => 'required|date|after:tanggal_start',
        ]);

        // Validasi waktu tidak tumpang tindih
        $isOverlap = Booking::where('id_ruang', $validated['id_ruang'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('tanggal_start', [$validated['tanggal_start'], $validated['tanggal_end']])
                    ->orWhereBetween('tanggal_end', [$validated['tanggal_start'], $validated['tanggal_end']])
                    ->orWhere(function ($query) use ($validated) {
                        $query->where('tanggal_start', '<=', $validated['tanggal_start'])
                                ->where('tanggal_end', '>=', $validated['tanggal_end']);
                    });
            })->exists();

        if ($isOverlap) {
            return back()->withErrors(['tanggal_start' => 'Ruangan sudah dibooking pada waktu tersebut.'])->withInput();
        }

        // Simpan booking baru
        $ruang = Ruang::findOrFail($validated['id_ruang']);

        Booking::create([
            'nama_pemesan' => $validated['nama_pemesan'],
            'no_ktp' => $validated['no_ktp'],
            'no_hp' => $validated['no_hp'],
            'keperluan' => $validated['keperluan'],
            'id_ruang' => $ruang->id,
            'nama_ruang' => $ruang->nama_ruang,
            'kluster' => $ruang->kluster,
            'gedung' => $ruang->gedung,
            'tanggal_start' => $validated['tanggal_start'],
            'tanggal_end' => $validated['tanggal_end'],
        ]);

        return redirect()->route(auth()->guard('admin')->check() ? 'admin.booking-ruang' : 'sup-admin.booking-ruang')
                     ->with('success', 'Booking berhasil dibuat!');
    }

    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        
        // Toggle status
        $booking->status = $booking->status === 'belum' ? 'sudah' : 'belum';
        $booking->save();

        return response()->json(['success' => true, 'status' => $booking->status]);
    }


}
