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
    <main  class="p-16 md:ml-64 h-auto pt-20 flex-grow">
        <div class="bg-blue-500 p-2 mb-4 font-sans text-white font-medium cursor-pointer text-md w-fit rounded-md shadow-md hover:bg-blue-700" id="openModal">
            + Booking Ruang
        </div>
        
        <!-- Modal -->
        <div id="bookingModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
                <h2 class="text-xl font-bold mb-4">Booking Ruang</h2>
                <form>
                    <!-- Kluster Dropdown -->
                    <label for="cluster" class="block text-sm font-medium mb-2">Kluster</label>
                    <select id="cluster" class="w-full p-2 border rounded-md mb-4">
                        <option value="" disabled selected>Pilih Kluster</option>
                        <option value="cluster1">Kluster 1</option>
                        <option value="cluster2">Kluster 2</option>
                        <option value="cluster3">Kluster 3</option>
                    </select>
                
                    <!-- Nama Ruang Dropdown -->
                    <label for="room" class="block text-sm font-medium mb-2">Nama Ruang</label>
                    <select id="room" class="w-full p-2 border rounded-md mb-4">
                        <option value="" disabled selected>Pilih Nama Ruang</option>
                        <option value="ruang1">Ruang 1</option>
                        <option value="ruang2">Ruang 2</option>
                        <option value="ruang3">Ruang 3</option>
                    </select>
                
                    <!-- Tanggal Mulai -->
                    <label for="start_date" class="block text-sm font-medium mb-2">Tanggal Mulai</label>
                    <input id="start_date" type="date" class="w-full p-2 border rounded-md mb-4">
                
                    <!-- Tanggal Akhir -->
                    <label for="end_date" class="block text-sm font-medium mb-2">Tanggal Akhir</label>
                    <input id="end_date" type="date" class="w-full p-2 border rounded-md mb-4">
                
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