<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Approvals') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Wrapper Card --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    {{-- TABLE --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-luxury-200 dark:divide-luxury-700">
                            <thead class="bg-luxury-50 dark:bg-luxury-900">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-luxury-700 dark:text-luxury-300 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-luxury-700 dark:text-luxury-300 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-luxury-700 dark:text-luxury-300 uppercase tracking-wider">
                                        Registered At
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-luxury-700 dark:text-luxury-300 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-luxury-200 dark:divide-luxury-700">
                                @foreach ($users as $user)
                                    <tr class="hover:bg-luxury-50 dark:hover:bg-luxury-900/20 transition-colors">
                                        <td class="px-6 py-4 text-sm text-luxury-900 dark:text-luxury-100">
                                            {{ $user->name }}
                                        </td>

                                        <td class="px-6 py-4 text-sm text-luxury-900 dark:text-luxury-100">
                                            {{ $user->email }}
                                        </td>

                                        <td class="px-6 py-4 text-center text-sm text-luxury-900 dark:text-luxury-100">
                                            {{ $user->created_at->format('Y-m-d H:i:s') }}
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            <div class="flex justify-center space-x-2">

                                                {{-- APPROVE --}}
                                                <form action="{{ route('superadmin.approvals.approve', $user) }}" method="POST">
                                                    @csrf
                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded-md transition-colors"
                                                    >
                                                        Approve
                                                    </button>
                                                </form>

                                                {{-- REJECT --}}
                                                <form action="{{ route('superadmin.approvals.reject', $user) }}" method="POST">
                                                    @csrf
                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-md transition-colors"
                                                    >
                                                        Reject
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
