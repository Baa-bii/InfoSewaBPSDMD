@vite(['resources/css/app.css','resources/js/app.js'])
<link rel="stylesheet" href="https://rsms.me/inter/inter.css">

        <!-- Sidebar -->
        <aside
                class="fixed top-0 left-0 z-40 w-56 h-screen pt-14 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
                aria-label="Sidenav"
                id="drawer-navigation"
            >
                <div class="overflow-y-auto px-3 h-full">
                    <ul class="space-y-2">
                    @if($user ->role=== 'admin')
                        <!-- Dashboard -->
                        <li class="hover:bg-gray-900 rounded-lg">
                            <a href="{{ route('admin.dashboard.index') }}"
                                class="flex items-center w-full text-base mt-4 px-4 py-4 font-medium rounded-lg text-gray-700 dark:text-white hover:text-white hover:bg-gray-900"
                            >
                                <svg
                                    class="w-6 h-6 text-gray-500 dark:text-gray-400 group-hover:text-gray-300"
                                    fill="currentColor"
                                    viewBox="0 0 36 36"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        class="clr-i-solid clr-i-solid-path-1"
                                        d="M33,19a1,1,0,0,1-.71-.29L18,4.41,3.71,18.71a1,1,0,0,1-1.41-1.41l15-15a1,1,0,0,1,1.41,0l15,15A1,1,0,0,1,33,19Z"
                                    ></path>
                                    <path
                                        class="clr-i-solid clr-i-solid-path-2"
                                        d="M18,7.79,6,19.83V32a2,2,0,0,0,2,2h7V24h6V34h7a2,2,0,0,0,2-2V19.76Z"
                                    ></path>
                                </svg>
                                <span class="ml-3">Dashboard</span>
                            </a>
                        </li>

                        <!-- Dropdown Ruang -->
                        <li class="relative">
                            <button
                                onclick="toggleDropdown('dropdown-ruang')"
                                class="flex items-center justify-between w-full text-base px-4 py-4 font-medium text-gray-700 dark:text-white hover:text-white hover:bg-gray-900 rounded-lg"
                            >
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                    class="w-6 h-6 text-gray-500 dark:text-gray-400 group-hover:text-gray-300" 
                                    viewBox="0 0 24 24"
                                    fill="currentColor">
                                        <path d="M5 5v14a1 1 0 0 0 1 1h3v-2H7V6h2V4H6a1 1 0 0 0-1 1zm14.242-.97-8-2A1 1 0 0 0 10 3v18a.998.998 0 0 0 1.242.97l8-2A1 1 0 0 0 20 19V5a1 1 0 0 0-.758-.97zM15 12.188a1.001 1.001 0 0 1-2 0v-.377a1 1 0 1 1 2 .001v.376z" />
                                    </svg>
                                    <span class="ml-3">Ruang</span>
                                </span>
                                <svg
                                    class="w-4 h-4 text-gray-500 dark:text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 9l-7 7-7-7"
                                    ></path>
                                </svg>
                            </button>
                            <ul
                                id="dropdown-ruang"
                                class="hidden mt-2 space-y-2 bg-gray-800 rounded-lg"
                            >
                                <li>
                                    <a
                                        href="{{ route('admin.data-ruang') }}"
                                        class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg"
                                    >
                                        Data Ruangan
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!--Booking-->
                        <li class="relative">
                            <button
                                onclick="toggleDropdown('dropdown-booking')"
                                class="flex items-center justify-between w-full text-base px-4 py-4 font-medium text-gray-700 dark:text-white hover:text-white hover:bg-gray-900 rounded-lg"
                            >
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                    class="w-6 h-6 text-gray-500 dark:text-gray-400 group-hover:text-gray-300" 
                                    viewBox="0 0 24 24"
                                    fill="currentColor">
                                        <path d="M6.012 18H21V4c0-1.103-.897-2-2-2H6c-1.206 0-3 .799-3 3v14c0 2.201 1.794 3 3 3h15v-2H6.012C5.55 19.988 5 19.806 5 19s.55-.988 1.012-1zM8 9h3V6h2v3h3v2h-3v3h-2v-3H8V9z">
                                            </path></svg>
                                    <span class="ml-3">Booking</span>
                                </span>
                                <svg
                                    class="w-4 h-4 text-gray-500 dark:text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 9l-7 7-7-7"
                                    ></path>
                                </svg>
                            </button>
                            <ul
                                id="dropdown-booking"
                                class="hidden mt-2 space-y-2 bg-gray-800 rounded-lg"
                            >
                                <li>
                                    <a
                                        href="{{ route('admin.booking-ruang') }}"
                                        class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg"
                                    >
                                        Booking Ruang
                                    </a>
                                </li>
                                <li>
                                    <a
                                        href="{{ route('admin.booking-data') }}"
                                        class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg"
                                    >
                                        Data Booking
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    @elseif ($user->role ==='sup-admin')
                    <!-- Dashboard -->
                    <li class="hover:bg-gray-900 rounded-lg">
                        <a href="{{ route('sup-admin.dashboard.index') }}"
                            class="flex items-center w-full text-base mt-4 px-4 py-4 font-medium rounded-lg text-gray-700 dark:text-white hover:text-white hover:bg-gray-900"
                        >
                            <svg
                                class="w-6 h-6 text-gray-500 dark:text-gray-400 group-hover:text-gray-300"
                                fill="currentColor"
                                viewBox="0 0 36 36"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    class="clr-i-solid clr-i-solid-path-1"
                                    d="M33,19a1,1,0,0,1-.71-.29L18,4.41,3.71,18.71a1,1,0,0,1-1.41-1.41l15-15a1,1,0,0,1,1.41,0l15,15A1,1,0,0,1,33,19Z"
                                ></path>
                                <path
                                    class="clr-i-solid clr-i-solid-path-2"
                                    d="M18,7.79,6,19.83V32a2,2,0,0,0,2,2h7V24h6V34h7a2,2,0,0,0,2-2V19.76Z"
                                ></path>
                            </svg>
                            <span class="ml-3">Dashboard</span>
                        </a>
                    </li>

                    <!-- Dropdown Ruang -->
                    <li class="relative">
                        <button
                            onclick="toggleDropdown('dropdown-ruang')"
                            class="flex items-center justify-between w-full text-base px-4 py-4 font-medium text-gray-700 dark:text-white hover:text-white hover:bg-gray-900 rounded-lg"
                        >
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" 
                                class="w-6 h-6 text-gray-500 dark:text-gray-400 group-hover:text-gray-300" 
                                viewBox="0 0 24 24"
                                fill="currentColor">
                                    <path d="M5 5v14a1 1 0 0 0 1 1h3v-2H7V6h2V4H6a1 1 0 0 0-1 1zm14.242-.97-8-2A1 1 0 0 0 10 3v18a.998.998 0 0 0 1.242.97l8-2A1 1 0 0 0 20 19V5a1 1 0 0 0-.758-.97zM15 12.188a1.001 1.001 0 0 1-2 0v-.377a1 1 0 1 1 2 .001v.376z" />
                                </svg>
                                <span class="ml-3">Ruang</span>
                            </span>
                            <svg
                                class="w-4 h-4 text-gray-500 dark:text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7"
                                ></path>
                            </svg>
                        </button>
                        <ul
                            id="dropdown-ruang"
                            class="hidden mt-2 space-y-2 bg-gray-800 rounded-lg"
                        >
                            <li>
                                <a
                                    href="{{ route('sup-admin.ruang.index') }}"
                                    class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg"
                                >
                                    Data Ruangan
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!--Booking-->
                    <li class="relative">
                        <button
                            onclick="toggleDropdown('dropdown-booking')"
                            class="flex items-center justify-between w-full text-base px-4 py-4 font-medium text-gray-700 dark:text-white hover:text-white hover:bg-gray-900 rounded-lg"
                        >
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" 
                                class="w-6 h-6 text-gray-500 dark:text-gray-400 group-hover:text-gray-300" 
                                viewBox="0 0 24 24"
                                fill="currentColor">
                                    <path d="M6.012 18H21V4c0-1.103-.897-2-2-2H6c-1.206 0-3 .799-3 3v14c0 2.201 1.794 3 3 3h15v-2H6.012C5.55 19.988 5 19.806 5 19s.55-.988 1.012-1zM8 9h3V6h2v3h3v2h-3v3h-2v-3H8V9z">
                                        </path></svg>
                                <span class="ml-3">Booking</span>
                            </span>
                            <svg
                                class="w-4 h-4 text-gray-500 dark:text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7"
                                ></path>
                            </svg>
                        </button>
                        <ul
                            id="dropdown-booking"
                            class="hidden mt-2 space-y-2 bg-gray-800 rounded-lg"
                        >
                            <li>
                                <a
                                    href="{{ route('sup-admin.booking-ruang') }}"
                                    class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg"
                                >
                                    Booking Ruang
                                </a>
                            </li>
                            <li>
                                <a
                                    href="{{ route('sup-admin.booking-data') }}"
                                    class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg"
                                >
                                    Data Booking
                                </a>
                            </li>
                            <li>
                                <a
                                    href="{{ route('sup-admin.booking-riwayat') }}"
                                    class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg"
                                >
                                    Riwayat Booking
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Data User -->
                    <li class="hover:bg-gray-900 rounded-lg">
                        <a href="{{ route('sup-admin.data-user') }}"
                            class="flex items-center w-full text-base mt-4 px-4 py-4 font-medium rounded-lg text-gray-700 dark:text-white hover:text-white hover:bg-gray-900"
                        >
                        <svg xmlns="http://www.w3.org/2000/svg" 
                        class="w-6 h-6 text-gray-500 dark:text-gray-400 group-hover:text-gray-300" 
                                viewBox="0 0 24 24"
                                fill="currentColor">
                            <path d="M9.5 12c2.206 0 4-1.794 4-4s-1.794-4-4-4-4 1.794-4 4 1.794 4 4 4zm1.5 1H8c-3.309 0-6 2.691-6 6v1h15v-1c0-3.309-2.691-6-6-6z">
                                </path><path d="M16.604 11.048a5.67 5.67 0 0 0 .751-3.44c-.179-1.784-1.175-3.361-2.803-4.44l-1.105 1.666c1.119.742 1.8 1.799 1.918 2.974a3.693 3.693 0 0 1-1.072 2.986l-1.192 1.192 1.618.475C18.951 13.701 19 17.957 19 18h2c0-1.789-.956-5.285-4.396-6.952z">
                            </path></svg>
                            <span class="ml-3">Data User</span>
                        </a>
                    </li>
                </ul>
                @endif
            </div>
        </aside>


<script>
    function toggleDropdown(id) {
    const dropdown = document.getElementById(id);
    const isHidden = dropdown.classList.toggle('hidden');

    // Save the state in localStorage
    localStorage.setItem(id, isHidden ? 'hidden' : 'visible');
}
document.addEventListener('DOMContentLoaded', () => {
    const dropdownIds = ['dropdown-ruang', 'dropdown-booking']; // Add all dropdown IDs here

    dropdownIds.forEach(id => {
        const state = localStorage.getItem(id);
        const dropdown = document.getElementById(id);

        if (dropdown) {
            if (state === 'visible') {
                dropdown.classList.remove('hidden');
            } else {
                dropdown.classList.add('hidden');
            }
        }
    });
});


</script>