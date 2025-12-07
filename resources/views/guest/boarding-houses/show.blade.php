<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $boardingHouse->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumb --}}
            <x-breadcrumb :items="[
                ['label' => 'Daftar Kos', 'url' => route('guest.boarding-houses.index')],
                ['label' => $boardingHouse->name],
            ]" />

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    {{-- Image --}}
                    <div class="relative h-96 bg-luxury-100 dark:bg-luxury-900 rounded-lg mb-6">
                        @if ($boardingHouse->image_path)
                            <img src="{{ asset('storage/' . $boardingHouse->image_path) }}" alt="{{ $boardingHouse->name }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-luxury-400 dark:text-luxury-600">
                                <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    {{-- Details --}}
                    <div class="grid grid-cols-1">
                        <div class="md:col-span-2">
                            <h3 class="text-2xl font-bold text-luxury-800 dark:text-luxury-200 mb-2">
                                {{ $boardingHouse->name }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">
                                {{ $boardingHouse->description }}
                            </p>
                            <div class="space-y-2">
                                <div class="flex items-center text-sm text-luxury-600 dark:text-luxury-400">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>{{ optional($boardingHouse->district)->name ?? 'N/A' }}</span>
                                </div>
                                <div class="flex items-center text-sm text-luxury-600 dark:text-luxury-400">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    </svg>
                                    <span>{{ $boardingHouse->address }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Rooms List --}}
                    <div class="mt-8">
                        <h3 class="text-xl font-semibold mb-4">Kamar Tersedia</h3>
                        @forelse ($boardingHouse->rooms as $room)
                            @if ($loop->first)
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @endif

                            <div
                                class="bg-white dark:bg-gray-700 rounded-lg shadow-md overflow-hidden border border-luxury-200 dark:border-luxury-700">
                                <div class="relative h-48 bg-luxury-100 dark:bg-luxury-800">
                                    @if ($room->image_path)
                                        <img src="{{ asset('storage/' . $room->image_path) }}" alt="{{ $room->type_name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-luxury-400 dark:text-luxury-600">
                                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l-1-1a2 2 0 00-2.828 0L8 14m-2 2a2 2 0 100 4 2 2 0 000-4z"></path></svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h4 class="font-bold text-lg">{{ $room->type_name ?? 'Kamar' }}</h4>
                                    <p class="text-sm text-gray-500 mb-2">Kapasitas: {{ $room->capacity }} orang</p>
                                    <p class="text-lg font-semibold text-luxury-600 dark:text-luxury-300">
                                        Rp {{ number_format($room->price_per_month, 0, ',', '.') }} / bulan
                                    </p>
                                    <a href="{{ route('booking.create', ['room_id' => $room->id, 'boarding_house_id' => $boardingHouse->id]) }}" class="mt-4 inline-block bg-luxury-800 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-luxury-900">
                                        Booking Sekarang
                                    </a>
                                </div>
                            </div>

                            @if ($loop->last)
                                </div>
                            @endif
                        @empty
                            <p class="text-gray-500">Tidak ada kamar tersedia saat ini.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
