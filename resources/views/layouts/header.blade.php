<header 
    class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 fixed top-0 left-0 right-0 z-50"
    x-data="{ open: false, darkMode: localStorage.getItem('dark') === 'true' }"
    x-init="
        document.documentElement.classList.toggle('dark', darkMode);
        $watch('darkMode', val => { 
            localStorage.setItem('dark', val); 
            document.documentElement.classList.toggle('dark', val); 
        })
    "
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Judul -->
            <div class="flex items-center">
                <h1 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                    Dashboard Admin Absensi
                </h1>
            </div>

            <!-- Bagian kanan: Dark Mode + Profil -->
            <div class="flex items-center space-x-6">
                <!-- Tombol toggle dark mode -->
                <button @click="darkMode = !darkMode" 
                    class="p-2 rounded-full bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                    <!-- Icon Sun -->
                    <svg x-show="!darkMode" xmlns="http://www.w3.org/2000/svg" 
                        class="h-5 w-5 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m8.66-13.66l-.71.71M4.05 19.95l-.71-.71M21 12h-1M4 12H3m16.66 7.66l-.71-.71M4.05 4.05l-.71.71M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <!-- Icon Moon -->
                    <svg x-show="darkMode" xmlns="http://www.w3.org/2000/svg" 
                        class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M21.752 15.002A9 9 0 1112.998 3.25a7 7 0 108.754 11.752z" />
                    </svg>
                </button>

                <!-- Profil dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" 
                        class="flex items-center space-x-2 focus:outline-none cursor-pointer">
                        <span class="text-sm text-gray-500 dark:text-gray-200">
                            {{ auth()->user()->name }}
                        </span>
                        <div class="flex items-center">
                            <div class="h-8 w-8 bg-blue-500 rounded-full flex items-center justify-center mr-1">
                                <span class="text-white text-sm font-medium">
                                    @php
                                        $nameParts = explode(' ', auth()->user()->name);
                                        $initials = strtoupper(substr($nameParts[0], 0, 1));
                                        if (isset($nameParts[1])) {
                                            $initials .= strtoupper(substr($nameParts[1], 0, 1));
                                        }
                                        echo $initials;
                                    @endphp
                                </span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 text-gray-500 dark:text-gray-300 transition-transform duration-200"
                                :class="{ 'transform rotate-180': open }" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>

                    <!-- Dropdown menu -->
                    <div x-show="open" @click.away="open = false"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white dark:bg-gray-800 
                               ring-1 ring-gray-200 dark:ring-gray-700 focus:outline-none z-50">
                        <div class="py-1" role="none">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 
                                           hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
