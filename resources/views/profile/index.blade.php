<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Biodata Profile') }}
            </h2>
            <a href="{{ route('account.edit') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                {{ __('Atur Akun') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="space-y-6">
                            <!-- Foto Profil -->
                            <div class="flex flex-col items-center mb-6">
                                @if($profile && $profile->profile_picture)
                                    <img src="{{ asset('storage/' . $profile->profile_picture) }}" 
                                        alt="Profile Picture" 
                                        class="w-32 h-32 rounded-full object-cover shadow-md">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($profile->full_name ?? 'User') }}&size=128" 
                                        class="w-32 h-32 rounded-full shadow-md" 
                                        alt="Default Avatar">
                                @endif

                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                                    Foto Profil
                                </p>
                            </div>
                            
                            <!-- Nama Lengkap -->
                            <div>
                                <x-input-label for="full_name" :value="__('Nama Lengkap')" />
                                <x-text-input id="full_name" name="full_name" type="text" 
                                    class="mt-1 block w-full" 
                                    :value="old('full_name', $profile->full_name ?? '')" 
                                    required />
                                <x-input-error class="mt-2" :messages="$errors->get('full_name')" />
                            </div>

                            <!-- Nomor Telepon -->
                            <div>
                                <x-input-label for="phone" :value="__('Nomor Telepon')" />
                                <x-text-input id="phone" name="phone" type="text" 
                                    class="mt-1 block w-full" 
                                    :value="old('phone', $profile->phone ?? '')" 
                                    required />
                                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                            </div>

                            <!-- Alamat -->
                            <div>
                                <x-input-label for="address" :value="__('Alamat')" />
                                <textarea id="address" name="address" 
                                    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" 
                                    rows="3" required>{{ old('address', $profile->address ?? '') }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('address')" />
                            </div>

                            <!-- Tanggal Lahir -->
                            <div>
                                <x-input-label for="birth_date" :value="__('Tanggal Lahir')" />
                                <x-text-input id="birth_date" name="birth_date" type="date" 
                                    class="mt-1 block w-full" 
                                    :value="old('birth_date', $profile->birth_date ?? '')" 
                                    required />
                                <x-input-error class="mt-2" :messages="$errors->get('birth_date')" />
                            </div>

                            <!-- Jenis Kelamin -->
                            <div>
                                <x-input-label for="gender" :value="__('Jenis Kelamin')" />
                                <select id="gender" name="gender" 
                                    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" 
                                    required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="male" {{ old('gender', $profile->gender ?? '') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="female" {{ old('gender', $profile->gender ?? '') == 'female' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('gender')" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>