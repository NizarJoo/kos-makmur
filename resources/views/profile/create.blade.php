<x-guest-layout>
    <div
        class="w-full sm:max-w-md mt-6 px-10 py-10 bg-white/95 dark:bg-gray-800/95 backdrop-blur-2xl shadow-[0_0_40px_rgba(164,126,98,0.12)] dark:shadow-[0_0_40px_rgba(0,0,0,0.25)] rounded-2xl z-10 border border-luxury-200/50 dark:border-luxury-800/50">

        <div class="mb-10 text-center">
            <h2
                class="font-serif text-4xl font-bold bg-gradient-to-r from-luxury-800 to-accent-800 dark:from-luxury-400 dark:to-accent-400 bg-clip-text text-transparent">
                Lengkapi Profil
            </h2>
            <div class="h-1 w-20 bg-gradient-to-r from-luxury-600 to-accent-600 mx-auto mt-4 rounded-full"></div>
            <p class="text-sm text-luxury-600/70 dark:text-luxury-400/70 mt-4">
                Isi informasi dasar Anda sebelum melanjutkan
            </p>
        </div>

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                <p class="text-sm text-red-600 dark:text-red-400">
                    {{ session('error') }}
                </p>
            </div>
        @endif

        <form method="POST" action="{{ route('profile.store') }}" enctype="multipart/form-data" class="space-y-7">
            @csrf

            <!-- Nama Lengkap -->
            <div class="relative">
                <x-input-label for="full_name" :value="__('Nama Lengkap')"
                    class="absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-sm" />
                
                <x-text-input id="full_name" class="block w-full p-4 border-2"
                    type="text" name="full_name" required :value="old('full_name')"
                    placeholder="Nama lengkap Anda..." />

                <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
            </div>

            <!-- Nomor Telepon -->
            <div class="relative">
                <x-input-label for="phone" :value="__('Nomor Telepon')"
                    class="absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-sm" />

                <x-text-input id="phone" class="block w-full p-4 border-2"
                    type="text" name="phone" required :value="old('phone')"
                    placeholder="08xx..." />

                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>

            <!-- Alamat -->
            <div class="relative">
                <x-input-label for="address" :value="__('Alamat Lengkap')"
                    class="absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-sm" />

                <textarea id="address" name="address" rows="4" required
                    class="block w-full p-4 border-2 border-luxury-300 dark:border-luxury-600 rounded-lg
                        bg-white dark:bg-gray-900 text-luxury-900 dark:text-luxury-100
                        focus:border-luxury-500 dark:focus:border-luxury-500 focus:ring-2 focus:ring-luxury-500/20"
                    placeholder="Masukkan alamat lengkap Anda">{{ old('address') }}</textarea>

                <x-input-error :messages="$errors->get('address')" class="mt-2" />
            </div>

            <!-- Tanggal Lahir -->
            <div class="relative">
                <x-input-label for="birth_date" :value="__('Tanggal Lahir')"
                    class="absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-sm" />

                <x-text-input id="birth_date" class="block w-full p-4 border-2"
                    type="date" name="birth_date" required :value="old('birth_date')" />

                <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
            </div>

            <!-- Jenis Kelamin -->
            <div class="relative">
                <x-input-label for="gender" :value="__('Jenis Kelamin')"
                    class="absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-sm" />

                <select id="gender" name="gender" required
                    class="block w-full p-4 border-2 rounded-lg bg-white dark:bg-gray-900">
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Lainnya</option>
                </select>

                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
            </div>

            <!-- Foto Profil -->
            <div>
                <x-input-label for="profile_picture" :value="__('Foto Profil (Opsional)')" class="mb-2 block text-sm" />

                <div class="mt-1 flex items-center gap-4">
                    <div class="flex-shrink-0">
                        <div class="h-16 w-16 rounded-full bg-luxury-100 dark:bg-luxury-800 flex items-center justify-center overflow-hidden">
                            <svg class="h-8 w-8 text-luxury-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </div>
                    </div>

                    <label for="profile_picture" class="cursor-pointer flex-1">
                        <div class="p-4 border-2 border-dashed border-luxury-300 dark:border-luxury-600 rounded-lg text-center">
                            <svg class="mx-auto h-8 w-8 text-luxury-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <p class="mt-1 text-sm">Klik untuk upload atau drag & drop</p>
                            <p class="text-xs text-luxury-500">PNG, JPG, JPEG (Max 2MB)</p>
                        </div>
                    </label>

                    <input id="profile_picture" name="profile_picture" type="file" class="sr-only" accept="image/*">
                </div>

                <x-input-error :messages="$errors->get('profile_picture')" class="mt-2" />
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <x-primary-button
                    class="w-full justify-center p-4 text-base bg-gradient-to-r from-luxury-600 to-accent-600 hover:from-luxury-700 hover:to-accent-700">
                    {{ __('Lanjutkan ke Dashboard') }}
                </x-primary-button>
            </div>

        </form>
    </div>
</x-guest-layout>
