<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profil & Akun') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div x-data="{ tab: 'biodata' }" class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                {{-- Tab Headers --}}
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="-mb-px flex justify-center space-x-8" aria-label="Tabs">
                        <button @click="tab = 'biodata'"
                                :class="tab === 'biodata' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Biodata
                        </button>
                        <button @click="tab = 'akun'"
                                :class="tab === 'akun' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Akun
                        </button>
                        <button @click="tab = 'password'"
                                :class="tab === 'password' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Kata Sandi
                        </button>
                        <button @click="tab = 'hapus'"
                                :class="tab === 'hapus' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Hapus Akun
                        </button>
                    </nav>
                </div>

                {{-- Tab Content --}}
                <div class="p-6 space-y-6">
                    {{-- Biodata Profile Form --}}
                    <div x-show="tab === 'biodata'" class="max-w-xl mx-auto">
                        <section>
                            <header>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Biodata Profil') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __("Perbarui informasi biodata dan foto profil Anda.") }}
                                </p>
                            </header>
                        
                            <form method="POST" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                        
                                <div class="flex flex-col items-center mb-6">
                                    @if($profile && $profile->profile_picture)
                                        <img src="{{ asset('storage/' . $profile->profile_picture) }}" alt="Profile Picture" class="w-32 h-32 rounded-full object-cover shadow-md">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=128" class="w-32 h-32 rounded-full shadow-md" alt="Default Avatar">
                                    @endif
                                    <input type="file" name="profile_picture" id="profile_picture" class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                                </div>
                                
                                <div>
                                    <x-input-label for="full_name" :value="__('Nama Lengkap')" />
                                    <x-text-input id="full_name" name="full_name" type="text" class="mt-1 block w-full" :value="old('full_name', $profile->full_name ?? '')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('full_name')" />
                                </div>
                        
                                <div>
                                    <x-input-label for="phone" :value="__('Nomor Telepon')" />
                                    <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $profile->phone ?? '')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                                </div>
                        
                                <div>
                                    <x-input-label for="address" :value="__('Alamat')" />
                                    <textarea id="address" name="address" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" rows="3" required>{{ old('address', $profile->address ?? '') }}</textarea>
                                    <x-input-error class="mt-2" :messages="$errors->get('address')" />
                                </div>
                        
                                <div>
                                    <x-input-label for="birth_date" :value="__('Tanggal Lahir')" />
                                    <x-text-input id="birth_date" name="birth_date" type="date" class="mt-1 block w-full" :value="old('birth_date', $profile->birth_date ?? '')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('birth_date')" />
                                </div>
                        
                                <div>
                                    <x-input-label for="gender" :value="__('Jenis Kelamin')" />
                                    <select id="gender" name="gender" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="male" {{ old('gender', $profile->gender ?? '') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="female" {{ old('gender', $profile->gender ?? '') == 'female' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('gender')" />
                                </div>
                        
                                <div class="flex items-center gap-4">
                                    <x-primary-button>{{ __('Simpan Biodata') }}</x-primary-button>
                                </div>
                            </form>
                        </section>
                    </div>

                    {{-- Account Information Form --}}
                    <div x-show="tab === 'akun'" class="max-w-xl mx-auto">
                        <section>
                            <header>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Informasi Akun') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __("Perbarui alamat email akun Anda.") }}
                                </p>
                            </header>
                        
                            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                                @csrf
                            </form>
                        
                            <form method="post" action="{{ route('account.update') }}" class="mt-6 space-y-6">
                                @csrf
                                @method('patch')
                        
                                <div>
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        
                                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                        <div>
                                            <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                                                {{ __('Alamat email Anda belum diverifikasi.') }}
                        
                                                <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                                    {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                                                </button>
                                            </p>
                        
                                            @if (session('status') === 'verification-link-sent')
                                                <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                                    {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                                                </p>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                        
                                <div class="flex items-center gap-4">
                                    <x-primary-button>{{ __('Simpan Akun') }}</x-primary-button>
                        
                                    @if (session('status') === 'profile-updated')
                                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 dark:text-gray-400">{{ __('Tersimpan.') }}</p>
                                    @endif
                                </div>
                            </form>
                        </section>
                    </div>

                    {{-- Update Password Form --}}
                    <div x-show="tab === 'password'" class="max-w-xl mx-auto">
                        <section>
                            <header>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Perbarui Kata Sandi') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.') }}
                                </p>
                            </header>
                        
                            <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                                @csrf
                                @method('put')
                        
                                <div>
                                    <x-input-label for="update_password_current_password" :value="__('Kata Sandi Saat Ini')" />
                                    <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
                                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                                </div>
                        
                                <div>
                                    <x-input-label for="update_password_password" :value="__('Kata Sandi Baru')" />
                                    <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                                </div>
                        
                                <div>
                                    <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Kata Sandi')" />
                                    <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                                </div>
                        
                                <div class="flex items-center gap-4">
                                    <x-primary-button>{{ __('Simpan Kata Sandi') }}</x-primary-button>
                        
                                    @if (session('status') === 'password-updated')
                                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 dark:text-gray-400">{{ __('Tersimpan.') }}</p>
                                    @endif
                                </div>
                            </form>
                        </section>
                    </div>

                    {{-- Delete User Form --}}
                    <div x-show="tab === 'hapus'" class="max-w-xl mx-auto">
                        <section class="space-y-6">
                            <header>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Hapus Akun') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen.') }}
                                </p>
                            </header>
                        
                            <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">{{ __('Hapus Akun') }}</x-danger-button>
                        
                            <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                                <form method="post" action="{{ route('account.destroy') }}" class="p-6">
                                    @csrf
                                    @method('delete')
                        
                                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                        {{ __('Apakah Anda yakin ingin menghapus akun Anda?') }}
                                    </h2>
                        
                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                        {{ __('Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Masukkan kata sandi Anda untuk mengonfirmasi.') }}
                                    </p>
                        
                                    <div class="mt-6">
                                        <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                        
                                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4" placeholder="{{ __('Password') }}" />
                        
                                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                                    </div>
                        
                                    <div class="mt-6 flex justify-end">
                                        <x-secondary-button x-on:click="$dispatch('close')">
                                            {{ __('Batal') }}
                                        </x-secondary-button>
                        
                                        <x-danger-button class="ms-3">
                                            {{ __('Hapus Akun') }}
                                        </x-danger-button>
                                    </div>
                                </form>
                            </x-modal>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
