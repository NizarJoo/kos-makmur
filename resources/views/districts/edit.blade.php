<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Kecamatan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumb --}}
            <x-breadcrumb :items="[
        ['label' => 'Kelola Kecamatan', 'url' => route('districts.index')],
        ['label' => 'Edit Kecamatan'],
    ]" />

            {{-- Alert --}}
            <x-alert />

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('districts.update', $district) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Nama Kecamatan --}}
                        <div class="mb-6">
                            <x-input-label for="name" :value="__('Nama Kecamatan')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name', $district->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- Info --}}
                        @if ($district->kos_count > 0)
                            <div
                                class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div class="ml-3">
                                        <p class="text-sm text-blue-800 dark:text-blue-200">
                                            Kecamatan ini memiliki <strong>{{ $district->kos_count }} kos</strong>.
                                            Perubahan nama akan mempengaruhi tampilan kos terkait.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Action Buttons --}}
                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('districts.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-luxury-300 dark:border-luxury-600 rounded-md font-semibold text-xs text-luxury-700 dark:text-luxury-300 uppercase tracking-widest hover:bg-luxury-50 dark:hover:bg-gray-600 transition ease-in-out duration-150">
                                Batal
                            </a>
                            <x-primary-button>
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Update
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>