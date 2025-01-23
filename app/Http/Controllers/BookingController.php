<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Ruang;
use Illuminate\Support\Facades\Log;
use App\Models\Booking;

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
    
    public function getRooms(Request $request)
    {
        // Log incoming request data
        Log::info('getRooms called with:', $request->all());
        
        $kluster = $request->input('kluster');
        $gedung = $request->input('gedung');
        
        // Validasi input
        if (!$kluster || !$gedung) {
            return response()->json(['error' => 'Kluster or Gedung is missing'], 400);
        }

        // Cari ruangan berdasarkan kluster dan gedung
        $rooms = Ruang::where('kluster', $kluster)
                    ->where('gedung', $gedung)
                    ->get(['id', 'nama_ruang']); // Ambil hanya kolom yang diperlukan
        
        return response()->json($rooms);
        
        return response()->json($room ? [$room] : []);
    }


    /**
     * Menyimpan booking baru.
     */
    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'nama_pemesan' => 'required|string|max:255',
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

}
