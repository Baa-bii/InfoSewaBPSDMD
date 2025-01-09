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
        <table class="min-w-full bg-white border rounded-lg">
        <thead class="bg-gray-700 text-white">
            <tr class="border border-gray-300">
                <th class="py-2 px-4 text-left border-r border-white">Nama Gedung</th>
                <th class="py-2 px-4 text-left border-r border-white">Kluster</th>
                <th class="py-2 px-4 text-left border-r border-white">Jumlah Ruang</th>
                <th class="py-2 px-4 text-left border-r border-white">Kuota</th>
                <th class="py-2 px-4 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-300">
            <!-- Contoh Data 1 -->
            <tr>
                <td class="py-2 px-4 border-r border-gray-500">Sindoro</td>
                <td class="py-2 px-4 border-r border-gray-500">Sindoro I</td>
                <td class="py-2 px-4 border-r border-gray-500">10</td>
                <td class="py-2 px-4 border-r border-gray-500">5</td>
                <td class="p-4 border-b">
                    <a href="#">
                    <button class="bg-green-400 w-auto p-1 rounded text-white hover:bg-green-500 shadow-md">
                        Edit
                    </button>
                    <form action="#" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 w-auto p-1 rounded text-white hover:bg-red-600 shadow-md">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
</main>
    
</body>
</html>