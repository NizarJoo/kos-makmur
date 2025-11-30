<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-gradient-to-br from-purple-500 to-indigo-300 rounded-lg shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <div>
                <h2 class="font-serif text-2xl font-bold text-luxury-800 dark:text-gold-300">
                    Dashboard Superadmin
                </h2>
                <p class="text-sm text-luxury-600 dark:text-gold-400 mt-1">Kontrol penuh sistem</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Grid untuk Superadmin -->
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4 mb-8">
                <!-- Kos Menunggu Verifikasi -->
                <div
                    class="bg-gradient-to-br from-white/95 to-white/50 dark:from-gray-800/90 dark:to-gray-900/50 overflow-hidden shadow-luxury gold-border rounded-xl bg-blur p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-luxury-600 dark:text-gold-400">Kos Pending</p>
                            <p class="text-2xl font-bold text-luxury-900 dark:text-gold-300">
                                {{ $stats['pendingVerification'] }}
                            </p>
                            <p class="text-sm text-luxury-500 dark:text-gold-500/70">Menunggu verifikasi</p>
                        </div>
                        <div
                            class="p-3 bg-gradient-to-br from-yellow-100 to-white dark:from-yellow-900/20 dark:to-gray-800/20 rounded-full">
                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total User -->
                <div
                    class="bg-gradient-to-br from-white/95 to-white/50 dark:from-gray-800/90 dark:to-gray-900/50 overflow-hidden shadow-luxury gold-border rounded-xl bg-blur p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-luxury-600 dark:text-gold-400">Total User</p>
                            <p class="text-2xl font-bold text-luxury-900 dark:text-gold-300">
                                {{ $stats['totalUsers'] }}
                            </p>
                            <p class="text-sm text-luxury-500 dark:text-gold-500/70">Admin & Pengguna</p>
                        </div>
                        <div
                            class="p-3 bg-gradient-to-br from-blue-100 to-white dark:from-blue-900/20 dark:to-gray-800/20 rounded-full">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Kos -->
                <div
                    class="bg-gradient-to-br from-white/95 to-white/50 dark:from-gray-800/90 dark:to-gray-900/50 overflow-hidden shadow-luxury gold-border rounded-xl bg-blur p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-luxury-600 dark:text-gold-400">Total Kos</p>
                            <p class="text-2xl font-bold text-luxury-900 dark:text-gold-300">
                                {{ $stats['totalKos'] }}
                            </p>
                            <p class="text-sm text-luxury-500 dark:text-gold-500/70">Kos terdaftar</p>
                        </div>
                        <div
                            class="p-3 bg-gradient-to-br from-green-100 to-white dark:from-green-900/20 dark:to-gray-800/20 rounded-full">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Booking Aktif -->
                <div
                    class="bg-gradient-to-br from-white/95 to-white/50 dark:from-gray-800/90 dark:to-gray-900/50 overflow-hidden shadow-luxury gold-border rounded-xl bg-blur p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-luxury-600 dark:text-gold-400">Booking Aktif</p>
                            <p class="text-2xl font-bold text-luxury-900 dark:text-gold-300">
                                {{ $stats['activeBookings'] }}
                            </p>
                            <p class="text-sm text-luxury-500 dark:text-gold-500/70">Seluruh platform</p>
                        </div>
                        <div
                            class="p-3 bg-gradient-to-br from-purple-100 to-white dark:from-purple-900/20 dark:to-gray-800/20 rounded-full">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions untuk Superadmin -->
            <div class="grid gap-6 md:grid-cols-2">
                <!-- Master Data -->
                <div
                    class="bg-gradient-to-br from-white/95 to-white/50 dark:from-gray-800/90 dark:to-gray-900/50 overflow-hidden shadow-luxury gold-border rounded-xl bg-blur">
                    <div class="p-6">
                        <h3 class="text-lg font-serif font-semibold text-luxury-800 dark:text-gold-300 mb-4">
                            Master Data
                        </h3>
                        <div class="space-y-3">
                            <a href="{{ route('superadmin.districts.index') }}"
                                class="flex items-center p-4 bg-gradient-to-br from-luxury-50/50 to-white/30 dark:from-gray-800/50 dark:to-gray-900/30 rounded-lg border border-luxury-200/20 dark:border-gold-500/10 hover:bg-luxury-100/50 dark:hover:bg-gold-900/20 transition-all duration-300 group">
                                <div
                                    class="p-3 bg-gradient-to-br from-blue-100 to-white dark:from-blue-900/20 dark:to-gray-800/20 rounded-full mr-4">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                    </svg>
                                </div>
                                <span
                                    class="text-luxury-800 dark:text-gold-300 group-hover:text-luxury-900 dark:group-hover:text-gold-200 font-medium">
                                    Kelola Kecamatan
                                </span>
                            </a>

                            <a href="{{ route('superadmin.facilities.index') }}"
                                class="flex items-center p-4 bg-gradient-to-br from-luxury-50/50 to-white/30 dark:from-gray-800/50 dark:to-gray-900/30 rounded-lg border border-luxury-200/20 dark:border-gold-500/10 hover:bg-luxury-100/50 dark:hover:bg-gold-900/20 transition-all duration-300 group">
                                <div
                                    class="p-3 bg-gradient-to-br from-green-100 to-white dark:from-green-900/20 dark:to-gray-800/20 rounded-full mr-4">
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                </div>
                                <span
                                    class="text-luxury-800 dark:text-gold-300 group-hover:text-luxury-900 dark:group-hover:text-gold-200 font-medium">
                                    Kelola Fasilitas
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- System Info -->
                <div
                    class="bg-gradient-to-br from-white/95 to-white/50 dark:from-gray-800/90 dark:to-gray-900/50 overflow-hidden shadow-luxury gold-border rounded-xl bg-blur">
                    <div class="p-6">
                        <h3 class="text-lg font-serif font-semibold text-luxury-800 dark:text-gold-300 mb-4">
                            Informasi Sistem
                        </h3>
                        <div class="space-y-4 text-sm">
                            <div class="flex justify-between">
                                <span class="text-luxury-600 dark:text-gold-400">Versi Aplikasi:</span>
                                <span class="text-luxury-800 dark:text-gold-300">1.0.0</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-luxury-600 dark:text-gold-400">Laravel Version:</span>
                                <span class="text-luxury-800 dark:text-gold-300">{{ app()->version() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-luxury-600 dark:text-gold-400">PHP Version:</span>
                                <span class="text-luxury-800 dark:text-gold-300">{{ PHP_VERSION }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-luxury-600 dark:text-gold-400">Environment:</span>
                                <span class="text-luxury-800 dark:text-gold-300">{{ app()->environment() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>