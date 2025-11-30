<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Verifikasi Kos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <x-breadcrumb :items="[['label' => 'Verifikasi Kos']]" />

            <x-alert />

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium">Nama Kos</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium">Admin</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($kos as $item)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-900 transition">
                                        <td class="px-6 py-4 text-sm">
                                            {{ ($kos->currentPage() - 1) * $kos->perPage() + $loop->iteration }}
                                        </td>

                                        <td class="px-6 py-4 text-sm font-semibold">
                                            {{ $item->nama_kos }}
                                        </td>

                                        <td class="px-6 py-4 text-sm">
                                            {{ $item->admin->name }}
                                        </td>

                                        <td class="px-6 py-4">
                                            @if ($item->status_verifikasi == 'pending')
                                                <span class="px-3 py-1 text-xs bg-yellow-200 text-yellow-800 rounded-full">
                                                    Pending
                                                </span>
                                            @elseif($item->status_verifikasi == 'diterima')
                                                <span class="px-3 py-1 text-xs bg-green-200 text-green-800 rounded-full">
                                                    Diterima
                                                </span>
                                            @else
                                                <span class="px-3 py-1 text-xs bg-red-200 text-red-800 rounded-full">
                                                    Ditolak
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-end space-x-2">
                                                @if ($item->status_verifikasi == 'pending')
                                                    <form method="POST" action="{{ route('verified.accept', $item->id) }}">
                                                        @csrf
                                                        <button class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white text-xs rounded">
                                                            Terima
                                                        </button>
                                                    </form>

                                                    <form method="POST" action="{{ route('verified.reject', $item->id) }}">
                                                        @csrf
                                                        <button class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-xs rounded">
                                                            Tolak
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-gray-400 text-xs italic">
                                                        Tidak ada aksi
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-10 text-center text-gray-500">
                                            Tidak ada data kos untuk diverifikasi.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($kos->hasPages())
                        <div class="mt-4">
                            {{ $kos->links() }}
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
