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
            <div class="bg-blue-500 p-2 mb-4 font-sans text-white font-medium cursor-pointer text-md w-fit rounded-md shadow-md hover:bg-blue-700" id="openModal">
                + Tambahkan Ruang
            </div>
            <div id="ruangModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden">
                <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
                    <h2 class="text-xl font-bold mb-4">Tambahkan Ruang</h2>
                    <form action="{{ route('sup-admin.ruang.store') }}" method="POST">
                        @csrf
                        <!-- Kluster Dropdown -->
                        <label for="cluster" class="block text-sm font-medium mb-2">Kluster</label>
                        <input id="cluster" type="text" class="w-full p-2 border rounded-md mb-4" placeholder="Nama Kluster" required>
                    
                        <!-- Nama Ruang Input -->
                        <label for="room" class="block text-sm font-medium mb-2">Nama Ruang</label>
                        <input id="room" type="text" class="w-full p-2 border rounded-md mb-4" placeholder="Nama Ruang baru" required>
                    
                        <!-- Kapasitas -->
                        <label for="kapasitas" class="block text-sm font-medium mb-2">Kapasitas</label>
                        <input id="kapasitas" type="number" class="w-full p-2 border rounded-md mb-4" placeholder="Kapasitas Ruang Baru" min="1" required>
                    
                        <!-- Action Buttons -->
                        <div class="flex justify-end gap-2">
                            <button type="button" id="closeModal" class="px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">Simpan</button>
                        </div>
                    </form>                
                </div>
            </div>
            <div>
                <form method="GET" action="{{ route('sup-admin.ruang.index') }}" class="flex flex-row m-2">
                
                <div class="border-2 border-gray-400 w-fit rounded-md ml-3">
                    <label for="filter_kluster" class="form-label font-sans font-medium ml-1">Filter by Kluster</label>
                    <select name="filter_kluster" id="filter_prodi" class=" text-sm mr-1" onchange="this.form.submit()">
                        <option value="">Semua Kluster</option>
                        @foreach ($klusters as $kluster)
                            <option value="{{ $kluster->kluster }}" {{ request('filter_kluster') == $kluster->kluster ? 'selected' : '' }}>
                                {{ $kluster->kluster }}
                            </option>
                        @endforeach
                    </select>
                </div>
                </form>
            </div>
        </div>
        <table class="w-full min-w-max table-auto bg-white border rounded-lg shadow-md">
        <thead class="bg-gray-700 text-white">
            <tr class="border border-gray-300">
                <th class="p-2 text-left border-r border-white">Nama Ruang</th>
                <th class="p-2 text-left border-r border-white">Kluster</th>
                <th class="p-2 text-left border-r border-white">Kapasitas</th>
                <th class="p-2 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-300">
            <!-- Contoh Data 1 -->
            @foreach ($ruang as $ruang)
            <tr>
                <td class="py-1 px-2 border-r border-gray-500">{{ $ruang->nama_ruang }}</td>
                <td class="py-1 px-2 border-r border-gray-500">{{ $ruang->kluster }}</td>
                <td class="py-1 px-2 border-r border-gray-500">{{ $ruang->kapasitas }}</td>
                <td class="py-1 px-2 ">
                    <a href="{{ route('sup-admin.ruang.edit', $ruang->id) }}">
                    <button class="bg-green-400 w-auto p-1 rounded text-white hover:bg-green-500 shadow-md">
                        Edit
                    </button>
                    <form action="{{ route('sup-admin.ruang.destroy', $ruang->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 w-auto p-1 rounded text-white hover:bg-red-600 shadow-md">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</main>
<x-footer></x-footer>
<script>
    // Get elements
    const openModalButton = document.getElementById('openModal');
    const closeModalButton = document.getElementById('closeModal');
    const modal = document.getElementById('ruangModal');

    // Open modal
    openModalButton.addEventListener('click', () => {
        modal.classList.remove('hidden');
    });

    // Close modal
    closeModalButton.addEventListener('click', () => {
        modal.classList.add('hidden');
    });

    // Close modal when clicking outside the modal
    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add('hidden');
        }
    });
</script>
</body>
</html>