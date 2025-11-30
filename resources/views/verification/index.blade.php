@php
    use Illuminate\Support\Str;
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Verifikasi Kos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumb --}}
            <x-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Verifikasi Kos'],
    ]" />

            {{-- Alert --}}
            <x-alert />

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    {{-- Header Section --}}
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                            Daftar Kos Menunggu Verifikasi
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Review dan verifikasi kos yang didaftarkan oleh Admin
                        </p>
                    </div>

                    @if ($boardingHouses->count() > 0)
                        {{-- Stats Card --}}
                        <div class="bg-luxury-50 dark:bg-luxury-900/20 rounded-lg p-4 mb-6 border border-luxury-200 dark:border-luxury-700">
                            <div class="flex items-center">
                                <svg class="w-8 h-8 text-luxury-600 dark:text-luxury-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <p class="text-sm text-luxury-600 dark:text-luxury-400">Total Pending</p>
                                    <p class="text-2xl font-bold text-luxury-900 dark:text-luxury-100">
                                        {{ $boardingHouses->total() }} Kos
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Table --}}
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-luxury-200 dark:divide-luxury-700">
                                <thead class="bg-luxury-50 dark:bg-luxury-900/50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-luxury-500 dark:text-luxury-400 uppercase tracking-wider">
                                            Nama Kos
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-luxury-500 dark:text-luxury-400 uppercase tracking-wider">
                                            Pemilik
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-luxury-500 dark:text-luxury-400 uppercase tracking-wider">
                                            District
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-luxury-500 dark:text-luxury-400 uppercase tracking-wider">
                                            Tipe
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-luxury-500 dark:text-luxury-400 uppercase tracking-wider">
                                            Tanggal Daftar
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-luxury-500 dark:text-luxury-400 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-luxury-200 dark:divide-luxury-700">
                                    @foreach ($boardingHouses as $boardingHouse)
                                        <tr class="hover:bg-luxury-50 dark:hover:bg-luxury-900/20 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    @if ($boardingHouse->image_path)
                                                        <img src="{{ asset('storage/' . $boardingHouse->image_path) }}" 
                                                             alt="{{ $boardingHouse->name }}"
                                                             class="w-12 h-12 rounded-lg object-cover mr-3">
                                                    @else
                                                        <div class="w-12 h-12 rounded-lg bg-luxury-100 dark:bg-luxury-800 flex items-center justify-center mr-3">
                                                            <svg class="w-6 h-6 text-luxury-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <div class="text-sm font-medium text-luxury-900 dark:text-luxury-100">
                                                            {{ $boardingHouse->name }}
                                                        </div>
                                                        <div class="text-xs text-luxury-500 dark:text-luxury-400">
                                                            {{ Str::limit($boardingHouse->address, 40) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-luxury-900 dark:text-luxury-100">
                                                    {{ $boardingHouse->admin->name }}
                                                </div>
                                                <div class="text-xs text-luxury-500 dark:text-luxury-400">
                                                    {{ $boardingHouse->admin->email }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="text-sm text-luxury-900 dark:text-luxury-100">
                                                    {{ $boardingHouse->district->name }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $boardingHouse->type === 'putra' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : '' }}
                                                    {{ $boardingHouse->type === 'putri' ? 'bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-200' : '' }}
                                                    {{ $boardingHouse->type === 'campur' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200' : '' }}">
                                                    {{ $boardingHouse->type_label }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-luxury-500 dark:text-luxury-400">
                                                {{ $boardingHouse->created_at->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('verification.show', $boardingHouse) }}"
                                                    class="inline-flex items-center px-3 py-1.5 bg-luxury-600 hover:bg-luxury-700 text-white text-xs font-medium rounded-md transition-colors">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    Review
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-6">
                            {{ $boardingHouses->links() }}
                        </div>
                    @else
                        {{-- Empty State --}}
                        <div class="text-center py-12">
                            <svg class="mx-auto h-16 w-16 text-luxury-400 dark:text-luxury-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-gray-100">
                                Tidak ada kos yang perlu diverifikasi
                            </h3>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                Semua kos sudah diverifikasi atau belum ada yang mendaftar
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>