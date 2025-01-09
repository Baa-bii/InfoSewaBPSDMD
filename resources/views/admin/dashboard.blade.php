<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
        <div class="shadow-lg">
            <h2 class="text-gray-700 font-sans font-semibold text-lg p-2 mb-4">Data Sewa Ruangan</h2>
            <table class="min-w-full bg-white border rounded-lg">
              <thead class="bg-gray-700 text-white">
                  <tr>
                      <th class="py-2 px-4 text-left">Nama Gedung</th>
                      <th class="py-2 px-4 text-left">Kluster</th>
                      <th class="py-2 px-4 text-left">Jumlah Ruang</th>
                      <th class="py-2 px-4 text-left">Jumlah Booking</th>
                  </tr>
              </thead>
              <tbody class="divide-y divide-gray-300">
                  <!-- Contoh Data 1 -->
                  <tr>
                      <td class="py-2 px-4">Sindoro</td>
                      <td class="py-2 px-4">Sindoro I</td>
                      <td class="py-2 px-4">10</td>
                      <td class="py-2 px-4">5</td>
                  </tr>
              </tbody>
          </table>
        </div>

      <div class="pt-2 mt-8 w-full h-screen">
          <div class="bg-white shadow-lg overflow-hidden">
              <div class="flex items-center justify-between px-4 py-3 bg-gray-700 rounded-t-lg">
                  <button id="prevMonth" class="text-white text-md hover:text-gray-300">Prev</button>
                  <h2 id="currentMonth" class="text-white font-medium text-md"></h2>
                  <button id="nextMonth" class="text-white text-md hover:text-gray-300">Next</button>
              </div>
              <div class="grid grid-cols-7 gap-1 p-1 " id="calendar">
                  <!-- Calendar Days Go Here -->
              </div>
          </div>
      
          <div id="myModal" class="modal hidden fixed inset-0 flex items-center justify-center z-50">
              <div class="modal-overlay absolute inset-0 bg-black opacity-50"></div>
              <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded-lg shadow-lg z-50 overflow-y-auto">
                  <div class="modal-content py-4 text-left px-6">
                      <div class="flex justify-between pb-3">
                          <p class="text-lg font-bold">Selected Date</p>
                          <p class="text-md font-semibold">Booking hari ini:</p>
                          <button id="closeModal" class="modal-close px-3 py-1 rounded-full bg-gray-200 hover:bg-gray-300">✕</button>
                      </div>
                      <div id="modalDate" class="text-lg font-semibold"></div>
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
          const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
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
                  dayElement.classList.add('bg-yellow-400', 'text-white', 'hover:bg-yellow-300');
              }

              dayElement.addEventListener('click', () => showModal(`${monthNames[month]} ${day}, ${year}`));

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