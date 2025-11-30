<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Booking Details') }}
            </h2>
            <a href="{{ route('booking.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-medium rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span>Back to My Bookings</span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div
                        class="p-6 bg-luxury-50 dark:bg-luxury-900/50 rounded-lg">
                        <!-- Header dengan Status Badge -->
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="font-medium text-luxury-900 dark:text-luxury-100 text-lg">
                                    {{ $booking->boardingHouse?->name }}
                                </h3>
                                <p class="text-sm text-luxury-600 dark:text-luxury-400">
                                    Booking Code: <span
                                        class="font-mono font-semibold">{{ $booking->booking_code }}</span>
                                </p>
                            </div>
                            <span class="px-3 py-1 text-sm font-medium rounded-full
                                        {{ $booking->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                        {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
                                        {{ $booking->status === 'approved' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : '' }}
                                        {{ $booking->status === 'finished' ? 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400' : '' }}
                                        {{ $booking->status === 'rejected' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : '' }}
                                        {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : '' }}
                                    ">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>

                        <!-- Room Info -->
                        <div class="grid md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-sm text-luxury-600 dark:text-luxury-400">Room Type</p>
                                <p class="font-medium text-luxury-900 dark:text-luxury-100">
                                    {{ $booking->room?->type_name }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-luxury-600 dark:text-luxury-400">Duration</p>
                                <p class="font-medium text-luxury-900 dark:text-luxury-100">
                                    {{ $booking->duration_months }}
                                    {{ \Illuminate\Support\Str::plural('month', $booking->duration_months) }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-luxury-600 dark:text-luxury-400">Check-in Date</p>
                                <p class="font-medium text-luxury-900 dark:text-luxury-100">
                                    {{ \Carbon\Carbon::parse($booking->start_date)->format('M d, Y') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-luxury-600 dark:text-luxury-400">Check-out Date</p>
                                <p class="font-medium text-luxury-900 dark:text-luxury-100">
                                    {{ \Carbon\Carbon::parse($booking->end_date)->format('M d, Y') }}
                                </p>
                            </div>
                        </div>

                        <!-- Total Price -->
                        <div
                            class="flex justify-between items-center pt-4 border-t border-luxury-200 dark:border-luxury-700">
                            <div>
                                <p class="text-sm text-luxury-600 dark:text-luxury-400">Total Price</p>
                                <p class="text-2xl font-bold text-luxury-800 dark:text-luxury-200">
                                    Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                </p>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex space-x-2">
                                @if($booking->status === 'pending')
                                    <form action="{{ route('guest.bookings.cancel', $booking->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                                            Cancel Booking
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        <!-- Notes (if exists) -->
                        @if($booking->notes)
                            <div class="mt-4 p-3 bg-luxury-100 dark:bg-luxury-900/30 rounded">
                                <p class="text-sm text-luxury-600 dark:text-luxury-400 mb-1">Your Notes:</p>
                                <p class="text-sm text-luxury-800 dark:text-luxury-200">{{ $booking->notes }}</p>
                            </div>
                        @endif

                        <!-- Rejection Reason (if rejected) -->
                        @if($booking->status === 'rejected' && $booking->rejection_reason)
                            <div
                                class="mt-4 p-3 bg-red-100 dark:bg-red-900/30 rounded border border-red-300 dark:border-red-700">
                                <p class="text-sm font-semibold text-red-800 dark:text-red-400 mb-1">Rejection Reason:
                                </p>
                                <p class="text-sm text-red-700 dark:text-red-300">{{ $booking->rejection_reason }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
