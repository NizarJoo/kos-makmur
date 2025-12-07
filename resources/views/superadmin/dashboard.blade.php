<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard Superadmin
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Welcome Header -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    Selamat Datang, {{ Auth::user()->name }}!
                </h3>
                <p class="mt-1 text-gray-600 dark:text-gray-400">
                    Ini adalah pusat kendali untuk mengelola seluruh sistem.
                </p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Pengguna -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm flex items-center space-x-4">
                    <div class="bg-blue-100 dark:bg-blue-900/50 p-3 rounded-full">
                        <svg class="w-7 h-7 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m-7.5-2.964A3 3 0 0012 12.75a3 3 0 00-3.75 2.964m6.406 2.080a9.075 9.075 0 01-6.406 0m4.682-4.846a3 3 0 00-4.682 0m7.5 0a3 3 0 00-4.682 0M12 12.75a3 3 0 00-3.75 2.964m0 0A3 3 0 006 12.75m-3.75 2.964A3 3 0 016 12.75m0 0a3 3 0 013.75 2.964m0 0a3 3 0 013.75 2.964m0 0a3 3 0 013.75 2.964m0 0A3 3 0 0018 12.75a3 3 0 00-3.75 2.964m-4.5 0a3 3 0 00-4.5 0" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pengguna</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['totalUsers'] }}</p>
                    </div>
                </div>
                <!-- Total Admin -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm flex items-center space-x-4">
                    <div class="bg-blue-100 dark:bg-blue-900/50 p-3 rounded-full">
                        <svg class="w-7 h-7 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.286zm0 13.036h.008v.008h-.008v-.008z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Admin</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['totalAdmins'] }}</p>
                    </div>
                </div>
                <!-- Total Kost -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm flex items-center space-x-4">
                    <div class="bg-blue-100 dark:bg-blue-900/50 p-3 rounded-full">
                        <svg class="w-7 h-7 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h18M3 21h18" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Kost</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['totalBoardingHouses'] }}</p>
                    </div>
                </div>
                <!-- Verifikasi Tertunda -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm flex items-center space-x-4">
                    <div class="bg-blue-100 dark:bg-blue-900/50 p-3 rounded-full">
                        <svg class="w-7 h-7 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Verifikasi Tertunda</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['pendingVerifications'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Left Column: Aksi Cepat -->
                <div>
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6 h-full">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Aksi Cepat</h3>
                        <div class="space-y-4">
                            <a href="{{ route('verification.index') }}" class="flex items-center justify-between p-4 rounded-lg bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 transition-colors">
                                <span class="font-semibold text-gray-900 dark:text-gray-100">Verifikasi Kost</span>
                                <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </a>
                            <a href="{{ route('districts.index') }}" class="flex items-center justify-between p-4 rounded-lg bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 transition-colors">
                                <span class="font-semibold text-gray-900 dark:text-gray-100">Kelola Kecamatan</span>
                                <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.32-1.623-.886l-4.875 2.437a1.5 1.5 0 01-1.5 0L6.23 3.934a1.5 1.5 0 00-1.623.886v8.434c0 .426.242.816.622 1.006l4.875 2.437a1.5 1.5 0 001.5 0z" /></svg>
                            </a>
                             <a href="{{ route('facilities.index') }}" class="flex items-center justify-between p-4 rounded-lg bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 transition-colors">
                                <span class="font-semibold text-gray-900 dark:text-gray-100">Kelola Fasilitas</span>
                                <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                            </a>
                            <a href="{{ route('superadmin.approvals') }}" class="flex items-center justify-between p-4 rounded-lg bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 transition-colors">
                                <span class="font-semibold text-gray-900 dark:text-gray-100">Persetujuan Admin</span>
                                <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Pengguna Terbaru -->
                <div>
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6 h-full flex flex-col">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Pengguna Terbaru</h3>
                        <div class="flow-root flex-grow">
                            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($recentUsers as $user)
                                    <li class="py-3 sm:py-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0">
                                                <img class="w-8 h-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=7F9CF5&background=EBF4FF" alt="User Avatar">
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-100">
                                                    {{ $user->name }}
                                                </p>
                                                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                    {{ $user->email }}
                                                </p>
                                            </div>
                                            <div class="inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                                {{ $user->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                    <li class="py-3 sm:py-4 text-center text-gray-500 dark:text-gray-400">
                                        Tidak ada pengguna baru.
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>