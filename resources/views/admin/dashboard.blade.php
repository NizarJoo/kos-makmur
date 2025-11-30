<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-gradient-to-br from-gold-500 to-yellow-300 rounded-lg shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
            </div>
            <div>
                <h2 class="font-serif text-2xl font-bold text-luxury-800 dark:text-gold-300">
                    Dashboard {{ ucfirst(Auth::user()->role) }}
                </h2>
                <p class="text-sm text-luxury-600 dark:text-gold-400 mt-1">Ringkasan performa hari ini</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Stats Grid dengan efek hover -->
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                <!-- Pemesanan Aktif -->
                <div
                    class="bg-gradient-to-br from-white/95 to-white/50 dark:from-gray-800/90 dark:to-gray-900/50 overflow-hidden shadow-luxury gold-border rounded-xl bg-blur p-6 transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-luxury-600 dark:text-gold-400">Pemesanan Aktif</p>
                            <p class="text-2xl font-bold text-luxury-900 dark:text-gold-300">
                                {{ $stats['activeBookings'] }}
                            </p>
                            <p class="text-sm text-luxury-500 dark:text-gold-500/70">{{ $stats['checkoutsToday'] }}
                                checkout hari ini</p>
                        </div>
                        <div
                            class="p-3 bg-gradient-to-br from-blue-100 to-white dark:from-blue-900/20 dark:to-gray-800/20 rounded-full">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3 w-full bg-luxury-200 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full"
                            style="width: {{ min($stats['activeBookings'] * 10, 100) }}%"></div>
                    </div>
                </div>

                <!-- Kamar Tersedia -->
                <div
                    class="bg-gradient-to-br from-white/95 to-white/50 dark:from-gray-800/90 dark:to-gray-900/50 overflow-hidden shadow-luxury gold-border rounded-xl bg-blur p-6 transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-luxury-600 dark:text-gold-400">Kamar Tersedia</p>
                            <p class="text-2xl font-bold text-luxury-900 dark:text-gold-300">
                                {{ $stats['availableRooms'] }}
                            </p>
                            <p class="text-sm text-luxury-500 dark:text-gold-500/70">{{ $stats['occupancyRate'] }}%
                                Kamar telah ditempati</p>
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
                    <div class="mt-3 w-full bg-luxury-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ $stats['occupancyRate'] }}%"></div>
                    </div>
                </div>

                <!-- Total Tamu -->
                <div
                    class="bg-gradient-to-br from-white/95 to-white/50 dark:from-gray-800/90 dark:to-gray-900/50 overflow-hidden shadow-luxury gold-border rounded-xl bg-blur p-6 transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-luxury-600 dark:text-gold-400">Total Tamu</p>
                            <p class="text-2xl font-bold text-luxury-900 dark:text-gold-300">{{ $stats['totalGuests'] }}
                            </p>
                            <p class="text-sm text-luxury-500 dark:text-gold-500/70">{{ $stats['newGuestsThisMonth'] }}
                                baru bulan ini</p>
                        </div>
                        <div
                            class="p-3 bg-gradient-to-br from-purple-100 to-white dark:from-purple-900/20 dark:to-gray-800/20 rounded-full">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Pendapatan Bulanan -->
                <div
                    class="bg-gradient-to-br from-white/95 to-white/50 dark:from-gray-800/90 dark:to-gray-900/50 overflow-hidden shadow-luxury gold-border rounded-xl bg-blur p-6 transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-luxury-600 dark:text-gold-400">Pendapatan Bulanan</p>
                            <p class="text-2xl font-bold text-luxury-900 dark:text-gold-300">
                                Rp{{ number_format($stats['monthlyRevenue'], 0, ',', '.') }}</p>
                            <p class="text-sm text-luxury-500 dark:text-gold-500/70">{{ $stats['revenueGrowth'] }}%
                                lebih banyak dari
                                bulan lalu</p>
                        </div>
                        <div
                            class="p-3 bg-gradient-to-br from-yellow-100 to-white dark:from-yellow-900/20 dark:to-gray-800/20 rounded-full">
                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div
                        class="mt-3 flex items-center text-sm {{ $stats['revenueGrowth'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="{{ $stats['revenueGrowth'] >= 0 ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}" />
                        </svg>
                        {{ abs($stats['revenueGrowth']) }}% dari bulan lalu
                    </div>
                </div>
            </div>

            <!-- Ringkasan Status Kamar dengan layout baru -->
            <div class="grid gap-6 lg:grid-cols-2">
                <!-- Ringkasan Status Kamar -->
                <div
                    class="bg-gradient-to-br from-white/95 to-white/50 dark:from-gray-800/90 dark:to-gray-900/50 overflow-hidden shadow-luxury gold-border rounded-xl bg-blur">
                    <div class="p-6">
                        <h3
                            class="text-lg font-serif font-semibold text-luxury-800 dark:text-gold-300 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-luxury-600 dark:text-gold-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Ringkasan Status Kamar
                        </h3>
                        <div class="space-y-4">
                            <!-- Available -->
                            <div
                                class="flex items-center justify-between p-4 bg-gradient-to-br from-green-50/50 to-white/30 dark:from-green-900/20 dark:to-gray-800/30 rounded-lg border border-green-200/20 dark:border-green-500/10">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                                    <div>
                                        <p class="text-sm font-medium text-green-700 dark:text-green-400">Tersedia</p>
                                        <p class="text-2xl font-bold text-green-600 dark:text-green-300">
                                            {{ $stats['availableRooms'] }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-sm text-green-600 dark:text-green-400">
                                    {{ round(($stats['availableRooms'] / ($stats['availableRooms'] + $stats['occupiedRooms'] + $stats['maintenanceRooms'])) * 100) }}%
                                </div>
                            </div>

                            <!-- Occupied -->
                            <div
                                class="flex items-center justify-between p-4 bg-gradient-to-br from-blue-50/50 to-white/30 dark:from-blue-900/20 dark:to-gray-800/30 rounded-lg border border-blue-200/20 dark:border-blue-500/10">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                                    <div>
                                        <p class="text-sm font-medium text-blue-700 dark:text-blue-400">Terisi</p>
                                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-300">
                                            {{ $stats['occupiedRooms'] }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-sm text-blue-600 dark:text-blue-400">
                                    {{ round(($stats['occupiedRooms'] / ($stats['availableRooms'] + $stats['occupiedRooms'] + $stats['maintenanceRooms'])) * 100) }}%
                                </div>
                            </div>

                            <!-- Maintenance -->
                            <div
                                class="flex items-center justify-between p-4 bg-gradient-to-br from-amber-50/50 to-white/30 dark:from-amber-900/20 dark:to-gray-800/30 rounded-lg border border-amber-200/20 dark:border-amber-500/10">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-amber-500 rounded-full mr-3"></div>
                                    <div>
                                        <p class="text-sm font-medium text-amber-700 dark:text-amber-400">Pemeliharaan
                                        </p>
                                        <p class="text-2xl font-bold text-amber-600 dark:text-amber-300">
                                            {{ $stats['maintenanceRooms'] }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-sm text-amber-600 dark:text-amber-400">
                                    {{ round(($stats['maintenanceRooms'] / ($stats['availableRooms'] + $stats['occupiedRooms'] + $stats['maintenanceRooms'])) * 100) }}%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aksi Cepat dengan layout vertikal -->
                <div
                    class="bg-gradient-to-br from-white/95 to-white/50 dark:from-gray-800/90 dark:to-gray-900/50 overflow-hidden shadow-luxury gold-border rounded-xl bg-blur">
                    <div class="p-6">
                        <h3
                            class="text-lg font-serif font-semibold text-luxury-800 dark:text-gold-300 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-luxury-600 dark:text-gold-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Aksi Cepat
                        </h3>
                        <div class="space-y-3">
                            <a href="{{ route('rooms.create') }}"
                                class="flex items-center p-4 bg-gradient-to-br from-luxury-50/50 to-white/30 dark:from-gray-800/50 dark:to-gray-900/30 rounded-lg border border-luxury-200/20 dark:border-gold-500/10 hover:bg-luxury-100/50 dark:hover:bg-gold-900/20 transition-all duration-300 transform hover:translate-x-2 group">
                                <div
                                    class="p-3 bg-gradient-to-br from-green-100 to-white dark:from-green-900/20 dark:to-gray-800/20 rounded-full mr-4 group-hover:from-green-200 dark:group-hover:from-green-800/30">
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                </div>
                                <div>
                                    <span
                                        class="text-luxury-800 dark:text-gold-300 group-hover:text-luxury-900 dark:group-hover:text-gold-200 font-medium">Tambah
                                        Kamar Baru</span>
                                    <p class="text-sm text-luxury-600 dark:text-gold-400">Buat kamar baru untuk
                                        disewakan</p>
                                </div>
                            </a>

                            <a href="{{ route('bookings.create') }}"
                                class="flex items-center p-4 bg-gradient-to-br from-luxury-50/50 to-white/30 dark:from-gray-800/50 dark:to-gray-900/30 rounded-lg border border-luxury-200/20 dark:border-gold-500/10 hover:bg-luxury-100/50 dark:hover:bg-gold-900/20 transition-all duration-300 transform hover:translate-x-2 group">
                                <div
                                    class="p-3 bg-gradient-to-br from-blue-100 to-white dark:from-blue-900/20 dark:to-gray-800/20 rounded-full mr-4 group-hover:from-blue-200 dark:group-hover:from-blue-800/30">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <div>
                                    <span
                                        class="text-luxury-800 dark:text-gold-300 group-hover:text-luxury-900 dark:group-hover:text-gold-200 font-medium">Pemesanan
                                        Baru</span>
                                    <p class="text-sm text-luxury-600 dark:text-gold-400">Buat pemesanan untuk tamu</p>
                                </div>
                            </a>

                            <a href="{{ route('guests.create') }}"
                                class="flex items-center p-4 bg-gradient-to-br from-luxury-50/50 to-white/30 dark:from-gray-800/50 dark:to-gray-900/30 rounded-lg border border-luxury-200/20 dark:border-gold-500/10 hover:bg-luxury-100/50 dark:hover:bg-gold-900/20 transition-all duration-300 transform hover:translate-x-2 group">
                                <div
                                    class="p-3 bg-gradient-to-br from-purple-100 to-white dark:from-purple-900/20 dark:to-gray-800/20 rounded-full mr-4 group-hover:from-purple-200 dark:group-hover:from-purple-800/30">
                                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                    </svg>
                                </div>
                                <div>
                                    <span
                                        class="text-luxury-800 dark:text-gold-300 group-hover:text-luxury-900 dark:group-hover:text-gold-200 font-medium">Daftarkan
                                        Tamu</span>
                                    <p class="text-sm text-luxury-600 dark:text-gold-400">Tambah data tamu baru</p>
                                </div>
                            </a>

                            <a href="{{ route('rooms.index') }}"
                                class="flex items-center p-4 bg-gradient-to-br from-luxury-50/50 to-white/30 dark:from-gray-800/50 dark:to-gray-900/30 rounded-lg border border-luxury-200/20 dark:border-gold-500/10 hover:bg-luxury-100/50 dark:hover:bg-gold-900/20 transition-all duration-300 transform hover:translate-x-2 group">
                                <div
                                    class="p-3 bg-gradient-to-br from-orange-100 to-white dark:from-orange-900/20 dark:to-gray-800/20 rounded-full mr-4 group-hover:from-orange-200 dark:group-hover:from-orange-800/30">
                                    <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                    </svg>
                                </div>
                                <div>
                                    <span
                                        class="text-luxury-800 dark:text-gold-300 group-hover:text-luxury-900 dark:group-hover:text-gold-200 font-medium">Lihat
                                        Semua Kamar</span>
                                    <p class="text-sm text-luxury-600 dark:text-gold-400">Kelola daftar kamar</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>