<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Boarding House') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumb --}}
            <x-breadcrumb :items="[
        ['label' => 'My Boarding Houses', 'url' => route('boarding-houses.index')],
        ['label' => 'Add Boarding House'],
    ]" />

            {{-- Alert --}}
            <x-alert />

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('boarding-houses.store') }}" method="POST" enctype="multipart/form-data"
                        x-data="imagePreview()">
                        @csrf

                        {{-- Boarding House Name --}}
                        <div class="mb-6">
                            <x-input-label for="name" :value="__('Boarding House Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name')" required autofocus placeholder="e.g. Kos Sejahtera" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- District --}}
                        <div class="mb-6">
                            <x-input-label for="district_id" :value="__('District')" />
                            <select id="district_id" name="district_id" required
                                class="block mt-1 w-full border-luxury-200 dark:border-luxury-700 bg-white/50 dark:bg-gray-900/50 text-luxury-900 dark:text-luxury-100 focus:border-luxury-500 dark:focus:border-luxury-600 focus:ring-luxury-500 dark:focus:ring-luxury-600 rounded-lg shadow-sm transition-colors">
                                <option value="">Select District</option>
                                @foreach ($districts as $district)
                                    <option value="{{ $district->id }}" {{ old('district_id') == $district->id ? 'selected' : '' }}>
                                        {{ $district->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('district_id')" class="mt-2" />
                        </div>

                        {{-- Address --}}
                        <div class="mb-6">
                            <x-input-label for="address" :value="__('Full Address')" />
                            <textarea id="address" name="address" rows="3" required
                                class="block mt-1 w-full border-luxury-200 dark:border-luxury-700 bg-white/50 dark:bg-gray-900/50 text-luxury-900 dark:text-luxury-100 focus:border-luxury-500 dark:focus:border-luxury-600 focus:ring-luxury-500 dark:focus:ring-luxury-600 rounded-lg shadow-sm transition-colors"
                                placeholder="Enter complete address">{{ old('address') }}</textarea>
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>

                        {{-- Type --}}
                        <div class="mb-6" x-data="{ selectedType: '{{ old('type') }}' }">
                            <x-input-label for="type" :value="__('Boarding House Type')" />
                            <div class="mt-2 grid grid-cols-3 gap-4">
                                <label @click="selectedType = 'male'"
                                    :class="selectedType === 'male' ? 'border-luxury-600 bg-luxury-50 dark:bg-luxury-900/20' : 'border-luxury-200 dark:border-luxury-700'"
                                    class="relative flex items-center justify-center p-4 border-2 rounded-lg cursor-pointer transition-all hover:border-luxury-500 dark:hover:border-luxury-400">
                                    <input type="radio" name="type" value="male" :checked="selectedType === 'male'"
                                        class="sr-only" required>
                                    <div class="text-center">
                                        <svg class="w-8 h-8 mx-auto mb-2 text-luxury-600 dark:text-luxury-400"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span
                                            class="text-sm font-medium text-luxury-900 dark:text-luxury-100">Male</span>
                                    </div>
                                </label>

                                <label @click="selectedType = 'female'"
                                    :class="selectedType === 'female' ? 'border-luxury-600 bg-luxury-50 dark:bg-luxury-900/20' : 'border-luxury-200 dark:border-luxury-700'"
                                    class="relative flex items-center justify-center p-4 border-2 rounded-lg cursor-pointer transition-all hover:border-luxury-500 dark:hover:border-luxury-400">
                                    <input type="radio" name="type" value="female" :checked="selectedType === 'female'"
                                        class="sr-only" required>
                                    <div class="text-center">
                                        <svg class="w-8 h-8 mx-auto mb-2 text-luxury-600 dark:text-luxury-400"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span
                                            class="text-sm font-medium text-luxury-900 dark:text-luxury-100">Female</span>
                                    </div>
                                </label>

                                <label @click="selectedType = 'mixed'"
                                    :class="selectedType === 'mixed' ? 'border-luxury-600 bg-luxury-50 dark:bg-luxury-900/20' : 'border-luxury-200 dark:border-luxury-700'"
                                    class="relative flex items-center justify-center p-4 border-2 rounded-lg cursor-pointer transition-all hover:border-luxury-500 dark:hover:border-luxury-400">
                                    <input type="radio" name="type" value="mixed" :checked="selectedType === 'mixed'"
                                        class="sr-only" required>
                                    <div class="text-center">
                                        <svg class="w-8 h-8 mx-auto mb-2 text-luxury-600 dark:text-luxury-400"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <span
                                            class="text-sm font-medium text-luxury-900 dark:text-luxury-100">Mixed</span>
                                    </div>
                                </label>
                            </div>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        {{-- Description --}}
                        <div class="mb-6">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="4" required
                                class="block mt-1 w-full border-luxury-200 dark:border-luxury-700 bg-white/50 dark:bg-gray-900/50 text-luxury-900 dark:text-luxury-100 focus:border-luxury-500 dark:focus:border-luxury-600 focus:ring-luxury-500 dark:focus:ring-luxury-600 rounded-lg shadow-sm transition-colors"
                                placeholder="Describe your boarding house, facilities, rules, etc.">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        {{-- Image Upload --}}
                        <div class="mb-6">
                            <x-input-label for="image" :value="__('Boarding House Image')" />
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
                                        accept="image/png,image/jpeg,image/jpg" @change="previewImage" required />
                                </label>
                            </div>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        {{-- Info Box --}}
                        <div
                            class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 mr-3" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="text-sm text-blue-800 dark:text-blue-200">
                                    <p class="font-medium mb-1">Important Notes:</p>
                                    <ul class="list-disc list-inside space-y-1">
                                        <li>Your boarding house will be pending verification by administrator</li>
                                        <li>Once verified, it will be visible to potential tenants</li>
                                        <li>You can add rooms after creating the boarding house</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('boarding-houses.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-luxury-300 dark:border-luxury-600 rounded-md font-semibold text-xs text-luxury-700 dark:text-luxury-300 uppercase tracking-widest hover:bg-luxury-50 dark:hover:bg-gray-600 transition ease-in-out duration-150">
                                Cancel
                            </a>
                            <x-primary-button>
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Create Boarding House
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function imagePreview() {
                return {
                    imageUrl: null,
                    previewImage(event) {
                        const file = event.target.files[0];
                        if (file) {
                            this.imageUrl = URL.createObjectURL(file);
                        }
                    },
                    clearImage() {
                        this.imageUrl = null;
                        document.getElementById('image').value = '';
                    }
                }
            }
        </script>
    @endpush
</x-app-layout>