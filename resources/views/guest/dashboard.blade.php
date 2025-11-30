<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Selamat datang! Berikut adalah beberapa kos terbaru yang tersedia untuk Anda.") }}
                </div>
            </div>

            <div class="mt-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
                        Baru Ditambahkan
                    </h3>
                    <a href="{{ route('guest.boarding-houses.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-luxury-600 dark:bg-luxury-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-luxury-700 dark:hover:bg-luxury-600 transition ease-in-out duration-150">
                        Lihat Semua
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>

                @if ($boardingHouses->count() > 0)
                    {{-- Grid Layout --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($boardingHouses as $house)
                            <div
                                class="bg-white dark:bg-gray-700 rounded-lg shadow-md overflow-hidden border border-luxury-200 dark:border-luxury-700 hover:shadow-lg transition-shadow">
                                {{-- Image --}}
                                <div class="relative h-48 bg-luxury-100 dark:bg-luxury-900">
                                    @if ($house->image_path)
                                        <img src="{{ asset('storage/' . $house->image_path) }}" alt="{{ $house->name }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <div
                                            class="w-full h-full flex items-center justify-center text-luxury-400 dark:text-luxury-600">
                                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                {{-- Content --}}
                                <div class="p-4 flex flex-col">
                                    <h3 class="text-lg font-semibold text-luxury-800 dark:text-luxury-200 mb-2">
                                        {{ $house->name }}
                                    </h3>

                                    <div class="space-y-2 mb-4 flex-grow">
                                        <div class="flex items-start text-sm text-luxury-600 dark:text-luxury-400">
                                            <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span class="line-clamp-2">{{ $house->district->name }}</span>
                                        </div>

                                        <div class="flex items-center text-sm text-luxury-600 dark:text-luxury-400">
                                            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                            </svg>
                                            <span>{{ $house->type_label }}</span>
                                        </div>
                                    </div>

                                    {{-- Actions --}}
                                    <div class="flex justify-end items-center pt-4 border-t border-luxury-200 dark:border-luxury-600">
                                        <a href="{{ route('guest.boarding-houses.show', $house) }}"
                                            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    {{-- Empty State --}}
                    <div class="text-center py-12 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <svg class="mx-auto h-24 w-24 text-luxury-400 dark:text-luxury-600" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.79 4 4s-1.79 4-4 4-4-1.79-4-4c0-1.165.45-2.223 1.187-3.015M12 15.5A3.5 3.5 0 0015.5 12 3.5 3.5 0 0012 8.5 3.5 3.5 0 008.5 12 3.5 3.5 0 0012 15.5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-gray-100">
                            Belum Ada Kos Tersedia
                        </h3>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            Silakan cek kembali nanti untuk tambahan baru.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>