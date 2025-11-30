<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif text-2xl font-bold text-luxury-800 dark:text-gold-300">
            Manajemen Booking
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Filter Status -->
            <div class="mb-6 flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Filter:</span>
                    <select onchange="window.location.href = '{{ route('bookings.index') }}?status=' + this.value"
                        class="border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 text-sm">
                        <option value="all" {{ request('status') === 'all' || !request('status') ? 'selected' : '' }}>
                            Semua Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui
                        </option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <a href="{{ route('bookings.create') }}"
                    class="bg-luxury-600 text-white px-4 py-2 rounded-lg hover:bg-luxury-700 text-sm">
                    + Booking Baru
                </a>
            </div>

            @if($bookings->count() > 0)
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
                    <table class="min-w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                    Tamu</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                    Kamar</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                    Check-in</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                    Check-out</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($bookings as $booking)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $booking->guest->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $booking->room->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
    {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }}
</td>
<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
    {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d M Y') }}
</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'approved' => 'bg-green-100 text-green-800',
                                                'rejected' => 'bg-red-100 text-red-800',
                                                'active' => 'bg-blue-100 text-blue-800'
                                            ];
                                            $color = $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $color }}">
                                            {{ $booking->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <!-- DEBUG: Tampilkan status untuk testing -->
                                        <div class="text-xs text-gray-500 mb-1">
                                            Status: {{ $booking->status }}, ID: {{ $booking->id }}
                                        </div>

                                        @if($booking->status === 'pending')
                                            <div class="flex space-x-2">
                                                <!-- Approve Button -->
                                                <form action="{{ route('bookings.approve', $booking) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="bg-green-500 text-white px-3 py-1 rounded text-xs hover:bg-green-600"
                                                        onclick="return confirm('Setujui booking ini?')">
                                                        Setujui
                                                    </button>
                                                </form>

                                                <!-- Reject Button -->
                                                <a href="{{ route('bookings.reject.form', $booking) }}"
                                                    class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600">
                                                    Tolak
                                                </a>
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $bookings->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Tidak ada booking</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        @if(request('status') && request('status') !== 'all')
                            Tidak ada booking dengan status "{{ request('status') }}"
                        @else
                            Belum ada data booking
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>