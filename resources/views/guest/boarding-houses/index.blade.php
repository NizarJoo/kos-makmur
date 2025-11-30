<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Kos Tersedia') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumb --}}
            <x-breadcrumb :items="[['label' => 'Daftar Kos']]" />

            {{-- Search Form --}}
            <div class="mb-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-4">
                <form action="{{ route('guest.boarding-houses.index') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-2">
                            <input type="text" name="search"
                                class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-luxury-500 dark:focus:border-luxury-600 focus:ring-luxury-500 dark:focus:ring-luxury-600 rounded-md shadow-sm"
                                placeholder="Cari berdasarkan nama atau deskripsi..." value="{{ request('search') }}">
                        </div>
                        <div>
                            <select name="district_id"
                                class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-luxury-500 dark:focus:border-luxury-600 focus:ring-luxury-500 dark:focus:ring-luxury-600 rounded-md shadow-sm">
                                <option value="">Semua Distrik</option>
                                @foreach ($districts as $district)
                                    <option value="{{ $district->id }}" @selected(request('district_id') == $district->id)>
                                        {{ $district->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="submit"
                            class="ml-4 inline-flex items-center px-4 py-2 bg-luxury-600 dark:bg-luxury-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-luxury-700 dark:hover:bg-luxury-600 transition ease-in-out duration-150">
                            Cari
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($boardingHouses->count() > 0)
                        {{-- Grid Layout --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($boardingHouses as $house)
                                <div
                                    class="bg-white dark:bg-gray-700 rounded-lg shadow-md overflow-hidden border border-luxury-200 dark:border-luxury-700 hover:shadow-lg transition-shadow">
                                    {{-- Image --}}
                                    <div class="relative h-48 bg-luxury-100 dark:bg-luxury-900">
                                        @if ($house->image_path)
                                            <img src="{{ asset('storage/' . $house->image_path) }}"
                                                alt="{{ $house->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div
                                                class="w-full h-full flex items-center justify-center text-luxury-400 dark:text-luxury-600">
                                                <svg class="w-16 h-16" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
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
                                                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
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

                        {{-- Pagination --}}
                        @if ($boardingHouses->hasPages())
                            <div class="mt-6">
                                {{ $boardingHouses->appends(request()->query())->links() }}
                            </div>
                        @endif
                    @else
                        {{-- Empty State --}}
                        <div class="text-center py-12">
                            <svg class="mx-auto h-24 w-24 text-luxury-400 dark:text-luxury-600" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-gray-100">
                                Kos Tidak Ditemukan
                            </h3>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                Coba sesuaikan pencarian Anda atau cek kembali nanti.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
