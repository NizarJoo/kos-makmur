<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('My Bookings') }}
            </h2>
            <a href="{{ route('guest.booking.create') }}"
                class="inline-flex items-center px-4 py-2 bg-luxury-800 dark:bg-luxury-700 text-white font-medium rounded-lg hover:bg-luxury-900 dark:hover:bg-luxury-600 transition-colors shadow-sm">
                <span>New Booking</span>
                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($bookings->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-luxury-600 dark:text-luxury-400 mb-4">You don't have any bookings yet.</p>
                            <a href="{{ route('guest.booking.create') }}"
                                class="inline-flex items-center px-4 py-2 bg-luxury-800 dark:bg-luxury-700 text-white font-medium rounded-lg hover:bg-luxury-900 dark:hover:bg-luxury-600 transition-colors shadow-sm">
                                Book Your Stay
                            </a>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach ($bookings as $booking)
                                <div
                                    class="p-6 bg-luxury-50 dark:bg-luxury-900/50 rounded-lg hover:bg-luxury-100 dark:hover:bg-luxury-900/70 transition-colors">
                                    <!-- Header dengan Status Badge -->
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h3 class="font-medium text-luxury-900 dark:text-luxury-100 text-lg">
                                                {{ $booking->kos->name }}
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
                                                {{ $booking->kamar->type_name }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-luxury-600 dark:text-luxury-400">Duration</p>
                                            <p class="font-medium text-luxury-900 dark:text-luxury-100">
                                                {{ $booking->duration_months }}
                                                {{ Str::plural('month', $booking->duration_months) }}
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
                                                <form action="{{ route('guest.booking.cancel', $booking->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit"
                                                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                                                        Cancel Booking
                                                    </button>
                                                </form>
                                            @endif

                                            <a href="{{ route('guest.booking.show', $booking->id) }}"
                                                class="px-4 py-2 bg-luxury-800 hover:bg-luxury-900 text-white font-medium rounded-lg transition-colors">
                                                View Details
                                            </a>
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
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $bookings->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>