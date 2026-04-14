<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('events.show', $event) }}" class="text-gray-500 hover:text-gray-700 text-sm">← Kembali ke
                Event</a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Jenis Tiket — {{ $event->title }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <x-flash-messages />

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr class="text-left text-gray-600 dark:text-gray-300">
                            <th class="px-4 py-3 font-medium">Nama</th>
                            <th class="px-4 py-3 font-medium">Harga</th>
                            <th class="px-4 py-3 font-medium">Terjual</th>
                            <th class="px-4 py-3 font-medium">Kuota</th>
                            <th class="px-4 py-3 font-medium text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ticketTypes as $tt)
                            <tr class="border-t dark:border-gray-700">
                                <td class="px-4 py-3 font-medium text-gray-800 dark:text-gray-200">{{ $tt->name }}
                                </td>
                                <td class="px-4 py-3">Rp {{ number_format($tt->price, 0, ',', '.') }}</td>
                                <td
                                    class="px-4 py-3 {{ $tt->sold_count >= $tt->quota ? 'text-red-600' : 'text-green-600' }}">
                                    {{ $tt->sold_count }}</td>
                                <td class="px-4 py-3">{{ $tt->quota }}</td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('ticket-types.edit', $tt) }}"
                                        class="text-indigo-600 hover:underline text-xs mr-3">Edit</a>
                                    <form action="{{ route('ticket-types.destroy', $tt) }}" method="POST"
                                        class="inline" onsubmit="return confirm('Hapus jenis tiket ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:underline text-xs">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-gray-400">Belum ada jenis tiket.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 text-right">
                <a href="{{ route('events.show', $event) }}" class="text-sm text-indigo-600 hover:underline">Kembali ke
                    halaman event untuk tambah tiket</a>
            </div>
        </div>
    </div>
</x-app-layout>
