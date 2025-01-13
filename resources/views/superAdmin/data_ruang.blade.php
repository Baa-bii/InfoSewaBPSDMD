<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Ruang</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="icon" href="{{ asset('assets/logo-bpsdmd.png') }}?v=2" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
</head>
<body class="antialiased flex flex-col min-h-screen">
    <x-header></x-header>
    <x-sidebar></x-sidebar>
    <main class="p-16 md:ml-64 h-auto pt-20 flex-grow">
        <div>
            <a href="#">
                <button class="text-md bg-blue-500 w-auto h-auto m-4 p-1 rounded text-white hover:bg-blue-600 shadow-lg" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ruangKelasModal">
                    Tambahkan Ruangan
                </button>
            </a>
            <div>
                <form method="GET" action="" class="flex flex-row m-2">
                <div class="border-2 border-gray-400 w-fit rounded-md">
                    <label for="filter_gedung" class="form-label font-sans font-medium ml-1">Filter by Gedung</label>
                    <select name="filter_gedung" id="filter_gedung" class=" text-sm  mr-1" onchange="this.form.submit()">
                        <option value="">Semua Gedung</option>
                        {{-- <option value="Sindoro" {{ request('filter_gedung') == 'A' ? 'selected' : '' }}>A</option>
                        <option value="Sumbing" {{ request('filter_gedung') == 'B' ? 'selected' : '' }}>B</option>
                        <option value="Merapi" {{ request('filter_gedung') == 'C' ? 'selected' : '' }}>C</option>
                        <option value="Muria" {{ request('filter_gedung') == 'D' ? 'selected' : '' }}>D</option>--}}
                    </select>
                </div>
                
                <div class="border-2 border-gray-400 w-fit rounded-md ml-3">
                    <label for="filter_prodi" class="form-label font-sans font-medium ml-1">Filter by Kluster</label>
                    <select name="filter_prodi" id="filter_prodi" class=" text-sm mr-1" onchange="this.form.submit()">
                        <option value="">Semua Kluster</option>
                        {{-- @foreach ($programStudi as $prodi)
                            <option value="{{ $prodi->kode_prodi }}" {{ request('filter_prodi') == $prodi->kode_prodi ? 'selected' : '' }}>
                                {{ $prodi->nama_prodi }}
                            </option>
                        @endforeach --}}
                    </select>
                </div>
                </form>
            </div>
        </div>
        <table class="w-full min-w-max table-auto bg-white border rounded-lg shadow-md">
        <thead class="bg-gray-700 text-white">
            <tr class="border border-gray-300">
                <th class="p-2 text-left border-r border-white">Nama Gedung</th>
                <th class="p-2 text-left border-r border-white">Kluster</th>
                <th class="p-2 text-left border-r border-white">Jumlah Ruang</th>
                <th class="p-2 text-left border-r border-white">Kapasitas</th>
                <th class="p-2 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-300">
            <!-- Contoh Data 1 -->
            <tr>
                <td class="py-1 px-2 border-r border-gray-500">Sindoro</td>
                <td class="py-1 px-2 border-r border-gray-500">Sindoro I</td>
                <td class="py-1 px-2 border-r border-gray-500">10</td>
                <td class="py-1 px-2 border-r border-gray-500">5</td>
                <td class="py-1 px-2 ">
                    <a href="#">
                    <button class="bg-green-400 w-auto p-1 rounded text-white hover:bg-green-500 shadow-md">
                        Edit
                    </button>
                    <form action="#" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 w-auto p-1 rounded text-white hover:bg-red-600 shadow-md">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
</main>
<x-footer></x-footer>
    
</body>
</html>