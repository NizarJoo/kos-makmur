<x-guest-booking-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h2 class="text-2xl font-serif font-bold text-luxury-800 dark:text-luxury-200">Pesan Kamar Anda
                        </h2>
                        <p class="mt-1 text-sm text-luxury-600 dark:text-luxury-400">Pilih kamar dan tanggal untuk memesan kamar kos anda.</p>
                    </div>

                    <form method="POST" action="{{ route('booking.store') }}" class="space-y-6">
                        @csrf

                        <!-- Boarding House Selection -->
                        <div>
                            <label for="boarding_house_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Pilih Kos
                            </label>
                            <select name="boarding_house_id" id="boarding_house_id"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                                <option value="">-- Pilih kos --</option>
                                @foreach ($boardingHouses as $boardingHouse)
                                    <option value="{{ $boardingHouse->id }}">{{ $boardingHouse->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Room Selection -->
                        <div>
                            <label for="room_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Pilih Kamar
                            </label>
                            <select name="room_id" id="room_id"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                                disabled>
                                <option value="">-- Pilih kos terlebih dahulu --</option>
                            </select>
                            @error('room_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Dates -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Tanggal Mulai
                                </label>
                                <input type="date" name="start_date"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Minimal memesan kamar kos 1 bulan.</p>
                                @error('start_date')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Tanggal Berakhir
                                </label>
                                <input type="date" name="end_date"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                                @error('end_date')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Display validation error for duration_months --}}
                        @error('duration_months')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror

                        {{-- General error display for non-field specific errors --}}
                        @if ($errors->any())
                            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Catatan Tambahan (opsional)
                            </label>
                            <textarea name="notes" id="notes" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                                placeholder="Ada permintaan atau informasi khusus?"></textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-luxury-800 dark:bg-luxury-700 text-white font-medium rounded-lg hover:bg-luxury-900 dark:hover:bg-luxury-600 transition-colors shadow-sm">
                                Lanjutkan Memesan
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-booking-layout>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const boardingHouseSelect = document.getElementById('boarding_house_id');
        const roomSelect = document.getElementById('room_id');

        if (boardingHouseSelect) {
            boardingHouseSelect.addEventListener('change', function () {
                const boardingHouseId = this.value;
                console.log('Selected Boarding House ID:', boardingHouseId);

                roomSelect.disabled = true;
                roomSelect.innerHTML = '<option value="">Memuat kamar...</option>';

                if (!boardingHouseId) {
                    roomSelect.innerHTML = '<option value="">-- Pilih kos terlebih dahulu --</option>';
                    return;
                }

                fetch(`/bookings/get-available-rooms/${boardingHouseId}`)
                    .then(response => {
                        console.log('Fetch response status:', response.status);
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(rooms => {
                        console.log('Received rooms:', rooms);
                        roomSelect.innerHTML = ''; // Clear existing options

                        if (!rooms || rooms.length === 0) {
                            roomSelect.innerHTML = '<option value="">-- Tidak ada kamar tersedia --</option>';
                            return;
                        }

                        let defaultOption = document.createElement('option');
                        defaultOption.value = '';
                        defaultOption.textContent = '-- Pilih kamar --';
                        roomSelect.appendChild(defaultOption);

                        rooms.forEach(room => {
                            let option = document.createElement('option');
                            option.value = room.id;
                            // Ensure properties exist to avoid 'undefined' text
                            let typeName = room.type_name || 'N/A';
                            let price = room.price_per_month || 'N/A';
                            option.textContent = `${typeName} - Rp${price} per bulan`;
                            roomSelect.appendChild(option);
                        });

                        roomSelect.disabled = false;
                    })
                    .catch(error => {
                        console.error('Error fetching or parsing rooms:', error);
                        roomSelect.innerHTML = '<option value="">-- Gagal memuat kamar --</option>';
                    });
            });
        } else {
            console.error('Boarding house select dropdown not found!');
        }
    });
</script>
