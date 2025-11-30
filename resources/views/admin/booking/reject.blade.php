<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-serif text-2xl font-bold text-luxury-800 dark:text-gold-300">
                    Tolak Booking
                </h2>
                <p class="text-sm text-luxury-600 dark:text-gold-400 mt-1">Berikan alasan penolakan booking</p>
            </div>
            <a href="{{ route('bookings.index') }}"
                class="text-luxury-600 dark:text-gold-400 hover:text-luxury-800 dark:hover:text-gold-200">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <!-- Info Booking -->
                    <div class="mb-6 p-4 bg-luxury-50 dark:bg-gray-700 rounded-lg">
                        <h3 class="font-semibold text-luxury-800 dark:text-gold-300 mb-2">Detail Booking</h3>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-luxury-600 dark:text-gold-400">Tamu:</span>
                                <p class="font-medium">{{ $booking->guest->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <span class="text-luxury-600 dark:text-gold-400">Kamar:</span>
                                <p class="font-medium">{{ $booking->room->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <span class="text-luxury-600 dark:text-gold-400">Check-in:</span>
                                <p class="font-medium">
                                    {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }}</p>
                            </div>
                            <div>
                                <span class="text-luxury-600 dark:text-gold-400">Check-out:</span>
                                <p class="font-medium">
                                    {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Rejection Form -->
                    <form action="{{ route('bookings.reject', $booking) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-6">
                            <label for="rejection_reason"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Alasan Penolakan <span class="text-red-500">*</span>
                            </label>
                            <textarea name="rejection_reason" id="rejection_reason" rows="4"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-luxury-500 focus:border-luxury-500 dark:bg-gray-700 dark:text-white"
                                placeholder="Berikan alasan penolakan booking..."
                                required>{{ old('rejection_reason') }}</textarea>
                            @error('rejection_reason')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div
                            class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-600">
                            <a href="{{ route('bookings.index') }}"
                                class="px-4 py-2 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">
                                Batal
                            </a>
                            <button type="submit"
                                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                Tolak Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>