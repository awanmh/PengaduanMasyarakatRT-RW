<nav x-data="{ open: false }" class="bg-blue-900 border-b border-yellow-400 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            <!-- Logo dan Nama Aplikasi -->
            <div class="flex items-center">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                <img src="{{ asset('img/icon.png') }}" 
                    alt="RT-RW Logo" 
                    class="h-9 w-9 rounded-full shadow-md border-2 border-yellow-400">
                <span class="text-lg font-bold text-white tracking-wide">
                    RT-RW Pengaduan
                </span>
            </a>
        </div>


            <!-- Tautan Navigasi (Desktop) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-6">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                    class="text-yellow-200 hover:text-white font-medium">
                    Dashboard
                </x-nav-link>
                <x-nav-link :href="route('pengaduan.index')" :active="request()->routeIs('pengaduan.*')" 
                    class="text-yellow-200 hover:text-white font-medium">
                    Pengaduan
                </x-nav-link>
                @if(Auth::user()->role === 'RT')
                <x-nav-link :href="route('kategori.index')" :active="request()->routeIs('kategori.*')" 
                    class="text-yellow-200 hover:text-white font-medium">
                    Kategori
                </x-nav-link>
                @endif
            </div>

            <!-- User Menu -->
            <div class="flex items-center ms-6 space-x-4">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-semibold text-yellow-200 hover:text-white transition">
                            <svg class="h-6 w-6 mr-1 text-yellow-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 
                                      11-6 0 3 3 0 016 0zm6 8a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="ml-1 h-4 w-4 text-yellow-200" xmlns="http://www.w3.org/2000/svg" 
                                 viewBox="0 0 20 20">
                                <path fill-rule="evenodd" 
                                      d="M5.293 7.293a1 1 0 011.414 0L10 
                                         10.586l3.293-3.293a1 1 0 
                                         111.414 1.414l-4 4a1 1 0 
                                         01-1.414 0l-4-4a1 1 0 
                                         010-1.414z" 
                                      clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" 
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>
