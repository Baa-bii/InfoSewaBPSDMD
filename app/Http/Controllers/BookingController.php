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
        'Merapi' => [
            'I'=>'Merapi'
        ]
    ];

    public function index(Request $request)
    {
        $bookings = Booking::with('ruang')->get();
        $klusters = array_keys($this->gedungList);
        $rooms = Ruang::all();
        
        $gedungs = collect($this->gedungList)->map(function ($items, $kluster) {
            return (object)['gedung' => $kluster];
        });

        // Asumsi kolom jumlah kamar di ruang adalah 'kapasitas'
        $jumlahTotalKamar = DB::table('ruang')
            ->select('kluster', 'gedung', DB::raw('COUNT(*) as total_kamar'))
            ->groupBy('kluster', 'gedung')
            ->get();

        $jumlahBooking = DB::table('jadwal_booking as jb')
            ->join('ruang as r', 'jb.id_ruang', '=', 'r.id')
            ->select('r.kluster', 'r.gedung', DB::raw('count(*) as kamar_terbooking'))
            ->groupBy('r.kluster', 'r.gedung')
            ->get();

        $dataKamar = [];
        foreach ($jumlahTotalKamar as $item) {
            $kluster = $item->kluster;
            $gedung = $item->gedung;
            $total = $item->total_kamar;

            $booking = $jumlahBooking->first(function($b) use ($kluster, $gedung) {
                return $b->kluster === $kluster && $b->gedung === $gedung;
            });

            $terbooking = $booking ? $booking->kamar_terbooking : 0;
            $tersedia = $total - $terbooking;

            $dataKamar[$kluster][$gedung] = [
                'tersedia' => $tersedia,
                'total' => $total,
            ];
        }

        if(Auth::guard('sup-admin')->check()) {
            return view('superAdmin.booking.booking_ruang', compact('bookings', 'klusters','gedungs', 'rooms','dataKamar'));
        }
        elseif(Auth::guard('admin')->check()) {
            return view('admin.booking.booking_ruang', compact('bookings', 'klusters', 'gedungs', 'rooms','dataKamar'));
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
            'Merapi' => ['I']
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
                return response()->json(['error' => 'Parameter tidak lengkap'], 400);
            }

            // Dapatkan ID Ruang yang sudah di-booking pada rentang tanggal yang dipilih
            $bookedRoomIds = Booking::where(function ($query) use ($tanggal_start, $tanggal_end) {
                    $query->whereBetween('tanggal_start', [$tanggal_start, $tanggal_end])
                        ->orWhereBetween('tanggal_end', [$tanggal_start, $tanggal_end])
                        ->orWhere(function ($inner) use ($tanggal_start, $tanggal_end) {
                            $inner->where('tanggal_start', '<=', $tanggal_start)
                                    ->where('tanggal_end', '>=', $tanggal_end);
                        });
                })
                ->pluck('id_ruang');

            // Cari semua ruang yang cocok dengan kluster dan gedung, 
            // KECUALI yang ID-nya sudah di-booking
            $availableRooms = Ruang::where('kluster', $kluster)
                ->where('gedung', $gedung)
                ->whereNotIn('id', $bookedRoomIds)
                ->select('id', 'nama_ruang')
                ->get();

            return response()->json($availableRooms);

        } catch (\Exception $e) {
            Log::error('Error in getAvailableRooms:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Terjadi kesalahan server.'], 500);
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
            'tanggal_end' => 'required|date|after_or_equal:tanggal_start',
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

    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        return response()->json($booking);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'no_ktp' => 'required|string|max:16',
            'no_hp' => 'required|string|max:15',
            'keperluan' => 'required|string',
            'tanggal_start' => 'required|date',
            'tanggal_end' => 'required|date|after_or_equal:tanggal_start',
            'status' => 'required|string|in:belum,sudah',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->update($request->all());

        return redirect()->back()->with('success', 'Booking updated successfully');
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return response()->json(['message' => 'Booking deleted successfully']);
    }


}
