<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $boardingHouse->name }}
            </h2>
            <div class="flex items-center space-x-2">
                @if ($boardingHouse->is_verified)
                    <span
                        class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                        Verified
                    </span>
                @else
                    <span
                        class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                        Pending
                    </span>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumb --}}
            <x-breadcrumb :items="[
        ['label' => 'My Boarding Houses', 'url' => route('boarding-houses.index')],
        ['label' => $boardingHouse->name],
    ]" />

            {{-- Alert --}}
            <x-alert />

            {{-- Boarding House Details --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        {{-- Image --}}
                        <div class="lg:col-span-1">
                            <div
                                class="aspect-w-16 aspect-h-12 rounded-lg overflow-hidden bg-luxury-100 dark:bg-luxury-900">
                                @if ($boardingHouse->image_path)
                                    <img src="{{ asset('storage/' . $boardingHouse->image_path) }}"
                                        alt="{{ $boardingHouse->name }}" class="w-full h-64 object-cover rounded-lg">
                                @else
                                    <div
                                        class="w-full h-64 flex items-center justify-center text-luxury-400 dark:text-luxury-600">
                                        <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Info --}}
                        <div class="lg:col-span-2">
                            <div class="space-y-4">
                                {{-- Type --}}
                                <div>
                                    <h3 class="text-sm font-medium text-luxury-500 dark:text-luxury-400">Type</h3>
                                    <p class="mt-1 text-base text-luxury-900 dark:text-luxury-100">
                                        {{ $boardingHouse->type_label }}
                                    </p>
                                </div>

                                {{-- District --}}
                                <div>
                                    <h3 class="text-sm font-medium text-luxury-500 dark:text-luxury-400">District</h3>
                                    <p class="mt-1 text-base text-luxury-900 dark:text-luxury-100">
                                        {{ $boardingHouse->district->name }}
                                    </p>
                                </div>

                                {{-- Address --}}
                                <div>
                                    <h3 class="text-sm font-medium text-luxury-500 dark:text-luxury-400">Address</h3>
                                    <p class="mt-1 text-base text-luxury-900 dark:text-luxury-100">
                                        {{ $boardingHouse->address }}
                                    </p>
                                </div>

                                {{-- Description --}}
                                <div>
                                    <h3 class="text-sm font-medium text-luxury-500 dark:text-luxury-400">Description
                                    </h3>
                                    <p class="mt-1 text-base text-luxury-900 dark:text-luxury-100 whitespace-pre-line">
                                        {{ $boardingHouse->description }}
                                    </p>
                                </div>

                                {{-- Actions --}}
                                <div class="flex items-center space-x-3 pt-4">
                                    <a href="{{ route('boarding-houses.edit', $boardingHouse) }}"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit Boarding House
                                    </a>
                                    <a href="{{ route('boarding-houses.index') }}"
                                        class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-luxury-300 dark:border-luxury-600 rounded-md text-sm font-medium text-luxury-700 dark:text-luxury-300 hover:bg-luxury-50 dark:hover:bg-gray-600 transition-colors">
                                        Back to List
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Rooms Section --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            Rooms ({{ $boardingHouse->rooms->count() }})
                        </h3>
                        <a href="{{ route('boarding-houses.rooms.create', $boardingHouse) }}"
                            class="inline-flex items-center px-4 py-2 bg-luxury-600 dark:bg-luxury-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-luxury-700 dark:hover:bg-luxury-600 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Add Room
                        </a>
                    </div>

                    @if ($boardingHouse->rooms->count() > 0)
                        {{-- Rooms Grid --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($boardingHouse->rooms as $room)
                                <div
                                    class="bg-luxury-50 dark:bg-luxury-900/20 rounded-lg p-4 border border-luxury-200 dark:border-luxury-700 hover:shadow-md transition-shadow">
                                    {{-- Room Image --}}
                                    @if ($room->image_path)
                                        <div class="mb-4">
                                            <img src="{{ asset('storage/' . $room->image_path) }}" alt="{{ $room->type_name }}"
                                                class="w-full h-40 object-cover rounded-lg">
                                        </div>
                                    @endif

                                    {{-- Room Info --}}
                                    <div class="space-y-2">
                                        <h4 class="font-semibold text-luxury-900 dark:text-luxury-100">
                                            {{ $room->type_name }}
                                        </h4>

                                        <div class="text-sm text-luxury-600 dark:text-luxury-400 space-y-1">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span class="font-semibold">Rp
                                                    {{ number_format($room->price_per_month, 0, ',', '.') }}/month</span>
                                            </div>

                                            @if ($room->size)
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                                                    </svg>
                                                    <span>{{ $room->size }}</span>
                                                </div>
                                            @endif

                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                                                </svg>
                                                <span>{{ $room->available_units }}/{{ $room->availability }} units
                                                    available</span>
                                            </div>
                                        </div>

                                        {{-- Facilities --}}
                                        @if ($room->facilities->count() > 0)
                                            <div class="pt-2">
                                                <p class="text-xs font-medium text-luxury-500 dark:text-luxury-400 mb-2">
                                                    Facilities:</p>
                                                <div class="flex flex-wrap gap-1">
                                                    @foreach ($room->facilities->take(4) as $facility)
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-luxury-100 text-luxury-800 dark:bg-luxury-800 dark:text-luxury-200">
                                                            {{ $facility->name }}
                                                        </span>
                                                    @endforeach
                                                    @if ($room->facilities->count() > 4)
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-luxury-100 text-luxury-800 dark:bg-luxury-800 dark:text-luxury-200">
                                                            +{{ $room->facilities->count() - 4 }} more
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif

                                        {{-- Actions --}}
                                        <div class="flex justify-end space-x-2 pt-3">
                                            <a href="{{ route('boarding-houses.rooms.edit', [$boardingHouse, $room]) }}"
                                                class="inline-flex items-center p-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200 transition-colors"
                                                title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>

                                            <button type="button" onclick="confirmDeleteRoom({{ $room->id }})"
                                                class="inline-flex items-center p-2 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200 transition-colors"
                                                title="Delete">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>

                                            <form id="delete-room-form-{{ $room->id }}"
                                                action="{{ route('boarding-houses.rooms.destroy', [$boardingHouse, $room]) }}"
                                                method="POST" class="hidden">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        {{-- Empty State --}}
                        <div class="text-center py-12">
                            <svg class="mx-auto h-16 w-16 text-luxury-400 dark:text-luxury-600" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-gray-100">
                                No rooms yet
                            </h3>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                Start adding rooms to your boarding house.
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('boarding-houses.rooms.create', $boardingHouse) }}"
                                    class="inline-flex items-center px-4 py-2 bg-luxury-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-luxury-700 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    Add First Room
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function confirmDeleteRoom(id) {
                if (confirm('Are you sure you want to delete this room?')) {
                    document.getElementById('delete-room-form-' + id).submit();
                }
            }
        </script>
    @endpush
</x-app-layout>