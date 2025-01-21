<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            <input id="room" name="nama_ruang" type="text" class="w-2/4 p-2 border border-gray-400 rounded-md mb-4" placeholder="Nama Ruang baru" required>
            
            <!-- Kluster Input -->
            <label for="kluster" class="form-label font-sans font-medium m-2">Kluster:</label>
            <select name="kluster" id="kluster" class="w-fit p-2 border border-gray-400 rounded-md mb-4" required>
                <option value="">Select Kluster</option>
                @foreach (['Sumbing', 'Muria', 'Sindoro', 'Merbabu', 'Merapi'] as $kluster)
                    <option value="{{ $kluster }}">{{ $kluster }}</option>
                @endforeach
            </select>

            <!-- Gedung Input -->
            <label for="gedung" class="form-label font-sans font-medium m-2">Gedung:</label>
            <select name="gedung" id="gedung" class="w-fit p-2 border border-gray-400 rounded-md mb-4" required>
                <option value="">Select Gedung</option>
            </select>

            <!-- Kapasitas -->
            <label for="kapasitas" class="form-label text-sm font-medium m-2">Kapasitas</label>
            <input id="kapasitas" name="kapasitas" type="number" class="w-fit p-2 border border-gray-400 rounded-md mb-4" placeholder="Kapasitas Ruang Baru" min="1" required>
            
            <!-- Harga -->
            <label for="harga" class="form-label text-sm font-medium m-2">Harga</label>
            <input id="harga" name="harga" type="text" class="w-fit p-2 border border-gray-400 rounded-md mb-4" placeholder="Harga Ruang Baru" min="1" required>

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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            document.getElementById('closeModal').addEventListener('click', () => {
                window.location.href="{{ route('sup-admin.ruang.index') }}";
            });

            $(document).ready(function () {
            $('#kluster').on('change', function () {
                let kluster = $(this).val();
                $('#gedung').html('<option value="">Loading...</option>');

                if (kluster) {
                    $.ajax({
                        url: `/sup-admin/get-gedung/${kluster}`,
                        type: 'GET',
                        success: function (data) {
                            let options = '<option value="">Select Gedung</option>';
                            data.forEach(function (gedung) {
                                options += `<option value="${gedung}">${gedung}</option>`;
                            });
                            $('#gedung').html(options);
                        },
                        error: function () {
                            $('#gedung').html('<option value="">Error loading gedung</option>');
                        }
                    });
                } else {
                    $('#gedung').html('<option value="">Select Gedung</option>');
                }
            });
        });


        </script>
    </main>
</body>
</html>