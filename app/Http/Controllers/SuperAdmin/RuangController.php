<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ruang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RuangController extends Controller
{
    public function index(Request $request)
    {
        $ruang = Ruang::all();
        // Ambil kluster yang unik (distinct)
        $klusters = Ruang::select('kluster')->distinct()->get();
        $query = Ruang::query();
        // Apply filter for Prodi
        if ($request->has('filter_kluster') && $request->filter_kluster != '') {
            $query->where('kluster', $request->filter_kluster);
        }
        return view('superAdmin.data_ruang', compact('ruang','klusters'));
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
            'kapasitas' => 'required|integer|min:1',
        ]);


        $exists = Ruang::where('nama_ruang', $validatedData['nama_ruang'])
                ->where('kluster', $validatedData['kluster'])
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
            'kapasitas' => 'required|integer|min:1',
        ]);

        // Check for uniqueness
        $exists = Ruang::where([
            ['nama_ruang', $validatedData['nama_ruang']],
            ['kluster', $validatedData['kluster']],
        ])->where('id', '!=', $id)->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['nama_ruang' => 'Ruangan ini sudah dialokasikan dengan prodi lain.']);
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
