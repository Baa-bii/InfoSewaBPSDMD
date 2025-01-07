@vite(['resources/css/app.css','resources/js/app.js'])
<link rel="stylesheet" href="https://rsms.me/inter/inter.css">

<!-- Sidebar -->
<aside
    class="fixed top-0 left-0 z-40 w-44 h-screen pt-14 mt-3 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
    aria-label="Sidenav"
    id="drawer-navigation"
>

    <div class="overflow-y-auto px-3 h-full">
        <ul class="">
            @if (auth()->user()->role === 'admin')
                <!--Dashboard Admin-->
                <li class="hover:bg-gray-900 rounded-xl">
                    <a href="{{ route('admin.dashboard.index') }}" 
                    class="flex items-center text-base py-6 font-medium rounded-lg ml-3">
                    <svg
                            aria-hidden="true"
                            class="w-6 h-6 transition duration-75 group-hover:text-gray-900 dark:group-hover:text-white
                            {{ Request::is('dosen/home') ? 'text-black' : 'text-gray-500 dark:text-gray-400' }}"
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
                        <span class="ml-3 mt-1 text-white hover:text-gray-400">Dashboard</span>
                    </a>
                </li>

                <!--Create Ruang Admin-->
                <li class="hover:bg-gray-900 rounded-xl">
                    <a href="#" 
                    class="flex items-center text-base py-6 font-medium rounded-lg ml-3">
                    <svg
                            aria-hidden="true"
                            class="w-6 h-6 transition duration-75 group-hover:text-gray-900 dark:group-hover:text-white
                            {{ Request::is('dosen/home') ? 'text-black' : 'text-gray-500 dark:text-gray-400' }}"
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
                        <span class="ml-3 mt-1 text-white">Ruang</span>
                    </a>
                </li>
            
            @elseif (auth()->user()->role->role ==='sup-admin')
            @endif
        </ul>
    </div>
</aside>