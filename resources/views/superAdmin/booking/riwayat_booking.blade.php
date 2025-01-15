<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Booking</title>
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
        <h2 class="font-sans text-gray-700 m-2 font-medium">Riwayat Booking</h2>
        <table class="w-full min-w-max table-auto bg-white border rounded-lg shadow-md">
            <thead class="bg-gray-700 text-white">
                <tr class="border border-gray-300">
                    <th class="p-2 text-left border-r border-white">Nama Ruang</th>
                    <th class="p-2 text-left border-r border-white">Kluster</th>
                    <th class="p-2 text-left border-r border-white">Kapasitas</th>
                    <th class="p-2 text-left border-r border-white">Tanggal Mulai</th>
                    <th class="p-2 text-left border-r border-white">Tanggal Selesai</th>
                    <th class="p-2 text-left border-r border-white">Status Pembayaran</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-300">
                <!-- Contoh Data 1 -->
                <tr>
                    <td class="py-1 px-2 border-r border-gray-500">101</td>
                    <td class="py-1 px-2 border-r border-gray-500">Sindoro I</td>
                    <td class="py-1 px-2 border-r border-gray-500">5</td>
                    <td class="py-1 px-2 border-r border-gray-500">10/1/2025</td>
                    <td class="py-1 px-2 border-r border-gray-500">10/2/2025</td>
                    <td class="py-1 px-2 text-red-500 font-medium">Belum Dibayar</td>
                </tr>
            </tbody>
        </table>
    </main>
    <x-footer></x-footer>
</body>
</html>