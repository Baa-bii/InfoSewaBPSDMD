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
            <div>
                <form class="flex flex-row m-2">
                    @csrf
                    <div class="border-2 border-gray-400 w-fit rounded-md ml-3 text-sm">
                        <label for="filter_kluster" class="form-label font-sans font-medium ml-1">Filter by Kluster</label>
                        <select name="filter_kluster" id="filter_kluster" class="text-sm mr-1" onchange="this.form.submit()">
                            <option value="">Semua Kluster</option>
                            @foreach ($klusters as $kluster)
                                <option value="{{ $kluster->kluster }}" {{ request('filter_kluster') == $kluster->kluster ? 'selected' : '' }}>
                                    {{ $kluster->kluster }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                
                    <div class="border-2 border-gray-400 w-fit rounded-md ml-3 text-sm">
                        <label for="filter_gedung" class="form-label font-sans font-medium ml-1">Filter by Gedung</label>
                        <select name="filter_gedung" id="filter_gedung" class="text-sm mr-1" onchange="this.form.submit()">
                            <option value="">Semua Gedung</option>
                            <!-- Gedung options will be populated dynamically based on selected kluster -->
                        </select>
                    </div>
                </form>                
                
                <!-- Table displaying the filtered and paginated results -->
                <table class="w-full min-w-max table-auto bg-white border rounded-lg shadow-md">
                    <thead class="bg-gray-700 text-white">
                        <tr class="border border-gray-300">
                            <th class="p-2 text-left border-r border-white">Nama Ruang</th>
                            <th class="p-2 text-left border-r border-white">Gedung</th>
                            <th class="p-2 text-left border-r border-white">Kluster</th>
                            <th class="p-2 text-left border-r border-white">Kapasitas</th>
                            <th class="p-2 text-left border-r border-white">Harga</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-300">
                        @foreach ($ruang as $item)
                        <tr>
                            <td class="py-1 px-2 border-r border-gray-500">{{ $item->nama_ruang }}</td>
                            <td class="py-1 px-2 border-r border-gray-500">{{ $item->gedung }}</td>
                            <td class="py-1 px-2 border-r border-gray-500">{{ $item->kluster }}</td>
                            <td class="py-1 px-2 border-r border-gray-500">{{ $item->kapasitas }}</td>
                            <td class="py-1 px-2 border-r border-gray-500">{{ $item->harga }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <!-- Pagination -->
                <div class="mt-4">
                    {{ $ruang->appends(['filter_kluster' => request('filter_kluster'), 'filter_gedung' => request('filter_gedung')])->links() }}
                </div>
                
        
        
</main>
<x-footer></x-footer>
<script>
            // Gedung List per Kluster
            const gedungList = @json($gedungList); // Passing the gedung list from PHP to JavaScript

            // Update the Gedung dropdown based on the selected Kluster
            function updateGedungOptions() {
                const kluster = document.getElementById('filter_kluster').value;
                const gedungSelect = document.getElementById('filter_gedung');

                // Clear current options
                gedungSelect.innerHTML = '<option value="">Semua Gedung</option>';

                // Get the corresponding gedung list for the selected kluster
                const gedungs = gedungList[kluster] || [];

                // Add options based on selected kluster
                gedungs.forEach(function(gedung) {
                    const option = document.createElement('option');
                    option.value = gedung;
                    option.textContent = gedung;
                    gedungSelect.appendChild(option);
                });

                // Optionally, submit the form here if you want to immediately filter by kluster
                // this.form.submit();
            }

            // Initial setup: populate the Gedung dropdown if there is already a selected Kluster
            document.addEventListener('DOMContentLoaded', function() {
                updateGedungOptions();
            });                
</script>

</body>
</html>