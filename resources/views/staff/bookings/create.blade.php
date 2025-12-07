<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Buat Booking Baru untuk Tamu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8">
                    <form method="POST" action="{{ route('staff.bookings.store') }}" class="space-y-6">
                        @csrf
                        
                        @if ($errors->any())
                            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Guest Selection -->
                        <div>
                            <label for="guest_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Pilih Tamu
                            </label>
                            <select name="guest_id" id="guest_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300" required>
                                <option value="">-- Pilih seorang tamu --</option>
                                @foreach ($guests as $guest)
                                    <option value="{{ $guest->id }}" {{ old('guest_id') == $guest->id ? 'selected' : '' }}>{{ $guest->name }} ({{ $guest->email }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Boarding House Selection -->
                        <div>
                            <label for="boarding_house_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Pilih Kos
                            </label>
                            <select name="boarding_house_id" id="boarding_house_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300" required>
                                <option value="">-- Pilih kos --</option>
                                @foreach ($boardingHouses as $boardingHouse)
                                    <option value="{{ $boardingHouse->id }}" {{ old('boarding_house_id') == $boardingHouse->id ? 'selected' : '' }}>{{ $boardingHouse->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Room Selection -->
                        <div>
                            <label for="room_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Pilih Kamar
                            </label>
                            <select name="room_id" id="room_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300" required {{ old('boarding_house_id') ? '' : 'disabled' }}>
                                <option value="">-- Pilih kos terlebih dahulu --</option>
                            </select>
                        </div>

                        <!-- Dates -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Tanggal Mulai
                                </label>
                                <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300" required>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Minimal memesan kamar kos 1 bulan.</p>
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Tanggal Berakhir
                                </label>
                                <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300" required>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Catatan Tambahan (opsional)
                            </label>
                            <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300" placeholder="Informasi tambahan mengenai booking...">{{ old('notes') }}</textarea>
                        </div>

                        <div class="flex justify-end pt-4">
                            <button type="submit" class="inline-flex items-center px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors shadow-sm">
                                Buat Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const boardingHouseSelect = document.getElementById('boarding_house_id');
    const roomSelect = document.getElementById('room_id');
    const selectedRoomId = '{{ old('room_id') }}';

    function fetchRooms(boardingHouseId, selectedRoom = null) {
        if (!boardingHouseId) {
            roomSelect.disabled = true;
            roomSelect.innerHTML = '<option value="">-- Pilih kos terlebih dahulu --</option>';
            return;
        }

        roomSelect.disabled = true;
        roomSelect.innerHTML = '<option value="">Memuat kamar...</option>';

        fetch(`/bookings/get-available-rooms/${boardingHouseId}`)
            .then(response => response.json())
            .then(rooms => {
                roomSelect.innerHTML = '';

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
                    let price = new Intl.NumberFormat('id-ID').format(room.price_per_month);
                    option.textContent = `${room.type_name} - Rp${price} per bulan`;
                    if (selectedRoom && room.id == selectedRoom) {
                        option.selected = true;
                    }
                    roomSelect.appendChild(option);
                });

                roomSelect.disabled = false;
            })
            .catch(error => {
                console.error('Error fetching rooms:', error);
                roomSelect.innerHTML = '<option value="">-- Gagal memuat kamar --</option>';
            });
    }

    boardingHouseSelect.addEventListener('change', function () {
        fetchRooms(this.value);
    });

    // On page load, if a boarding house was already selected (e.g., due to validation error),
    // trigger the fetch to populate the rooms and re-select the previously chosen room.
    if (boardingHouseSelect.value) {
        fetchRooms(boardingHouseSelect.value, selectedRoomId);
    }
});
</script>
</x-app-layout>
