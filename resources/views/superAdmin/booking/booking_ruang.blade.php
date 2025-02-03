<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Ruang</title>
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
        <div class="bg-blue-500 p-2 mb-4 font-sans text-white font-medium cursor-pointer text-md w-fit rounded-md shadow-md hover:bg-blue-700" id="openModal"
        onclick="loadBookingForm('{{ route('sup-admin.booking.create') }}')">
            + Booking Ruang
        </div>

        <!-- Modal -->
        <div id="bookingModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full h-fit">
                <h2 class="text-xl font-bold mb-4">Booking Ruang</h2>
                <form action="{{ route('sup-admin.booking.store') }}" method="POST">
                    @csrf
                    <!-- Nama Pemesan -->
                    <label for="nama_pemesan" class="block text-sm font-medium">Nama Pemesan</label>
                    <input id="nama_pemesan" name="nama_pemesan" type="text" class="w-fit p-1 border rounded-md mb-2">

                    <!-- Tanggal Mulai dan Tanggal Akhir -->
                    <div class="flex space-x-4 mb-2">
                        <div class="w-full">
                            <label for="tanggal_start" class="block text-sm font-medium">Tanggal Mulai</label>
                            <input id="tanggal_start" name="tanggal_start" type="date" class="w-full p-1 border rounded-md">
                        </div>
                        <div class="w-full">
                            <label for="tanggal_end" class="block text-sm font-medium">Tanggal Akhir</label>
                            <input id="tanggal_end" name="tanggal_end" type="date" class="w-full p-1 border rounded-md">
                        </div>
                    </div>
                    
                    <div class="flex space-x-4 mb-2">
                        <!-- Kluster Dropdown -->
                        <div class="w-full">
                            <label for="cluster" class="block text-sm font-medium">Kluster</label>
                            <select id="cluster" name="kluster" class="w-full p-1 border rounded-md" required disabled>
                                <option value="" disabled selected>Pilih Kluster</option>
                                <option value="Sumbing">Sumbing</option>
                                <option value="Muria">Muria</option>
                                <option value="Sindoro">Sindoro</option>
                                <option value="Merbabu">Merbabu</option>
                                <option value="Merapi">Merapi</option>
                            </select>
                        </div>

                        <!-- Gedung Dropdown -->
                        <div class="w-full">
                            <label for="gedung" class="block text-sm font-medium">Gedung</label>
                            <select id="gedung" name="gedung" class="w-full p-1 border rounded-md mb-2" required disabled>
                                <option value="" disabled selected>Pilih Gedung</option>
                            </select>
                        </div>

                        <!-- Room Dropdown -->
                        <div class="w-full">
                            <label for="room" class="block text-sm font-medium">Ruang</label>
                            <select id="room" name="id_ruang" class="w-full p-1 border rounded-md mb-2" required disabled>
                                <option value="" disabled selected>Pilih Ruang</option>
                            </select>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            // Get all necessary elements
                            const startDateInput = document.getElementById('tanggal_start');
                            const endDateInput = document.getElementById('tanggal_end');
                            const clusterSelect = document.getElementById('cluster');
                            const gedungSelect = document.getElementById('gedung');
                            const roomSelect = document.getElementById('room');

                            // Initially disable all dropdowns
                            clusterSelect.disabled = true;
                            gedungSelect.disabled = true;
                            roomSelect.disabled = true;

                            // Function to check dates and enable/disable cluster
                            function checkDates() {
                                const startDate = new Date(startDateInput.value);
                                const endDate = new Date(endDateInput.value);

                                if (startDateInput.value && endDateInput.value && startDate <= endDate) {
                                    clusterSelect.disabled = false;
                                } else {
                                    clusterSelect.disabled = true;
                                    // Reset and disable dependent dropdowns
                                    clusterSelect.value = '';
                                    gedungSelect.value = '';
                                    roomSelect.value = '';
                                    gedungSelect.disabled = true;
                                    roomSelect.disabled = true;
                                }
                            }

                            // Add event listeners to date inputs
                            startDateInput.addEventListener('change', checkDates);
                            endDateInput.addEventListener('change', checkDates);

                            // Cluster change event
                            clusterSelect.addEventListener('change', function() {
                                const selectedCluster = this.value;
                                
                                // Reset and enable gedung dropdown
                                gedungSelect.innerHTML = '<option value="" disabled selected>Pilih Gedung</option>';
                                gedungSelect.disabled = false;

                                // Reset and disable room dropdown
                                roomSelect.innerHTML = '<option value="" disabled selected>Pilih Ruang</option>';
                                roomSelect.disabled = true;

                                // Fetch gedung options
                                fetch(`/api/get-gedung?kluster=${selectedCluster}`)
                                    .then(response => response.json())
                                    .then(data => {
                                        data.forEach(gedung => {
                                            const option = document.createElement('option');
                                            option.value = gedung;
                                            option.textContent = gedung;
                                            gedungSelect.appendChild(option);
                                        });
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        alert('Failed to fetch gedung data');
                                    });
                            });

                            // Gedung change event
                            gedungSelect.addEventListener('change', function() {
                                const selectedGedung = this.value;
                                const selectedCluster = clusterSelect.value;
                                
                                console.log('Selected Cluster:', selectedCluster); // Debug log
                                console.log('Selected Gedung:', selectedGedung);   // Debug log

                                // Enable and reset room dropdown
                                roomSelect.innerHTML = '<option value="" disabled selected>Pilih Ruang</option>';
                                roomSelect.disabled = false;

                                // Fetch room options
                                fetch(`/api/get-rooms?kluster=${encodeURIComponent(selectedCluster)}&gedung=${encodeURIComponent(selectedGedung)}`)
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error(`HTTP error! status: ${response.status}`);
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        console.log('Received room data:', data); // Debug log
                                        if (data && data.length > 0) {
                                            data.forEach(room => {
                                                const option = document.createElement('option');
                                                option.value = room.id;
                                                option.textContent = room.nama_ruang;
                                                roomSelect.appendChild(option);
                                            });
                                        } else {
                                            console.log('No rooms found for this combination');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Detailed error:', error);
                                        alert('Failed to fetch room data: ' + error.message);
                                    });
                            });
                        });

                    </script>
                    @if ($errors->any())
                    <div class="alert alert-danger text-red-400">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                
                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-2">
                        <button type="button" id="closeModal" class="px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">Simpan</button>
                    </div>
                </form>                
            </div>
        </div>
        
        <div class=" grid grid-cols-5 grid-flow-row gap-4">
            <div class="bg-gray-200 w-fit h-auto shadow-lg p-2 rounded-md flex flex-row">
                <div class="flex-col">
                    <img class=" border-2 border-white rounded-md" src="/assets/room.jpg" alt="Sindoro">
                    <span class="text-gray-800 mx-2 text-lg font-semibold">Sumbing I</span>
                    <div>
                        <p class="text-sm m-2">Kapasitas:</p>
                        <p class="text-sm m-2">Harga:</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-200 w-fit h-auto shadow-lg p-2 rounded-md flex flex-row">
                <div class="flex-col">
                    <img class=" border-2 border-white rounded-md" src="/assets/room.jpg" alt="Sindoro">
                    <span class="text-gray-800 mx-2 text-lg font-semibold">Sumbing II</span>
                    <div>
                        <p class="text-sm m-2">Kapasitas:</p>
                        <p class="text-sm m-2">Harga:</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-200 w-fit h-auto shadow-lg p-2 rounded-md flex flex-row">
                <div class="flex-col">
                    <img class=" border-2 border-white rounded-md" src="/assets/room.jpg" alt="Sindoro">
                    <span class="text-gray-800 mx-2 text-lg font-semibold">Sumbing III</span>
                    <div>
                        <p class="text-sm m-2">Kapasitas:</p>
                        <p class="text-sm m-2">Harga:</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-200 w-fit h-auto shadow-lg p-2 rounded-md flex flex-row">
                <div class="flex-col">
                    <img class=" border-2 border-white rounded-md" src="/assets/room.jpg" alt="Sindoro">
                    <span class="text-gray-800 mx-2 text-lg font-semibold">Sumbing IV</span>
                    <div>
                        <p class="text-sm m-2">Kapasitas:</p>
                        <p class="text-sm m-2">Harga:</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-200 w-fit h-auto shadow-lg p-2 rounded-md flex flex-row">
                <div class="flex-col">
                    <img class=" border-2 border-white rounded-md" src="/assets/room.jpg" alt="Sindoro">
                    <span class="text-gray-800 mx-2 text-lg font-semibold">Muria I</span>
                    <div>
                        <p class="text-sm m-2">Kapasitas:</p>
                        <p class="text-sm m-2">Harga:</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-200 w-fit h-auto shadow-lg p-2 rounded-md flex flex-row">
                <div class="flex-col">
                    <img class=" border-2 border-white rounded-md" src="/assets/room.jpg" alt="Sindoro">
                    <span class="text-gray-800 mx-2 text-lg font-semibold">Muria II</span>
                    <div>
                        <p class="text-sm m-2">Kapasitas:</p>
                        <p class="text-sm m-2">Harga:</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-200 w-fit h-auto shadow-md p-2 rounded-md flex flex-row">
                <div class="flex-col">
                    <img class=" border-2 border-white rounded-md" src="/assets/room.jpg" alt="Sindoro">
                    <span class="text-gray-800 mx-2 text-lg font-semibold">Sindoro I</span>
                    <div>
                        <p class="text-sm m-2">Kapasitas:</p>
                        <p class="text-sm m-2">Harga:</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-200 w-fit h-auto shadow-md p-2 rounded-md flex flex-row">
                <div class="flex-col">
                    <img class=" border-2 border-white rounded-md" src="/assets/room.jpg" alt="Sindoro">
                    <span class="text-gray-800 mx-2 text-lg font-semibold">Sindoro II</span>
                    <div>
                        <p class="text-sm m-2">Kapasitas:</p>
                        <p class="text-sm m-2">Harga:</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-200 w-fit h-auto shadow-md p-2 rounded-md flex flex-row">
                <div class="flex-col">
                    <img class=" border-2 border-white rounded-md" src="/assets/room.jpg" alt="Sindoro">
                    <span class="text-gray-800 mx-2 text-lg font-semibold">Sindoro III</span>
                    <div>
                        <p class="text-sm m-2">Kapasitas:</p>
                        <p class="text-sm m-2">Harga:</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-200 w-fit h-auto shadow-md p-2 rounded-md flex flex-row">
                <div class="flex-col">
                    <img class=" border-2 border-white rounded-md" src="/assets/room.jpg" alt="Sindoro">
                    <span class="text-gray-800 mx-2 text-lg font-semibold">Merapi</span>
                    <div>
                        <p class="text-sm m-2">Kapasitas:</p>
                        <p class="text-sm m-2">Harga:</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-footer></x-footer>
    <script>
        // Get elements
        const openModalButton = document.getElementById('openModal');
        const closeModalButton = document.getElementById('closeModal');
        const modal = document.getElementById('bookingModal');
    
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