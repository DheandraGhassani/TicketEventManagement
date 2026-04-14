<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Waiting List Saya</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <x-flash-messages />

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                @forelse($waitingLists as $wl)
                    <div
                        class="border-b dark:border-gray-700 last:border-b-0 px-5 py-4 flex justify-between items-center">
                        <div>
                            <p class="font-medium text-sm text-gray-800 dark:text-gray-200">
                                {{ $wl->event->title ?? '-' }}</p>
                            <p class="text-xs text-gray-500">
                                {{ $wl->event->start_date->format('d M Y') ?? '-' }} &bull; {{ $wl->event->city ?? '' }}
                            </p>
                            <p class="text-xs text-gray-400">Didaftarkan: {{ $wl->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <form action="{{ route('waiting-list.leave', $wl->event) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Keluar dari waiting list ini?')"
                                class="text-xs text-red-600 border border-red-300 px-3 py-1.5 rounded hover:bg-red-50">
                                Keluar
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="px-5 py-12 text-center text-gray-400 text-sm">
                        Kamu belum terdaftar di waiting list manapun.
                        <a href="{{ route('events.index') }}" class="text-indigo-600 underline ml-1">Cari event</a>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
