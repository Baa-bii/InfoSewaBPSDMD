<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
        <h1 class="font-sans text-2xl font-semibold p-4">Dashboard</h1>
        <div class="relative w-full mt-6 rounded-xl overflow-hidden" id="carousel">
            <div class="carousel-inner relative w-full h-96">
                <div class="carousel-item absolute inset-0 opacity-100 transition-opacity duration-1000">
                    <img src="/assets/bpsdmd2.jpg" class="w-full h-full object-cover" alt="Slide 1">
                </div>
                <div class="carousel-item absolute inset-0 opacity-0 transition-opacity duration-1000">
                    <img src="/assets/bpsdmd.jpg" class="w-full h-full object-cover" alt="Slide 2">
                </div>
            </div>

            <!-- Navigasi manual -->
            <button id="prevSlide" class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-30 text-white p-2">
                &#10094;
            </button>
            <button id="nextSlide" class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-30 text-white p-2">
                &#10095;
            </button>
        </div>
        <script>//script carousel
            const items = document.querySelectorAll('#carousel .carousel-item');
            const total = items.length;
            let index = 0;
            let interval = setInterval(showNextSlide, 5000); // otomatis setiap 5 detik

            function showSlide(idx) {
                items.forEach((item, i) => {
                    item.style.opacity = (i === idx) ? '1' : '0';
                });
            }

            function showNextSlide() {
                index = (index + 1) % total;
                showSlide(index);
            }

            function showPrevSlide() {
                index = (index - 1 + total) % total;
                showSlide(index);
            }

            document.getElementById('nextSlide').addEventListener('click', () => {
                showNextSlide();
                resetInterval();
            });

            document.getElementById('prevSlide').addEventListener('click', () => {
                showPrevSlide();
                resetInterval();
            });

            function resetInterval() {
                clearInterval(interval);
                interval = setInterval(showNextSlide, 5000);
            }

            // Inisialisasi
            showSlide(index);
        </script>

        
            <div class="pt-2 mt-8 w-full">
                <div class="bg-white shadow-lg overflow-hidden">
                    <div class="flex items-center justify-between px-4 py-3 bg-gray-700 rounded-t-lg">
                        <button id="prevMonth" class="text-white text-md hover:text-blue-400">Prev</button>
                        <h2 id="currentMonth" class="text-white font-medium text-md"></h2>
                        <button id="nextMonth" class="text-white text-md hover:text-blue-400">Next</button>
                    </div>
                    <div class="grid grid-cols-7 gap-1 p-1 " id="calendar">
                        <!-- Calendar Days Go Here -->
                    </div>
                </div>
            
                <div id="myModal" class="modal hidden fixed inset-0 flex items-center justify-center z-50">
                    <!-- Modal Overlay -->
                    <div class="modal-overlay absolute inset-0 bg-black bg-opacity-60"></div>
                
                    <!-- Modal Container -->
                    <div class="modal-container bg-white w-11/12 md:max-w-lg mx-auto rounded-xl shadow-2xl z-50 overflow-hidden">
                        <!-- Modal Content -->
                        <div class="modal-content py-6 px-8 text-gray-800">
                            <!-- Modal Header -->
                            <div class="flex justify-between items-center pb-2 border-b">
                                <h3 class="text-xl font-bold text-gray-700">Tanggal</h3>
                                <button id="closeModal" class="modal-close p-2 rounded-full bg-gray-200 hover:bg-gray-300 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                
                            <!-- Modal Body -->
                            <div id="modalDate" class="text-lg font-semibold p-1 text-center text-gray-700"></div>
                            <div>
                                <table class="w-full min-w-max table-auto bg-white border rounded-lg shadow-md">
                                    <thead>
                                        <tr class="border border-gray-300 bg-gray-500">
                                            <th class="p-2 text-left text-white border-r border-white">Kluster</th>
                                            <th class="p-2 text-left text-white border-r border-white">Gedung</th>
                                            <th class="p-2 text-left text-white">No Kamar</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-300">
                                        @forelse ($bookings as $item)
                                        <tr>
                                            <td class="py-1 px-2 border-r border-gray-300">{{ $item->kluster }}</td>
                                            <td class="py-1 px-2 border-r border-gray-300">{{ $item->kluster }} {{ $item->gedung }}</td>
                                            <td class="py-1 px-2 ">{{ $item->nama_ruang }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3" class="py-2 text-center">Tidak ada booking untuk tanggal ini.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
    </main>
    <x-footer></x-footer>
</body>
</html>

<script>
    function fetchBookingDates(year, month) {
        console.log(`Fetching bookings for year: ${year}, month: ${month + 1}`);
        
        fetch(`/api/bookings?year=${year}&month=${month + 1}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(bookings => {
                console.log('Received bookings:', bookings);

                // Transform the booking dates
                const bookedDates = bookings.map(booking => ({
                    start: new Date(booking.tanggal_start).getDate(),
                    end: new Date(booking.tanggal_end).getDate()
                }));

                console.log('Processed bookedDates:', bookedDates);
                generateCalendar(year, month, bookedDates);
            })
            .catch(error => {
                console.error('Error fetching bookings:', error);
                // If there's an error, still generate the calendar but without bookings
                generateCalendar(year, month, []);
            });
    }

    function fetchBookingForDate(year, month, day) {
        // Format tanggal ke YYYY-MM-DD
        const formattedMonth = (month + 1).toString().padStart(2, '0');
        const formattedDay = day.toString().padStart(2, '0');
        const dateString = `${year}-${formattedMonth}-${formattedDay}`;

        // Log URL yang akan dipanggil
        console.log('Fetching URL:', `/api/bookings/${dateString}`);

        // Tambahkan loading state
        const tbody = document.querySelector('#myModal tbody');
        tbody.innerHTML = `
            <tr>
                <td colspan="3" class="py-2 text-center">
                    <div class="animate-pulse">Mengambil data...</div>
                </td>
            </tr>
        `;

        // Lakukan fetch dengan debugging
        fetch(`/api/bookings/${dateString}`)
            .then(response => {
                // Log response status dan headers
                console.log('Response status:', response.status);
                console.log('Response headers:', Array.from(response.headers.entries()));
                
                if (!response.ok) {
                    return response.text().then(text => {
                        console.log('Error response body:', text);
                        throw new Error(`HTTP error! status: ${response.status}`);
                    });
                }
                return response.json();
            })
            .then(bookings => {
                console.log('Received bookings:', bookings);
                tbody.innerHTML = '';

                if (bookings && bookings.length > 0) {
                    bookings.forEach(booking => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td class="py-1 px-2 border-r border-gray-300">${booking.kluster || '-'}</td>
                            <td class="py-1 px-2 border-r border-gray-300">${booking.gedung || '-'}</td>
                            <td class="py-1 px-2">${booking.nama_ruang || '-'}</td>
                        `;
                        tbody.appendChild(tr);
                    });
                } else {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="3" class="py-2 text-center">
                                Tidak ada booking untuk tanggal ini.
                            </td>
                        </tr>
                    `;
                }
            })
            .catch(error => {
                console.error('Error details:', error);
                tbody.innerHTML = `
                    <tr>
                        <td colspan="3" class="py-2 text-center text-red-500">
                            Terjadi kesalahan saat mengambil data booking. 
                        </td>
                    </tr>
                `;
            });
    }

    function generateCalendar(year, month, bookedDates) {
        const calendarElement = document.getElementById('calendar');
        const currentMonthElement = document.getElementById('currentMonth');
        
        const firstDayOfMonth = new Date(year, month, 1);
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        
        // Clear existing calendar content
        calendarElement.innerHTML = '';
        
        const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        currentMonthElement.innerText = `${monthNames[month]} ${year}`;
        
        // Add day headers
        const daysOfWeek = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        daysOfWeek.forEach(day => {
            const dayElement = document.createElement('div');
            dayElement.className = 'text-center font-semibold p-2 bg-gray-100';
            dayElement.style.fontSize = '15px';
            dayElement.innerText = day;
            calendarElement.appendChild(dayElement);
        });

        // Add empty cells for days before the first day of the month
        const firstDayOfWeek = firstDayOfMonth.getDay();
        for (let i = 0; i < firstDayOfWeek; i++) {
            const emptyDayElement = document.createElement('div');
            emptyDayElement.className = 'p-2';
            calendarElement.appendChild(emptyDayElement);
        }

        // Add calendar days
        for (let day = 1; day <= daysInMonth; day++) {
            const dayElement = document.createElement('div');
            dayElement.className = 'text-center p-2 hover:bg-gray-200 cursor-pointer transition-colors duration-200 border border-gray-100';
            dayElement.style.fontSize = '13px';
            
            // Create inner div for better styling
            const innerDiv = document.createElement('div');
            innerDiv.className = 'w-full h-full rounded-md p-2';
            innerDiv.innerText = day;
            
            // Check if it's current date
            const currentDate = new Date();
            if (year === currentDate.getFullYear() && month === currentDate.getMonth() && day === currentDate.getDate()) {
                innerDiv.classList.add('bg-blue-500', 'text-white');
            }

            // Check if date is booked
            if (bookedDates && bookedDates.length > 0) {
                bookedDates.forEach(bookedDate => {
                    if (day >= bookedDate.start && day <= bookedDate.end) {
                        innerDiv.classList.add('bg-red-500', 'text-white');
                    }
                });
            }

            dayElement.appendChild(innerDiv);

            // Add click event
            dayElement.addEventListener('click', () => {
                showModal(`${day} ${monthNames[month]} ${year}`);
                fetchBookingForDate(year, month, day);
            });

            calendarElement.appendChild(dayElement);
        }

        // Update calendar grid styling
        calendarElement.className = 'grid grid-cols-7 gap-1 p-2';
    }

    function showModal(selectedDate) {
        const modal = document.getElementById('myModal');
        const modalDateElement = document.getElementById('modalDate');
        modalDateElement.innerText = selectedDate;
        modal.classList.remove('hidden');
    }
    
        document.getElementById('closeModal').addEventListener('click', () => {
            document.getElementById('myModal').classList.add('hidden');
        });
    
        // Initialize the calendar
    document.addEventListener('DOMContentLoaded', () => {
        let currentDate = new Date();
        let currentYear = currentDate.getFullYear();
        let currentMonth = currentDate.getMonth();
        
        // Initial load
        fetchBookingDates(currentYear, currentMonth);

        // Set up navigation buttons
        document.getElementById('prevMonth').addEventListener('click', () => {
            if (currentMonth === 0) {
                currentMonth = 11;
                currentYear--;
            } else {
                currentMonth--;
            }
            fetchBookingDates(currentYear, currentMonth);
        });

        document.getElementById('nextMonth').addEventListener('click', () => {
            if (currentMonth === 11) {
                currentMonth = 0;
                currentYear++;
            } else {
                currentMonth++;
            }
            fetchBookingDates(currentYear, currentMonth);
        });
    });
          
    </script>