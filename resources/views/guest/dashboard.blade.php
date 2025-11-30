<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('My Dashboard') }}
            </h2>
            <a href="{{ route('booking.create') }}"
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
            <div class="bg-white/80 dark:bg-gray-800/80 overflow-hidden shadow-luxury gold-border rounded-lg bg-blur">
                <div class="p-6">
                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        <!-- Active Bookings -->
                        <div
                            class="bg-gradient-to-br from-luxury-50/90 to-white/90 dark:from-luxury-900/40 dark:to-gray-800/40 p-6 rounded-lg gold-border shadow-luxury">
                            <h3 class="text-lg font-serif font-semibold text-luxury-800 dark:text-luxury-200 mb-2">
                                Active Bookings
                            </h3>
                            <p class="text-3xl font-bold text-luxury-900 dark:text-luxury-100">
                                {{ auth()->user()->bookings()->where('status', 'active')->count() }}
                            </p>
                        </div>

                        <!-- Pending Bookings -->
                        <div
                            class="bg-gradient-to-br from-luxury-50/90 to-white/90 dark:from-luxury-900/40 dark:to-gray-800/40 p-6 rounded-lg gold-border shadow-luxury">
                            <h3 class="text-lg font-serif font-semibold text-luxury-800 dark:text-luxury-200 mb-2">
                                Pending Approvals
                            </h3>
                            <p class="text-3xl font-bold text-luxury-900 dark:text-luxury-100">
                                {{ auth()->user()->bookings()->where('status', 'pending')->count() }}
                            </p>
                        </div>

                        <!-- Completed Bookings -->
                        <div
                            class="bg-gradient-to-br from-luxury-50/90 to-white/90 dark:from-luxury-900/40 dark:to-gray-800/40 p-6 rounded-lg gold-border shadow-luxury">
                            <h3 class="text-lg font-serif font-semibold text-luxury-800 dark:text-luxury-200 mb-2">
                                Completed Stays
                            </h3>
                            <p class="text-3xl font-bold text-luxury-900 dark:text-luxury-100">
                                {{ auth()->user()->bookings()->where('status', 'finished')->count() }}
                            </p>
                        </div>
                    </div>

                    <!-- Recent Bookings -->
                    <div class="mt-8">
                        <h3 class="text-lg font-serif font-semibold text-luxury-800 dark:text-luxury-200 mb-4">
                            Recent Bookings
                        </h3>

                        @php
                            $recentBookings = auth()->user()->bookings()
                                ->with(['room.boardingHouse', 'boardingHouse'])
                                ->latest()
                                ->take(5)
                                ->get();
                        @endphp

                        @if($recentBookings->isEmpty())
                            <div class="text-center py-8">
                                <p class="text-luxury-600 dark:text-luxury-400 mb-4">You don't have any bookings yet.</p>
                                <a href="{{ route('booking.create') }}"
                                    class="inline-flex items-center px-4 py-2 bg-luxury-800 dark:bg-luxury-700 text-white font-medium rounded-lg hover:bg-luxury-900 dark:hover:bg-luxury-600 transition-colors shadow-sm">
                                    Book Your Stay
                                </a>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach ($recentBookings as $booking)
                                    <div
                                        class="flex flex-col md:flex-row justify-between items-start md:items-center p-4 bg-luxury-50 dark:bg-luxury-900/50 rounded-lg hover:bg-luxury-100 dark:hover:bg-luxury-900/70 transition-colors">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-4">
                                                <div
                                                    class="p-2 bg-{{ $booking->status_color }}-100 dark:bg-{{ $booking->status_color }}-900/30 rounded-full">
                                                    <svg class="w-5 h-5 text-{{ $booking->status_color }}-600 dark:text-{{ $booking->status_color }}-400"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h4 class="font-medium text-luxury-900 dark:text-luxury-100">
                                                        {{ $booking->boardingHouse->name ?? 'N/A' }} -
                                                        {{ $booking->room->type_name ?? 'N/A' }}
                                                    </h4>
                                                    <p class="text-sm text-luxury-600 dark:text-luxury-400">
                                                        {{ $booking->start_date?->format('M d, Y') }} -
                                                        {{ $booking->end_date?->format('M d, Y') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4 md:mt-0 flex items-center space-x-4">
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
                                            <span class="text-luxury-800 dark:text-luxury-200 font-medium">
                                                {{ $booking->formatted_price }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>