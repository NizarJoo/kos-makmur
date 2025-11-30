<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Room') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumb --}}
            <x-breadcrumb :items="[
                ['label' => 'My Boarding Houses', 'url' => route('boarding-houses.index')],
                ['label' => $boardingHouse->name, 'url' => route('boarding-houses.show', $boardingHouse)],
                ['label' => 'Edit Room'],
            ]" />

            {{-- Alert --}}
            <x-alert />

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('boarding-houses.rooms.update', [$boardingHouse, $room]) }}" method="POST"
                        enctype="multipart/form-data"
                        x-data="imagePreview('{{ $room->image_path ? asset('storage/' . $room->image_path) : '' }}')">
                        @csrf
                        @method('PUT')

                        {{-- Room Type Name --}}
                        <div class="mb-6">
                            <x-input-label for="type_name" :value="__('Room Type Name')" />
                            <x-text-input id="type_name" class="block mt-1 w-full" type="text" name="type_name"
                                :value="old('type_name', $room->type_name)" required autofocus />
                            <x-input-error :messages="$errors->get('type_name')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            {{-- Price Per Month --}}
                            <div>
                                <x-input-label for="price_per_month" :value="__('Price Per Month (Rp)')" />
                                <x-text-input id="price_per_month" class="block mt-1 w-full" type="number"
                                    name="price_per_month" :value="old('price_per_month', $room->price_per_month)" required
                                    min="0" />
                                <x-input-error :messages="$errors->get('price_per_month')" class="mt-2" />
                            </div>

                            {{-- Total Units --}}
                            <div>
                                <x-input-label for="availability" :value="__('Total Units Available')" />
                                <x-text-input id="availability" class="block mt-1 w-full" type="number"
                                    name="availability" :value="old('availability', $room->availability)" required min="1" />
                                <x-input-error :messages="$errors->get('availability')" class="mt-2" />
                                <p class="mt-1 text-sm text-luxury-600 dark:text-luxury-400">
                                    Currently available: {{ $room->available_units ?? 0 }} units
                                </p>
                            </div>
                        </div>

                        {{-- Room Size --}}
                        <div class="mb-6">
                            <x-input-label for="size" :value="__('Room Size (Optional)')" />
                            <x-text-input id="size" class="block mt-1 w-full" type="text" name="size"
                                :value="old('size', $room->size)" placeholder="e.g. 3x4 meters, 12 m²" />
                            <x-input-error :messages="$errors->get('size')" class="mt-2" />
                        </div>

                        {{-- Description --}}
                        <div class="mb-6">
                            <x-input-label for="description" :value="__('Description (Optional)')" />
                            <textarea id="description" name="description" rows="3"
                                class="block mt-1 w-full border-luxury-200 dark:border-luxury-700 bg-white/50 dark:bg-gray-900/50 text-luxury-900 dark:text-luxury-100 focus:border-luxury-500 dark:focus:border-luxury-600 focus:ring-luxury-500 dark:focus:ring-luxury-600 rounded-lg shadow-sm transition-colors">{{ old('description', $room->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        {{-- Facilities --}}
                        <div class="mb-6">
                            <x-input-label :value="__('Facilities')" class="mb-3" />
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                @foreach ($facilities as $facility)
                                    <label
                                        class="relative flex items-center p-3 border-2 rounded-lg cursor-pointer transition-all hover:border-luxury-500 dark:hover:border-luxury-400 has-[:checked]:border-luxury-600 has-[:checked]:bg-luxury-50 dark:has-[:checked]:bg-luxury-900/20 border-luxury-200 dark:border-luxury-700">
                                        <input type="checkbox" name="facilities[]" value="{{ $facility->id }}"
                                            {{ in_array($facility->id, old('facilities', $room->facilities->pluck('id')->toArray())) ? 'checked' : '' }}
                                            class="rounded border-luxury-300 text-luxury-600 shadow-sm focus:ring-luxury-500 dark:focus:ring-luxury-600 dark:focus:ring-offset-gray-800">
                                        <span class="ml-2 text-sm text-luxury-900 dark:text-luxury-100">
                                            {{ $facility->name }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('facilities')" class="mt-2" />
                        </div>

                        {{-- Image Upload --}}
                        <div class="mb-6">
                            <x-input-label for="image" :value="__('Room Image')" />
                            <p class="text-sm text-luxury-600 dark:text-luxury-400 mb-2">
                                Leave empty to keep current image
                            </p>
                            <div class="mt-2">
                                <label for="image"
                                    class="flex flex-col items-center justify-center w-full h-64 border-2 border-luxury-300 border-dashed rounded-lg cursor-pointer bg-luxury-50 dark:bg-luxury-900/20 hover:bg-luxury-100 dark:hover:bg-luxury-900/30 transition-colors">
                                    <div x-show="!imageUrl" class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-12 h-12 mb-4 text-luxury-500 dark:text-luxury-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <p class="mb-2 text-sm text-luxury-500 dark:text-luxury-400">
                                            <span class="font-semibold">Click to upload</span> or drag and drop
                                        </p>
                                        <p class="text-xs text-luxury-500 dark:text-luxury-400">
                                            PNG, JPG or JPEG (MAX. 2MB)
                                        </p>
                                    </div>
                                    <div x-show="imageUrl" x-cloak class="relative w-full h-full">
                                        <img :src="imageUrl" alt="Preview"
                                            class="w-full h-full object-contain rounded-lg">
                                        <button type="button" @click.prevent="clearImage"
                                            class="absolute top-2 right-2 p-2 bg-red-600 text-white rounded-full hover:bg-red-700 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                    <input id="image" name="image" type="file" class="hidden"
                                        accept="image/png,image/jpeg,image/jpg" @change="previewImage" />
                                </label>
                            </div>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('boarding-houses.show', $boardingHouse) }}"
                                class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-luxury-300 dark:border-luxury-600 rounded-md font-semibold text-xs text-luxury-700 dark:text-luxury-300 uppercase tracking-widest hover:bg-luxury-50 dark:hover:bg-gray-600 transition ease-in-out duration-150">
                                Cancel
                            </a>
                            <x-primary-button>
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Update Room
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function imagePreview(initialImage = '') {
                return {
                    imageUrl: initialImage,
                    previewImage(event) {
                        const file = event.target.files[0];
                        if (file) {
                            this.imageUrl = URL.createObjectURL(file);
                        }
                    },
                    clearImage() {
                        this.imageUrl = '';
                        document.getElementById('image').value = '';
                    }
                }
            }
        </script>
    @endpush
</x-app-layout>