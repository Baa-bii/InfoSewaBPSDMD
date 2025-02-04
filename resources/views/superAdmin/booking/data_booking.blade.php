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
                    <th class="p-1 text-left border-r border-white">Validasi</th>
                    <th class="p-1 text-left border-r border-white">Status Pembayaran</th>
                    <th class="p-1 text-left">Aksi</th>
                </tr>
            </thead>
        </table>
    </main>
    <x-footer></x-footer>

    <script>
        $(document).ready(function () {
            $('#bookingTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('sup-admin.get.data') }}',
                columns: [
                    { data: 'nama_pemesan', name: 'nama_pemesan' },
                    { data: 'nama_ruang', name: 'nama_ruang' },
                    { data: 'kluster', name: 'kluster' },
                    { data: 'gedung', name: 'gedung' },
                    { data: 'tanggal_start', name: 'tanggal_start' },
                    { data: 'tanggal_end', name: 'tanggal_end' },
                    { data: 'validasi', name: 'validasi', orderable: false, searchable: false },
                    { data: 'status', name: 'status' },
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false },
                ]
            });
        });
        

        function validasi(id) {
                $.ajax({
                    url: '{{ route("booking.updateStatus", ":id") }}'.replace(':id', id),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            alert("Status updated to: " + response.status);

                            // Find the row in the DataTable using its ID (the ID must be present in a column like 'id')
                            var table = $('#bookingTable').DataTable();

                            // Get the row with the ID
                            var row = table.row('[data-id="'+id+'"]');

                            // Find the cell for the status column and update it
                            var statusCell = row.cell(':eq(6)'); // 6 is the index of the status column, change if needed

                            // Update the status text and its color dynamically
                            if (response.status === 'belum') {
                                statusCell.data('Belum').draw(); // Set new data for the status cell and redraw it
                                row.node().querySelector('.status-text').classList.add('text-red-500'); // Add red class for 'belum'
                                row.node().querySelector('.status-text').classList.remove('text-green-500'); // Remove green class
                            } else {
                                statusCell.data('Sudah').draw(); // Set new data for the status cell and redraw it
                                row.node().querySelector('.status-text').classList.add('text-green-500'); // Add green class for 'sudah'
                                row.node().querySelector('.status-text').classList.remove('text-red-500'); // Remove red class
                            }

                            // Optionally, update the validasi button text
                            var validasiButton = row.node().querySelector('.validasi-btn');
                            validasiButton.textContent = response.status === 'belum' ? 'Validasi' : 'Validasi';
                        }
                    },
                    error: function() {
                        alert("Failed to update status");
                    }
                });
            }
    </script>
</body>
</html>
