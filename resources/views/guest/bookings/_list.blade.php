@if($bookings->isEmpty())
    <div class="text-center py-8">
        <p class="text-luxury-600 dark:text-luxury-400">No bookings found.</p>
    </div>
@else
    <div class="space-y-4">
        @foreach ($bookings as $booking)
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center p-4 bg-luxury-50 dark:bg-luxury-900/50 rounded-lg hover:bg-luxury-100 dark:hover:bg-luxury-900/70 transition-colors">
                <div class="flex-1">
                    <div class="flex items-center space-x-4">
                        <div class="p-2 bg-{{ $booking->status === 'active' ? 'green' : ($booking->status === 'pending' ? 'yellow' : 'gray') }}-100 dark:bg-{{ $booking->status === 'active' ? 'green' : ($booking->status === 'pending' ? 'yellow' : 'gray') }}-900/30 rounded-full">
                            <svg class="w-5 h-5 text-{{ $booking->status === 'active' ? 'green' : ($booking->status === 'pending' ? 'yellow' : 'gray') }}-600 dark:text-{{ $booking->status === 'active' ? 'green' : ($booking->status === 'pending' ? 'yellow' : 'gray') }}-400"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div>
                            @if($booking->room)
                                <h4 class="font-medium text-luxury-900 dark:text-luxury-100">
                                    Room {{ $booking->room->room_number }} - {{ $booking->room->room_type }}
                                </h4>
                            @else
                                <h4 class="font-medium text-luxury-900 dark:text-luxury-100">
                                    Booking #{{ $booking->id }}
                                </h4>
                                <p class="text-xs text-red-600 dark:text-red-400">Room data not available</p>
                            @endif
                            
                            <p class="text-sm text-luxury-600 dark:text-luxury-400">
                                @if($booking->check_in_date && $booking->check_out_date)
                                    {{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }} -
                                    {{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}
                                @else
                                    Date not set
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-4 md:mt-0 flex items-center space-x-4">
                    <span class="px-3 py-1 text-sm font-medium rounded-full
                        {{ $booking->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : '' }}
                        {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
                        {{ $booking->status === 'completed' ? 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400' : '' }}
                        {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : '' }}
                    ">
                        {{ ucfirst($booking->status) }}
                    </span>
                    @if($booking->total_amount)
                        <span class="text-luxury-800 dark:text-luxury-200 font-medium">
                            ${{ number_format($booking->total_amount, 2) }}
                        </span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endif