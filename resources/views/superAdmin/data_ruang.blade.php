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
            <a class="inline-block" href="{{ route('sup-admin.ruang.create') }}">
                <div class="bg-blue-500 p-2 mb-4 font-sans text-white font-medium cursor-pointer text-md w-fit rounded-md shadow-md hover:bg-blue-700" id="openModal">
                    + Tambahkan Ruang
                </div>
            </a>
            <div>
                <form method="GET" action="{{ route('sup-admin.ruang.index') }}" class="flex flex-row m-2">
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
                            <th class="p-2 text-left">Aksi</th>
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
                            <td class="py-1 px-2">
                                <a href="{{ route('sup-admin.ruang.edit', $item->id) }}">
                                    <button class="bg-green-400 w-auto p-1 rounded text-white hover:bg-green-500 shadow-md">
                                        Edit
                                    </button>
                                </a>
                                <!-- Delete Button -->
                                <button class="delete-btn bg-red-500 w-auto p-1 rounded text-white hover:bg-red-600 shadow-md" data-action="{{ route('sup-admin.ruang.destroy', $item->id) }}">
                                    Delete
                                </button>

                                <!-- Modal Persetujuan Penghapusan -->
                                <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden">
                                    <div class="bg-white p-8 rounded-lg shadow-md">
                                        <h3 class="text-xl font-semibold mb-4">Apakah Anda yakin ingin menghapus ruang ini?</h3>
                                        <div class="flex justify-end gap-4">
                                            <button id="cancelBtn" class="px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400">Batal</button>
                                            <form id="deleteForm" action="" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </td>
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
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default action

            // Show the confirmation modal
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('hidden');

            // Set the action URL for the delete form
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.action = button.dataset.action; // Set form action based on data-action attribute
        });
    });

    // Handle the cancel button click
    document.getElementById('cancelBtn').addEventListener('click', function() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden'); // Hide the modal
    });
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