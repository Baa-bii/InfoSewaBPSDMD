<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Ruang</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="icon" href="{{ asset('assets/logo-bpsdmd.png') }}?v=2" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
</head>
<body>
    <x-header></x-header>
    <x-sidebar></x-sidebar>
    <main class="p-16 md:ml-64 h-auto pt-20">
        <form action="{{ route('sup-admin.ruang.store') }}" method="POST">
            @csrf
            <h2 class="text-xl font-bold mb-4">Tambahkan Ruang</h2>
        
            <!-- Nama Ruang Input -->
            <label for="room" class="block text-sm font-medium mb-2">Nama Ruang</label>
            <input id="room" name="nama_ruang" type="text" class="w-full p-2 border rounded-md mb-4" placeholder="Nama Ruang baru" required>
            
            <!-- Kluster Input -->
            <label for="cluster" class="block text-sm font-medium mb-2">Kluster</label>
            <input id="cluster" name="kluster" type="text" class="w-full p-2 border rounded-md mb-4" placeholder="Nama Kluster" required>
            
            <!-- Kapasitas -->
            <label for="kapasitas" class="block text-sm font-medium mb-2">Kapasitas</label>
            <input id="kapasitas" name="kapasitas" type="number" class="w-full p-2 border rounded-md mb-4" placeholder="Kapasitas Ruang Baru" min="1" required>
            
            <!-- Action Buttons -->
            <div class="flex justify-end gap-2">
                <button type="button" id="closeModal" class="px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">Simpan</button>
            </div>
        </form> 
        @if ($errors->any())
        <div class="alert alert-danger text-red-400">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <script>
            document.getElementById('closeModal').addEventListener('click', () => {
                window.location.href="{{ route('sup-admin.ruang.index') }}";
            });
        </script>
    </main>
</body>
</html>