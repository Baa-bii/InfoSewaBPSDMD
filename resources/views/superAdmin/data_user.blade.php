<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data User</title>
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
        <h2 class="font-sans text-gray-700 m-2 font-medium">Data User</h2>
        <table class="w-full min-w-max table-auto bg-white border rounded-lg shadow-md">
            <thead class="bg-gray-700 text-white">
                <tr class="border border-gray-300">
                    <th class="p-2 text-left border-r border-white">Nama User</th>
                    <th class="p-2 text-left border-r border-white">Email</th>
                    <th class="p-2 text-left border-r border-white">Role</th>
                    <th class="p-2 text-left border-r border-white">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-300">
                <!-- Contoh Data 1 -->
                @foreach ($users as $item)
                <tr>
                    <td class="py-1 px-2 border-r border-gray-500">{{ $item->name }}</td>
                    <td class="py-1 px-2 border-r border-gray-500">{{ $item->email }}</td>
                    <td class="py-1 px-2 border-r border-gray-500">{{ $item->role }}</td>
                    <td class="py-1 px-2 ">
                        <a href="#">
                            <button class="bg-green-400 w-auto p-1 rounded text-white hover:bg-green-500 shadow-md">
                                Edit
                            </button>
                        </a>
                        <form action="#" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 w-auto p-1 rounded text-white hover:bg-red-600 shadow-md">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </main>
    <x-footer></x-footer>
</body>
</html>