<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Review Verifikasi Kos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumb --}}
            <x-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Verifikasi Kos', 'url' => route('verification.index')],
        ['label' => $boardingHouse->name],
    ]" />

            {{-- Alert --}}
            <x-alert />

            {{-- Kos Details Card --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    {{-- Header with Status Badge --}}
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $boardingHouse->name }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Didaftarkan pada {{ $boardingHouse->created_at->format('d F Y, H:i') }}
                            </p>
                        </div>
                        <span
                            class="px-4 py-2 rounded-full text-sm font-semibold {{ $boardingHouse->verification_badge_class }}">
                            {{ $boardingHouse->verification_status }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        {{-- Image --}}
                        <div class="lg:col-span-1">
                            @if ($boardingHouse->image_path)
                                <img src="{{ asset('storage/' . $boardingHouse->image_path) }}"
                                    alt="{{ $boardingHouse->name }}" class="w-full h-64 object-cover rounded-lg shadow-md">
                            @else
                                <div
                                    class="w-full h-64 flex items-center justify-center bg-luxury-100 dark:bg-luxury-900 rounded-lg">
                                    <svg class="w-24 h-24 text-luxury-400 dark:text-luxury-600" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="lg:col-span-2 space-y-4">
                            {{-- Owner Info --}}
                            <div
                                class="bg-luxury-50 dark:bg-luxury-900/20 rounded-lg p-4 border border-luxury-200 dark:border-luxury-700">
                                <h4 class="text-sm font-medium text-luxury-500 dark:text-luxury-400 mb-2">Informasi
                                    Pemilik</h4>
                                <div class="space-y-1">
                                    <p class="text-sm text-luxury-900 dark:text-luxury-100">
                                        <span class="font-semibold">Nama:</span> {{ $boardingHouse->admin->name }}
                                    </p>
                                    <p class="text-sm text-luxury-900 dark:text-luxury-100">
                                        <span class="font-semibold">Email:</span> {{ $boardingHouse->admin->email }}
                                    </p>
                                    @if($boardingHouse->admin->userProfile && $boardingHouse->admin->userProfile->phone)
                                        <p class="text-sm text-luxury-900 dark:text-luxury-100">
                                            <span class="font-semibold">Telepon:</span>
                                            {{ $boardingHouse->admin->userProfile->phone }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            {{-- Type --}}
                            <div>
                                <h4 class="text-sm font-medium text-luxury-500 dark:text-luxury-400">Tipe Kos</h4>
                                <span
                                    class="mt-1 px-3 py-1 inline-flex text-sm font-semibold rounded-full 
                                    {{ $boardingHouse->type === 'putra' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : '' }}
                                    {{ $boardingHouse->type === 'putri' ? 'bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-200' : '' }}
                                    {{ $boardingHouse->type === 'campur' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200' : '' }}">
                                    {{ $boardingHouse->type_label }}
                                </span>
                            </div>

                            {{-- District --}}
                            <div>
                                <h4 class="text-sm font-medium text-luxury-500 dark:text-luxury-400">Kecamatan</h4>
                                <p class="mt-1 text-base text-luxury-900 dark:text-luxury-100">
                                    {{ $boardingHouse->district->name }}
                                </p>
                            </div>

                            {{-- Address --}}
                            <div>
                                <h4 class="text-sm font-medium text-luxury-500 dark:text-luxury-400">Alamat Lengkap</h4>
                                <p class="mt-1 text-base text-luxury-900 dark:text-luxury-100">
                                    {{ $boardingHouse->address }}
                                </p>
                            </div>

                            {{-- Description --}}
                            <div>
                                <h4 class="text-sm font-medium text-luxury-500 dark:text-luxury-400">Deskripsi</h4>
                                <p class="mt-1 text-base text-luxury-900 dark:text-luxury-100 whitespace-pre-line">
                                    {{ $boardingHouse->description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Rooms Section --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        Daftar Kamar ({{ $boardingHouse->rooms->count() }})
                    </h3>

                    @if ($boardingHouse->rooms->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($boardingHouse->rooms as $room)
                                <div
                                    class="bg-luxury-50 dark:bg-luxury-900/20 rounded-lg p-4 border border-luxury-200 dark:border-luxury-700">
                                    {{-- Room Image --}}
                                    @if ($room->image_path)
                                        <img src="{{ asset('storage/' . $room->image_path) }}" alt="{{ $room->type_name }}"
                                            class="w-full h-40 object-cover rounded-lg mb-4">
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
                                                    {{ number_format($room->price_per_month, 0, ',', '.') }}/bulan</span>
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
                                                <span>{{ $room->availability }} unit tersedia</span>
                                            </div>
                                        </div>

                                        {{-- Facilities --}}
                                        @if ($room->facilities->count() > 0)
                                            <div class="pt-2">
                                                <p class="text-xs font-medium text-luxury-500 dark:text-luxury-400 mb-2">Fasilitas:
                                                </p>
                                                <div class="flex flex-wrap gap-1">
                                                    @foreach ($room->facilities->take(3) as $facility)
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-luxury-100 text-luxury-800 dark:bg-luxury-800 dark:text-luxury-200">
                                                            {{ $facility->name }}
                                                        </span>
                                                    @endforeach
                                                    @if ($room->facilities->count() > 3)
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-luxury-100 text-luxury-800 dark:bg-luxury-800 dark:text-luxury-200">
                                                            +{{ $room->facilities->count() - 3 }} lagi
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-gray-500 dark:text-gray-400 py-8">
                            Belum ada kamar yang ditambahkan
                        </p>
                    @endif
                </div>
            </div>

            {{-- Action Buttons --}}
            @if (!$boardingHouse->is_verified)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            Keputusan Verifikasi
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                            Setelah mereview informasi di atas, silakan pilih tindakan verifikasi:
                        </p>

                        <div class="flex flex-col sm:flex-row gap-4">
                            {{-- Approve Button --}}
                            <form action="{{ route('verification.approve', $boardingHouse) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit"
                                    onclick="return confirm('Apakah Anda yakin ingin menyetujui verifikasi kos ini? Kos akan muncul di pencarian publik.')"
                                    class="w-full inline-flex justify-center items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-colors shadow-md">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Setujui Verifikasi
                                </button>
                            </form>

                            {{-- Reject Button --}}
                            <button type="button" onclick="openRejectModal()"
                                class="flex-1 inline-flex justify-center items-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-colors shadow-md">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Tolak Verifikasi
                            </button>

                            {{-- Back Button --}}
                            <a href="{{ route('verification.index') }}"
                                class="flex-1 inline-flex justify-center items-center px-6 py-3 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-semibold rounded-lg transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>
            @else
                {{-- Already Verified --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-center py-8">
                            <div class="text-center">
                                <svg class="mx-auto h-16 w-16 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-gray-100">
                                    Kos Sudah Diverifikasi
                                </h3>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    Kos ini telah diverifikasi dan dapat dilihat oleh publik
                                </p>
                                <div class="mt-6">
                                    <a href="{{ route('verification.index') }}"
                                        class="inline-flex items-center px-4 py-2 bg-luxury-600 hover:bg-luxury-700 text-white font-medium rounded-lg transition-colors">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                        </svg>
                                        Kembali ke Daftar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Reject Modal --}}
    <div id="rejectModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-lg bg-white dark:bg-gray-800">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        Tolak Verifikasi Kos
                    </h3>
                    <button onclick="closeRejectModal()"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form action="{{ route('verification.reject', $boardingHouse) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="rejection_reason"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Alasan Penolakan (Opsional)
                        </label>
                        <textarea id="rejection_reason" name="rejection_reason" rows="4"
                            class="block w-full border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 rounded-lg shadow-sm focus:border-luxury-500 focus:ring-luxury-500"
                            placeholder="Berikan alasan kenapa kos ini ditolak..."></textarea>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit"
                            class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                            Konfirmasi Tolak
                        </button>
                        <button type="button" onclick="closeRejectModal()"
                            class="flex-1 px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium rounded-lg transition-colors">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function openRejectModal() {
                document.getElementById('rejectModal').classList.remove('hidden');
            }

            function closeRejectModal() {
                document.getElementById('rejectModal').classList.add('hidden');
            }

            // Close modal when clicking outside
            document.getElementById('rejectModal')?.addEventListener('click', function (e) {
                if (e.target === this) {
                    closeRejectModal();
                }
            });
        </script>
    @endpush
</x-app-layout>