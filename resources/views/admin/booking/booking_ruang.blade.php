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
        onclick="loadBookingForm('{{ route('admin.booking.create') }}')">
            + Booking Ruang
        </div>

        <!-- Modal -->
        <div id="bookingModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full h-fit">
                <h2 class="text-xl font-bold mb-4">Booking Ruang</h2>
                <form id="bookingForm" action="{{ route('admin.booking.store') }}" method="POST">
                    @csrf
                    <!-- Nama Pemesan -->
                    <label for="nama_pemesan" class="block text-sm font-medium">Nama Pemesan</label>
                    <input id="nama_pemesan" name="nama_pemesan" type="text" class="w-full p-1 border rounded-md mb-2" required>

                    <!-- No KTP -->
                    <label for="no_ktp" class="block text-sm font-medium">No KTP</label>
                    <input id="no_ktp" name="no_ktp" type="text" class="w-full p-1 border rounded-md mb-2" required>

                    <!-- No Hp -->
                    <label for="no_hp" class="block text-sm font-medium">No HP</label>
                    <input id="no_hp" name="no_hp" type="text" class="w-full p-1 border rounded-md mb-2" required>

                    <!-- Keperluan -->
                    <label for="keperluan" class="block text-sm font-medium">Keperluan</label>
                    <input id="keperluan" name="keperluan" type="text" class="w-full p-1 border rounded-md mb-2" required>

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

                                if (startDateInput.value) {
                                    // Set min attribute for end date so it cannot be before start date
                                    endDateInput.min = startDateInput.value;
                                }

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

                            // Disable past dates
                            const today = new Date().toISOString().split("T")[0];
                            startDateInput.min = today;
                            endDateInput.min = today;

                            // Add event listeners to date inputs
                            startDateInput.addEventListener("change", checkDates);
                            endDateInput.addEventListener("change", checkDates);

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
                            // Event saat "Gedung" berubah
                            gedungSelect.addEventListener('change', function () {
                                const selectedGedung = this.value;
                                const selectedCluster = clusterSelect.value;
                                const tanggalStart = document.getElementById('tanggal_start').value; 
                                const tanggalEnd = document.getElementById('tanggal_end').value; 

                                console.log('Fetching available rooms with:', {
                                    kluster: selectedCluster,
                                    gedung: selectedGedung,
                                    tanggal_start: tanggalStart,
                                    tanggal_end: tanggalEnd
                                });

                                // Reset dropdown sebelum fetch
                                roomSelect.innerHTML = '<option value="" disabled selected>Pilih Ruang</option>';
                                roomSelect.disabled = false;

                                fetch(`/api/get-available-rooms?kluster=${encodeURIComponent(selectedCluster)}&gedung=${encodeURIComponent(selectedGedung)}&tanggal_start=${encodeURIComponent(tanggalStart)}&tanggal_end=${encodeURIComponent(tanggalEnd)}`)
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error(`HTTP error! status: ${response.status}`);
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    console.log('Received available rooms:', data);
                                    if (data.length > 0) {
                                        data.forEach(room => {
                                            const option = document.createElement('option');
                                            option.value = room.id;
                                            option.textContent = room.nama_ruang;
                                            roomSelect.appendChild(option);
                                        });
                                    } else {
                                        console.log('No available rooms found.');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error fetching available rooms:', error);
                                    alert('Gagal mengambil data ruangan: ' + error.message);
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
            <div class="bg-gray-900 w-fit h-auto shadow-lg p-2 rounded-md flex flex-row">
                <div class="flex-col">
                    <img class=" border-2 border-white rounded-md" src="/assets/sumbing1.jpg" alt="sumbing1">
                    <span class="text-white mx-2 text-lg font-semibold">Sumbing I</span>
                    <div class="text-white">
                        <p class="text-sm mx-2">Kapasitas: 2</p>
                        <p class="text-sm mx-2">Harga: Rp150.000</p>
                        <p class="text-sm mx-2">Jumlah kamar: 16</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-900 w-fit h-auto shadow-lg p-2 rounded-md flex flex-row">
                <div class="flex-col">
                    <img class=" border-2 border-white rounded-md" src="/assets/sumbing2.jpg" alt="sumbing2">
                    <span class="text-white mx-2 text-lg font-semibold">Sumbing II</span>
                    <div class="text-white">
                        <p class="text-sm mx-2">Kapasitas: 3</p>
                        <p class="text-sm mx-2">Harga: Rp125.000</p>
                        <p class="text-sm mx-2">Jumlah kamar: 24</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-900 w-fit h-auto shadow-lg p-2 rounded-md flex flex-row">
                <div class="flex-col">
                    <img class=" border-2 border-white rounded-md" src="/assets/sumbing3.jpg" alt="sumbing3">
                    <span class="text-white mx-2 text-lg font-semibold">Sumbing III</span>
                    <div class="text-white">
                        <p class="text-sm mx-2">Kapasitas: 3</p>
                        <p class="text-sm mx-2">Harga: Rp125.000</p>
                        <p class="text-sm mx-2">Jumlah kamar: 32</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-900 w-fit h-auto shadow-lg p-2 rounded-md flex flex-row">
                <div class="flex-col">
                    <img class=" border-2 border-white rounded-md" src="/assets/sumbing4.jpg" alt="sumbing4">
                    <span class="text-white mx-2 text-lg font-semibold">Sumbing IV</span>
                    <div class="text-white">
                        <p class="text-sm mx-2">Kapasitas: 2</p>
                        <p class="text-sm mx-2">Harga: Rp150.000</p>
                        <p class="text-sm mx-2">Jumlah kamar: 24</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-900 w-fit h-auto shadow-lg p-2 rounded-md flex flex-row">
                <div class="flex-col">
                    <img class=" border-2 border-white rounded-md" src="/assets/muria1.jpg" alt="muria1">
                    <span class="text-white mx-2 text-lg font-semibold">Muria I</span>
                    <div class="text-white">
                        <p class="text-sm mx-2">Kapasitas: 2</p>
                        <p class="text-sm mx-2">Harga: Rp200.000</p>
                        <p class="text-sm mx-2">Jumlah kamar: 22</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-900 w-fit h-auto shadow-lg p-2 rounded-md flex flex-row">
                <div class="flex-col">
                    <img class=" border-2 border-white rounded-md" src="/assets/muria2.jpg" alt="muria2">
                    <span class="text-white mx-2 text-lg font-semibold">Muria II</span>
                    <div class="text-white">
                        <p class="text-sm mx-2">Kapasitas: 2</p>
                        <p class="text-sm mx-2">Harga: Rp200.000</p>
                        <p class="text-sm mx-2">Jumlah kamar: 15</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-900 w-fit h-auto shadow-lg p-2 rounded-md flex flex-row">
                <div class="flex-col">
                    <img class=" border-2 border-white rounded-md" src="/assets/sindoro1.jpg" alt="sindoro1">
                    <span class="text-white mx-2 text-lg font-semibold">Sindoro I</span>
                    <div class="text-white">
                        <p class="text-sm mx-2">Kapasitas: 2</p>
                        <p class="text-sm mx-2">Harga: Rp150.000</p>
                        <p class="text-sm mx-2">Jumlah kamar: 48</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-900 w-fit h-auto shadow-lg p-2 rounded-md flex flex-row">
                <div class="flex-col">
                    <img class=" border-2 border-white rounded-md" src="/assets/sindoro2.jpg" alt="sindoro2">
                    <span class="text-white mx-2 text-lg font-semibold">Sindoro II</span>
                    <div class="text-white">
                        <p class="text-sm mx-2">Kapasitas: 4</p>
                        <p class="text-sm mx-2">Harga: Rp100.000</p>
                        <p class="text-sm mx-2">Jumlah kamar: 45</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-900 w-fit h-auto shadow-lg p-2 rounded-md flex flex-row">
                <div class="flex-col">
                    <img class=" border-2 border-white rounded-md" src="/assets/sindoro3.jpg" alt="sindoro3">
                    <span class="text-white mx-2 text-lg font-semibold">Sindoro III</span>
                    <div class="text-white">
                        <p class="text-sm mx-2">Kapasitas: 2</p>
                        <p class="text-sm mx-2">Harga: Rp150.000</p>
                        <p class="text-sm mx-2">Jumlah kamar: 48</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-900 w-fit h-auto shadow-lg p-2 rounded-md flex flex-row">
                <div class="flex-col">
                    <img class=" border-2 border-white rounded-md" src="/assets/merapi.jpg" alt="merapi">
                    <span class="text-white mx-2 text-lg font-semibold">Merapi</span>
                    <div class="text-white">
                        <p class="text-sm mx-2">Kapasitas: 2</p>
                        <p class="text-sm mx-2">Harga: Rp200.000</p>
                        <p class="text-sm mx-2">Jumlah kamar: 50</p>
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
        const form = document.getElementById('bookingForm'); // Replace with your form's actual ID
    
        // Open modal
        openModalButton.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });
    
        // Close modal and reset form
        closeModalButton.addEventListener('click', () => {
            modal.classList.add('hidden');
            if (form) {
                form.reset(); // Clears all form fields
            }
        });

        // Close modal when clicking outside the modal
        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
                if (form) {
                    form.reset(); // Clears form when clicking outside modal
                }
            }
        });
    </script>
    
</body>
</html>