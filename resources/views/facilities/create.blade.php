<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Facility') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumb --}}
            <x-breadcrumb :items="[
                ['label' => 'Manage Facilities', 'url' => route('facilities.index')],
                ['label' => 'Add Facility'],
            ]" />

            {{-- Alert --}}
            <x-alert />

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('facilities.store') }}" method="POST">
                        @csrf

                        {{-- Facility Name --}}
                        <div class="mb-6">
                            <x-input-label for="name" :value="__('Facility Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name')" required autofocus placeholder="e.g. WiFi, AC, Bed" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- Icon (Optional) --}}
                        <div class="mb-6">
                            <x-input-label for="icon" :value="__('Icon (Optional)')" />
                            <x-text-input id="icon" class="block mt-1 w-full" type="text" name="icon"
                                :value="old('icon')" placeholder="e.g. wifi, snowflake, bed" />
                            <x-input-error :messages="$errors->get('icon')" class="mt-2" />
                            <p class="mt-1 text-sm text-luxury-600 dark:text-luxury-400">
                                FontAwesome icon name (e.g. wifi, bed, snowflake)
                            </p>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('facilities.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-luxury-300 dark:border-luxury-600 rounded-md font-semibold text-xs text-luxury-700 dark:text-luxury-300 uppercase tracking-widest hover:bg-luxury-50 dark:hover:bg-gray-600 transition ease-in-out duration-150">
                                Cancel
                            </a>
                            <x-primary-button>
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Save
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>