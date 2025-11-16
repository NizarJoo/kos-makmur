{{-- resources/views/components/alert.blade.php --}}

@if (session('success'))
    <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-init="setTimeout(() => show = false, 5000)"
        class="mb-6 rounded-lg border border-green-200 bg-green-50 dark:bg-green-900/20 dark:border-green-800 p-4 shadow-luxury">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-600 dark:text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="ml-3 flex-1">
                <p class="text-sm font-medium text-green-800 dark:text-green-200">
                    {{ session('success') }}
                </p>
            </div>
            <div class="ml-auto pl-3">
                <button @click="show = false" type="button"
                    class="inline-flex rounded-md text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    <span class="sr-only">Dismiss</span>
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
@endif

@if (session('error'))
    <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-init="setTimeout(() => show = false, 5000)"
        class="mb-6 rounded-lg border border-red-200 bg-red-50 dark:bg-red-900/20 dark:border-red-800 p-4 shadow-luxury">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-600 dark:text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="ml-3 flex-1">
                <p class="text-sm font-medium text-red-800 dark:text-red-200">
                    {{ session('error') }}
                </p>
            </div>
            <div class="ml-auto pl-3">
                <button @click="show = false" type="button"
                    class="inline-flex rounded-md text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    <span class="sr-only">Dismiss</span>
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
@endif

@if (session('warning'))
    <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-init="setTimeout(() => show = false, 5000)"
        class="mb-6 rounded-lg border border-yellow-200 bg-yellow-50 dark:bg-yellow-900/20 dark:border-yellow-800 p-4 shadow-luxury">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-600 dark:text-yellow-400" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div class="ml-3 flex-1">
                <p class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                    {{ session('warning') }}
                </p>
            </div>
            <div class="ml-auto pl-3">
                <button @click="show = false" type="button"
                    class="inline-flex rounded-md text-yellow-600 dark:text-yellow-400 hover:text-yellow-800 dark:hover:text-yellow-200 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    <span class="sr-only">Dismiss</span>
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
@endif

@if ($errors->any())
    <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="mb-6 rounded-lg border border-red-200 bg-red-50 dark:bg-red-900/20 dark:border-red-800 p-4 shadow-luxury">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-600 dark:text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="ml-3 flex-1">
                <h3 class="text-sm font-medium text-red-800 dark:text-red-200 mb-2">
                    Terdapat {{ $errors->count() }} kesalahan:
                </h3>
                <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-300 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="ml-auto pl-3">
                <button @click="show = false" type="button"
                    class="inline-flex rounded-md text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    <span class="sr-only">Dismiss</span>
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
@endif