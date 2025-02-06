<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Booking</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="icon" href="{{ asset('assets/logo-bpsdmd.png') }}?v=2" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
</head>
<body class="antialiased flex flex-col min-h-screen">
    <x-header></x-header>
    <x-sidebar></x-sidebar>
    <main class="p-16 md:ml-64 h-auto pt-20 flex-grow">
        <h2 class="font-sans text-gray-700 m-2 font-medium">Data Booking</h2>
        <table id="bookingTable" class="w-full min-w-max table-auto bg-white border rounded-lg shadow-md">
            <thead class="bg-gray-700 text-white p-1 ml-2">
                <tr>
                    <th class="p-1 text-left border-r border-white">Nama Pemesan</th>
                    <th class="p-1 text-left border-r border-white">Nama Ruang</th>
                    <th class="p-1 text-left border-r border-white">Kluster</th>
                    <th class="p-1 text-left border-r border-white">Gedung</th>
                    <th class="p-1 text-left border-r border-white">Tanggal Mulai</th>
                    <th class="p-1 text-left border-r border-white">Tanggal Selesai</th>
                    <th class="p-1 text-left">Status</th>
            </thead>
        </table>
    </main>
    <x-footer></x-footer>

    <script>
        $(document).ready(function () {
            $('#bookingTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.get.data') }}',
                columns: [
                    { data: 'nama_pemesan', name: 'nama_pemesan' },
                    { data: 'nama_ruang', name: 'nama_ruang' },
                    { data: 'kluster', name: 'kluster' },
                    { data: 'gedung', name: 'gedung' },
                    { data: 'tanggal_start', name: 'tanggal_start' },
                    { data: 'tanggal_end', name: 'tanggal_end' },
                    { data: 'status', name: 'status' },
                ]
            });
        });
    </script>
</body>
</html>
