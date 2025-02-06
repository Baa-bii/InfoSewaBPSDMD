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
                    <th class="p-1 text-left border-r border-white">Status</th>
                    <th class="p-1 text-left">Aksi</th>
                </tr>
            </thead>
        </table>
        <!-- Modal Edit Booking -->
        <div id="editBookingModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full h-fit">
                <h2 class="text-xl font-bold mb-4">Edit Booking</h2>
                <form id="editBookingForm" method="POST">
                    @csrf
                    @method('PUT')
        
                    <input type="hidden" id="edit_id" name="id">
        
                    <label for="edit_nama_pemesan">Nama Pemesan</label>
                    <input id="edit_nama_pemesan" name="nama_pemesan" type="text" class="w-full p-1 border rounded-md" required>
        
                    <label for="edit_no_ktp">No KTP</label>
                    <input id="edit_no_ktp" name="no_ktp" type="text" class="w-full p-1 border rounded-md" required>
        
                    <label for="edit_no_hp">No HP</label>
                    <input id="edit_no_hp" name="no_hp" type="text" class="w-full p-1 border rounded-md" required>
        
                    <label for="edit_keperluan">Keperluan</label>
                    <input id="edit_keperluan" name="keperluan" type="text" class="w-full p-1 border rounded-md" required>
        
                    <label for="edit_tanggal_start">Tanggal Mulai</label>
                    <input id="edit_tanggal_start" name="tanggal_start" type="date" class="w-full p-1 border rounded-md">
        
                    <label for="edit_tanggal_end">Tanggal Akhir</label>
                    <input id="edit_tanggal_end" name="tanggal_end" type="date" class="w-full p-1 border rounded-md">
        
                    <label for="edit_status">Status</label>
                    <select id="edit_status" name="status" class="w-full p-1 border rounded-md">
                        <option value="belum">Belum</option>
                        <option value="sudah">Sudah</option>
                    </select>
        
                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" id="closeEditModal" onclick="closeEditModal()" class="px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Hapus Booking -->
        <div id="deleteBookingModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full h-fit">
                <h2 class="text-xl font-bold mb-4">Konfirmasi Penghapusan</h2>
                <p>Apakah Anda yakin ingin menghapus data booking ini?</p>
                <div class="flex justify-end gap-2 mt-4">
                    <button id="closeDeleteModal" type="button" onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400">Batal</button>
                    <button id="confirmDeleteBtn" type="button" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700">Hapus</button>
                </div>
            </div>
        </div>

        
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
                    { 
                        data: 'tanggal_start', 
                        name: 'tanggal_start',
                        render: function (data) {
                            return formatTanggal(data);
                        }
                    },
                    { 
                        data: 'tanggal_end', 
                        name: 'tanggal_end',
                        render: function (data) {
                            return formatTanggal(data);
                        }
                    },
                    { data: 'validasi', name: 'validasi', orderable: false, searchable: false },
                    { data: 'status', name: 'status' },
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false },
                ]
            });
        });

        // Fungsi untuk mengubah format tanggal menjadi dd-mm-yyyy
        function formatTanggal(dateString) {
            if (!dateString) return '';
            
            let date = new Date(dateString);
            let day = String(date.getDate()).padStart(2, '0');
            let month = String(date.getMonth() + 1).padStart(2, '0'); // Bulan dimulai dari 0
            let year = date.getFullYear();

            return `${day}-${month}-${year}`;
        }

        

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

            function editBooking(id) {
                fetch(`/sup-admin/booking/${id}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            alert("Data tidak ditemukan");
                            return;
                        }

                        // Set form action dynamically
                        document.getElementById('editBookingForm').action = `/sup-admin/booking/${data.id}`;

                        // Populate form fields
                        document.getElementById('edit_id').value = data.id;
                        document.getElementById('edit_nama_pemesan').value = data.nama_pemesan;
                        document.getElementById('edit_no_ktp').value = data.no_ktp;
                        document.getElementById('edit_no_hp').value = data.no_hp;
                        document.getElementById('edit_keperluan').value = data.keperluan;
                        document.getElementById('edit_tanggal_start').value = data.tanggal_start;
                        document.getElementById('edit_tanggal_end').value = data.tanggal_end;
                        document.getElementById('edit_status').value = data.status;

                        // Show the modal
                        document.getElementById('editBookingModal').classList.remove('hidden');
                    })
                    .catch(error => {
                        console.error("Gagal mengambil data booking:", error);
                        alert("Terjadi kesalahan saat memuat data.");
                    });
            }


            // Tutup Modal Edit
            document.getElementById('closeEditModal').addEventListener('click', function () {
                document.getElementById('editBookingModal').classList.add('hidden');
            });

            let deleteBookingId = null;

            function openDeleteModal(id) {
                deleteBookingId = id; // Store the booking ID to be deleted
                document.getElementById('deleteBookingModal').classList.remove('hidden'); // Show the modal
            }

            // Close the modal
            function closeDeleteModal() {
                document.getElementById('deleteBookingModal').classList.add('hidden'); // Hide the modal
            }

            // Confirm deletion
            document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
                if (deleteBookingId) {
                    // Make the AJAX call to delete the booking
                    $.ajax({
                        url: '/sup-admin/booking/' + deleteBookingId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            alert("Booking deleted successfully");
                            // Optionally reload the data or remove the deleted row from the table
                            $('#bookingTable').DataTable().ajax.reload();
                            closeDeleteModal(); // Close the modal
                        },
                        error: function () {
                            alert("Failed to delete booking");
                        }
                    });
                }
            });

    </script>
</body>
</html>
