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
        <div class="bg-blue-500 p-2 mb-4 font-sans text-white font-medium cursor-pointer text-md w-fit rounded-md shadow-md hover:bg-blue-700">
           + Booking Ruang
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
</body>
</html>