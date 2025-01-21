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
        <h1 class="font-sans text-2xl font-semibold p-4 text-center">Dashboard</h1>
  
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
                                            <th class="p-2 text-left text-white border-r border-white">Ruang</th>
                                            <th class="p-2 text-left text-white border-r border-white">Kluster</th>
                                            <th class="p-2 text-left text-white">Gedung</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-300">
                                        <tr>
                                            <td class="py-1 px-2 border-r border-gray-300">101</td>
                                            <td class="py-1 px-2 border-r border-gray-300">Sindoro</td>
                                            <td class="py-1 px-2 ">I</td>
                                        </tr>
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
    function generateCalendar(year, month) {
              const calendarElement = document.getElementById('calendar');
              const currentMonthElement = document.getElementById('currentMonth');
              
              const firstDayOfMonth = new Date(year, month, 1);
              const daysInMonth = new Date(year, month + 1, 0).getDate();
              
              calendarElement.innerHTML = '';
              const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
              currentMonthElement.innerText = `${monthNames[month]} ${year}`;
              
              const firstDayOfWeek = firstDayOfMonth.getDay();
              const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
              daysOfWeek.forEach(day => {
                  const dayElement = document.createElement('div');
                  dayElement.className = 'text-center font-semibold';
                  dayElement.style.fontSize = '15px';
                  dayElement.innerText = day;
                  calendarElement.appendChild(dayElement);
              });
    
              for (let i = 0; i < firstDayOfWeek; i++) {
                  const emptyDayElement = document.createElement('div');
                  calendarElement.appendChild(emptyDayElement);
              }
    
              for (let day = 1; day <= daysInMonth; day++) {
                  const dayElement = document.createElement('div');
                  dayElement.className = 'text-center text-gray-700 py-2 hover:bg-gray-400 hover:text-white font-semibold cursor-pointer rounded-md';
                  dayElement.style.fontSize = '13px';
                  dayElement.innerText = day;
    
                  const currentDate = new Date();
                  if (year === currentDate.getFullYear() && month === currentDate.getMonth() && day === currentDate.getDate()) {
                      dayElement.classList.add('bg-blue-400', 'text-white', 'hover:bg-blue-600');
                  }
    
                  dayElement.addEventListener('click', () => showModal(`${day} ${monthNames[month]}, ${year}`));
    
                  calendarElement.appendChild(dayElement);
              }
          }
    
          const currentDate = new Date();
          let currentYear = currentDate.getFullYear();
          let currentMonth = currentDate.getMonth();
          generateCalendar(currentYear, currentMonth);
    
          document.getElementById('prevMonth').addEventListener('click', () => {
              currentMonth--;
              if (currentMonth < 0) {
                  currentMonth = 11;
                  currentYear--;
              }
              generateCalendar(currentYear, currentMonth);
          });
    
          document.getElementById('nextMonth').addEventListener('click', () => {
              currentMonth++;
              if (currentMonth > 11) {
                  currentMonth = 0;
                  currentYear++;
              }
              generateCalendar(currentYear, currentMonth);
          });
    
          function showModal(selectedDate) {
              const modal = document.getElementById('myModal');
              const modalDateElement = document.getElementById('modalDate');
              modalDateElement.innerText = selectedDate;
              modal.classList.remove('hidden');
          }
    
          document.getElementById('closeModal').addEventListener('click', () => {
              document.getElementById('myModal').classList.add('hidden');
          });
    
    
      if(document.getElementById("column-chart") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("column-chart"), options);
        chart.render();
      }
    
    </script>