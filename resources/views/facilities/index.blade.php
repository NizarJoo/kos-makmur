<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Kelola Fasilitas') }}
            </h2>
            <a href="{{ route('facilities.create') }}"
                class="inline-flex items-center px-4 py-2 bg-luxury-600 dark:bg-luxury-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-luxury-700 dark:hover:bg-luxury-600 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Fasilitas
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumb --}}
            <x-breadcrumb :items="[['label' => 'Manage Facilities']]" />

            {{-- Alert --}}
            <x-alert />

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    {{-- Table --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-luxury-200 dark:divide-luxury-700">
                            <thead class="bg-luxury-50 dark:bg-luxury-900">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-luxury-700 dark:text-luxury-300 uppercase tracking-wider">
                                        No
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-luxury-700 dark:text-luxury-300 uppercase tracking-wider">
                                        Facility Name
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-luxury-700 dark:text-luxury-300 uppercase tracking-wider">
                                        Icon
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-luxury-700 dark:text-luxury-300 uppercase tracking-wider">
                                        Used By
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-medium text-luxury-700 dark:text-luxury-300 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-luxury-200 dark:divide-luxury-700">
                                @forelse ($facilities as $facility)
                                    <tr class="hover:bg-luxury-50 dark:hover:bg-luxury-900/20 transition-colors">
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-luxury-900 dark:text-luxury-100">
                                            {{ ($facilities->currentPage() - 1) * $facilities->perPage() + $loop->iteration }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-luxury-900 dark:text-luxury-100">
                                                {{ $facility->name }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($facility->icon)
                                                <span
                                                    class="inline-flex items-center text-sm text-luxury-600 dark:text-luxury-400">
                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                                    </svg>
                                                    {{ $facility->icon }}
                                                </span>
                                            @else
                                                <span class="text-sm text-luxury-400 dark:text-luxury-600">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-luxury-100 text-luxury-800 dark:bg-luxury-900 dark:text-luxury-200">
                                                {{ $facility->rooms_count }} rooms
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-2">
                                                {{-- Edit Button --}}
                                                <a href="{{ route('facilities.edit', $facility) }}"
                                                    class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-md transition-colors">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    Edit
                                                </a>

                                                {{-- Delete Button --}}
                                                <button type="button" onclick="confirmDelete({{ $facility->id }})"
                                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md transition-colors"
                                                    :class="@js($facility->rooms_count > 0) ? 'bg-red-300 cursor-not-allowed opacity-50' : 'bg-red-600 hover:bg-red-700 text-white'"
                                                    @if ($facility->rooms_count > 0) disabled @endif>
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Delete
                                                </button>

                                                {{-- Hidden Delete Form --}}
                                                <form id="delete-form-{{ $facility->id }}"
                                                    action="{{ route('facilities.destroy', $facility) }}" method="POST"
                                                    class="hidden">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <svg class="w-16 h-16 text-luxury-400 dark:text-luxury-600 mb-4" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                                </svg>
                                                <p class="text-luxury-600 dark:text-luxury-400 text-lg font-medium">
                                                    No facilities found
                                                </p>
                                                <p class="text-luxury-500 dark:text-luxury-500 text-sm mt-1">
                                                    Add your first facility
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if ($facilities->hasPages())
                        <div class="mt-6">
                            {{ $facilities->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function confirmDelete(id) {
                if (confirm('Are you sure you want to delete this facility?')) {
                    document.getElementById('delete-form-' + id).submit();
                }
            }
        </script>
    @endpush
</x-app-layout>