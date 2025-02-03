<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ruang;

class AdminRuangController extends Controller
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
        return view('admin.data_ruang', compact('ruang', 'klusters', 'gedungList'));
    }
    
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
}
