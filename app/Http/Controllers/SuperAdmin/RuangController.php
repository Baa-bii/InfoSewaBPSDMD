<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ruang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class RuangController extends Controller
{
    public function index(Request $request)
    {
        // Define gedung list for each kluster
        $gedungList = [
            'Sumbing' => ['I', 'II', 'III', 'IV'],
            'Muria' => ['I', 'II'],
            'Sindoro' => ['I', 'II', 'III'],
            'Merbabu' => [],
            'Merapi' => [],
        ];

        // Start a query to filter Ruang based on kluster and gedung
        $query = Ruang::query();

        // Apply filter for kluster if present
        if ($request->has('filter_kluster') && $request->filter_kluster != '') {
            $kluster = $request->filter_kluster;
            $query->where('kluster', $kluster);
        }

        // Apply filter for gedung if present
        if ($request->has('filter_gedung') && $request->filter_gedung != '') {
            $gedung = $request->filter_gedung;
            $query->where('gedung', $gedung);
        }

         // Apply sorting for Nama Ruang
        if ($request->has('sort_by') && $request->sort_by != '') {
            $sortDirection = $request->get('sort_direction', 'asc'); // Default to ascending if no direction is provided
            $query->orderBy('nama_ruang', $sortDirection);
        } else {
            // Default sort (optional), for example by name in ascending order
            $query->orderBy('nama_ruang', 'asc');
        }

        // Get all distinct klusters for the filter
        $klusters = Ruang::select('kluster')->distinct()->get();

        // Paginate the result
        $ruang = $query->paginate(10)->appends([
            'filter_kluster' => $request->filter_kluster,
            'filter_gedung' => $request->filter_gedung
        ]);

        // Return the view with the necessary data
        return view('superAdmin.data_ruang', compact('ruang', 'klusters', 'gedungList'));
    }



    // RuangKelasController.php
    public function getGedung($kluster)
    {
        $gedungList = [
            'Sumbing' => ['I', 'II', 'III', 'IV'],
            'Muria' => ['I', 'II'],
            'Sindoro' => ['I', 'II', 'III'],
            'Merbabu' => [],
            'Merapi' => [],
        ];

        $gedung = $gedungList[$kluster] ?? [];
        return response()->json($gedung);
    }


    public function create()
    {
        $ruang = Ruang::all();
        return view('superAdmin.create_ruang',compact('ruang'));
    }

    //Simpan Ruang yang ditambahkan
    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'nama_ruang' => 'required|string|max:255',
            'kluster' => 'required|string|max:255',
            'gedung' => 'required|string|max:255',
            'harga' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
        ]);


        $exists = Ruang::where('nama_ruang', $validatedData['nama_ruang'])
                ->where('kluster', $validatedData['kluster'])
                ->where('gedung', $validatedData['gedung'])
                ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['nama' => 'Ruangan ini sudah ada.']);
        }
        $ruang = Ruang::all();
        // Simpan data ke database
        Ruang::create($validatedData);

        // Redirect dengan pesan sukses
        return redirect()->route('sup-admin.ruang.index')->with('success', 'Ruang berhasil ditambahkan.');
    }


    //Edit Ruang
    public function edit($id)
    {
        $ruang = Ruang::findOrFail($id);
        $klusters = Ruang::select('kluster')->distinct()->get();
        return view('superAdmin.edit_ruang', compact('ruang', 'klusters'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_ruang' => 'required|string|max:255',
            'kluster' => 'required|string|max:255',
            'gedung' => 'required|string|max:255',
            'harga' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
        ]);

        // Check for uniqueness
        $exists = Ruang::where([
            ['nama_ruang', $validatedData['nama_ruang']],
            ['kluster', $validatedData['kluster']],
            ['gedung', $validatedData['gedung']],
        ])->where('id', '!=', $id)->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['nama_ruang' => 'Ruangan ini sudah ada']);
        }

        // Find the Ruang by ID and update
        $ruangs = Ruang::findOrFail($id);
        $ruangs->update($validatedData);

        // Redirect back to the edit route
        return redirect()->route('sup-admin.ruang.index', $id)->with('success', 'Ruang berhasil diperbarui.');
    }



    public function destroy($id)
    {
        $ruang = Ruang::findOrFail($id);
        $ruang->delete();

        return redirect()->route('sup-admin.ruang.destroy')->with('success', 'Ruang berhasil dihapus.');
    }
}
