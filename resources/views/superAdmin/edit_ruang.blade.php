<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Ruang</title>
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
        <form action="{{ route('sup-admin.ruang.update', $ruang->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="m-6">
                <label for="nama_ruang" class="form-label font-sans font-medium">Nama Ruang: </label>
                <input type="text" name="nama_ruang" class="rounded-lg w-full" value="{{ old('nama_ruang', $ruang->nama_ruang ?? '') }}" required>
            </div>
            <div class="m-6">
                <label for="kluster" class="form-label font-sans font-medium">Kluster: </label>
                <select name="kluster" id="kluster" class="rounded-lg w-full" required>
                    <option value="">Select Kluster</option>
                    {{-- @foreach ($klusters as $kluster)
                        <option value="{{ $kluster }}" {{ (old('kluster', $ruang->kluster ?? '') == $kluster) ? 'selected' : '' }}>
                            {{ $kluster }}
                        </option>
                    @endforeach --}}
                </select>
            </div>
            <div class="m-6">
                <label for="kapasitas" class="form-label font-sans font-medium">Kapasitas: </label>
                <input type="number" name="kapasitas" id="kapasitas" class="rounded-lg w-full" min="1" value="{{ old('kapasitas', $ruang->kapasitas ?? '') }}" required>
            </div>
            <div>
                <button class="bg-blue-500 p-2 text-white rounded hover:bg-blue-600" type="submit">
                    Simpan
                </button>
            </div>
        </form>
    </main>
    <x-footer></x-footer>
</body>
</html>