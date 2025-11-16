<x-app-layout>
    <section class="max-w-xl mx-auto mt-8">
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Lengkapi Profil Anda
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Isi informasi dasar anda sebelum melanjutkan ke dashboard.
            </p>
        </header>

        @if(session('error'))
            <p class="mt-4 text-sm text-red-600 dark:text-red-400">
                {{ session('error') }}
            </p>
        @endif

        <form method="POST" action="{{ route('profile.store') }}" enctype="multipart/form-data"
              class="mt-6 space-y-6">
            @csrf

            {{-- Phone --}}
            <div>
                <x-input-label for="phone" :value="__('Telepon')" />
                <x-text-input id="phone" name="phone" type="text"
                              class="mt-1 block w-full"
                              value="{{ old('phone') }}" required placeholder="08xx..." />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>

            {{-- Address --}}
            <div>
                <x-input-label for="address" :value="__('Alamat')" />
                <textarea id="address" name="address" rows="3"
                          class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900
                                 dark:text-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                          required>{{ old('address') }}</textarea>
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
            </div>

            {{-- Profile Picture --}}
            <div>
                <x-input-label for="profile_picture" :value="__('Foto Profil (opsional)')" />
                <input id="profile_picture" name="profile_picture" type="file"
                       accept="image/*"
                       class="mt-1 block w-full text-sm text-gray-700 dark:text-gray-300
                              file:bg-gray-100 dark:file:bg-gray-800 file:border file:px-3 file:py-2
                              file:rounded-md file:text-gray-700 dark:file:text-gray-300">
                <x-input-error :messages="$errors->get('profile_picture')" class="mt-2" />
            </div>

            {{-- Submit --}}
            <div class="flex items-center gap-4">
                <x-primary-button>
                    Simpan Profil
                </x-primary-button>
            </div>
        </form>
    </section>
</x-app-layout>
