@vite(['resources/css/app.css','resources/js/app.js'])
<link rel="stylesheet" href="https://rsms.me/inter/inter.css">

<nav class="bg-gray-800 w-screen fixed left-0 right-0 top-0 z-50">
    <div class="flex items-center justify-between px-4 h-16">
        <!-- Title -->
        <div class="text-sans text-xl text-white font-bold p-6">
            INFO SEWA ASRAMA
        </div>
        <!-- Logo -->
        <a href="#" class="flex items-center">
            <img src="/assets/bpsdmd1.png" class=" w-36" alt="logo1">
        </a>
        <div class="relative inline-block text-left">
            <button
                type="button"
                class="flex items-center px-3 py-1 text-sm bg-gray-800 rounded-full"
                id="user-menu-button"
                aria-expanded="false"
            >
                <!-- Nama dan Foto User -->
                @if($user)
                    <span class="hidden md:block self-center text-sm font-medium whitespace-nowrap dark:text-white bg-blue-400 text-black px-3 py-2 rounded-lg mr-4 hover:bg-blue-500">
                        <b>{{ $user->name }}</b>
                    </span>
                @else
                    <span class="hidden md:block self-center text-sm font-light whitespace-nowrap dark:text-white bg-yellow-400 text-black px-2 py-1 rounded-lg">
                        <b>Guest</b>
                    </span>
                @endif
            </button>

            <!-- Dropdown Menu -->
            <div
                id="dropdown"
                class="hidden absolute right-0 z-50 mt-2 w-56 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-gray-700 dark:divide-gray-600"
            >
                <!-- Nama dan Foto User (Visible on Small Screens) -->
                <div class="md:hidden px-4 py-2 flex items-center">
                    <span class="text-gray-900 dark:text-white text-sm font-normal">
                        {{ $user ? $user->name : 'Guest' }}
                    </span>
                </div>
                <div class="py-1">
                    <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-white hover:bg-gray-600 ">Log out</a>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const userMenuButton = document.getElementById('user-menu-button');
        const dropdownMenu = document.getElementById('dropdown');

        if (userMenuButton && dropdownMenu) {
            userMenuButton.addEventListener('click', function () {
                dropdownMenu.classList.toggle('hidden');
            });

            document.addEventListener('click', function (event) {
                const isClickInside = userMenuButton.contains(event.target) || dropdownMenu.contains(event.target);
                if (!isClickInside) {
                    dropdownMenu.classList.add('hidden');
                }
            });
        }
    });
</script>
