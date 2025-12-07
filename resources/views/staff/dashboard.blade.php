<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard Admin
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
                    Kelola properti kos Anda dengan mudah dari sini.
                </p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm flex items-center space-x-4">
                    <div class="bg-blue-100 dark:bg-blue-900/50 p-3 rounded-full">
                        <svg class="w-7 h-7 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Booking Tertunda</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['pendingBookings'] }}
                        </p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm flex items-center space-x-4">
                    <div class="bg-blue-100 dark:bg-blue-900/50 p-3 rounded-full">
                        <svg class="w-7 h-7 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Booking Aktif</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['activeBookings'] }}
                        </p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm flex items-center space-x-4">
                    <div class="bg-blue-100 dark:bg-blue-900/50 p-3 rounded-full">
                        <svg class="w-7 h-7 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tingkat Hunian</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['occupancyRate'] }}%
                        </p>
                    </div>
                </div>
                <!-- Pendapatan Bulanan -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm flex items-center space-x-4">
                    <div class="bg-blue-100 dark:bg-blue-900/50 p-3 rounded-full">
                        <svg class="w-7 h-7 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pendapatan Bulanan</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">Rp
                            {{ number_format($stats['monthlyRevenue'], 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Left Column: Booking Tertunda -->
                <div>
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6 h-full flex flex-col">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Booking Tertunda Terbaru
                        </h3>
                        <div class="flow-root flex-grow">
                            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($pendingBookings as $booking)
                                    <li class="py-3 sm:py-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0">
                                                <img class="w-8 h-8 rounded-full"
                                                    src="https://ui-avatars.com/api/?name={{ urlencode($booking->user->name) }}&color=0D9488&background=CCFBF1"
                                                    alt="User Avatar">
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-100">
                                                    {{ $booking->user->name }}
                                                </p>
                                                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                    {{ $booking->room->boardingHouse->name }} -
                                                    {{ $booking->room->type_name }}
                                                </p>
                                            </div>
                                            <div class="hidden md:flex flex-col items-end text-sm">
                                                <p class="font-semibold text-gray-800 dark:text-gray-200">
                                                    {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}
                                                </p>
                                                <p class="text-gray-500 dark:text-gray-400">{{ $booking->duration_months }}
                                                    bulan</p>
                                            </div>
                                            <a href="{{ route('staff.bookings.index') }}"
                                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm bg-blue-600 text-white hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
                                                Lihat
                                            </a>
                                        </div>
                                    </li>
                                @empty
                                    <li class="py-3 sm:py-4 text-center text-gray-500 dark:text-gray-400">
                                        Tidak ada booking tertunda.
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Menu Utama -->
                <div>
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6 h-full">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Menu Utama</h3>
                        <div class="space-y-4">
                            <a href="{{ route('boarding-houses.index') }}"
                                class="flex items-center justify-between p-4 rounded-lg bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 transition-colors">
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">Kelola Kos Saya</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Ubah detail, kamar, dan
                                        fasilitas.</p>
                                </div>
                                <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h18M3 21h18" />
                                </svg>
                            </a>
                            <a href="{{ route('staff.bookings.index') }}"
                                class="flex items-center justify-between p-4 rounded-lg bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 transition-colors">
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">Kelola Booking</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Setujui atau tolak permintaan
                                        booking.</p>
                                </div>
                                <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </a>
                            <a href="{{ route('staff.bookings.create') }}"
                                class="flex items-center justify-between p-4 rounded-lg bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 transition-colors">
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">Buat Booking Baru</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Tambahkan booking secara manual.
                                    </p>
                                </div>
                                <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </a>
                            <a href="{{ route('guests.create') }}"
                                class="flex items-center justify-between p-4 rounded-lg bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 transition-colors">
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">Daftarkan Tamu Baru</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Masukkan data tamu baru ke
                                        sistem.</p>
                                </div>
                                <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>