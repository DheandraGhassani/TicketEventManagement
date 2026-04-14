<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Daftar Event
            </h2>
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('events.create') }}"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">
                    + Buat Event
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <x-flash-messages />

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($events as $event)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                        @if ($event->banner_url)
                            <img src="{{ Storage::url($event->banner_url) }}" alt="Banner"
                                class="w-full h-40 object-contain">
                        @else
                            <div
                                class="w-full h-40 bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-400 text-sm">
                                No Banner</div>
                        @endif
                        <div class="p-4">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-semibold text-gray-800 dark:text-gray-200 text-sm leading-tight">
                                    {{ $event->title }}</h3>
                                <span
                                    class="text-xs px-2 py-0.5 rounded-full ml-2 shrink-0
                                    @if ($event->status === 'published') bg-green-100 text-green-700
                                    @elseif($event->status === 'draft') bg-yellow-100 text-yellow-700
                                    @elseif($event->status === 'cancelled') bg-red-100 text-red-700
                                    @else bg-gray-100 text-gray-600 @endif">
                                    {{ ucfirst($event->status) }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 mb-1">{{ $event->category->name ?? '-' }}</p>
                            <p class="text-xs text-gray-500">{{ $event->start_date->format('d M Y, H:i') }}</p>
                            <p class="text-xs text-gray-500 mb-3">{{ $event->city }}</p>

                            <div class="flex gap-2">
                                <a href="{{ route('events.show', $event) }}"
                                    class="flex-1 text-center bg-indigo-50 text-indigo-700 border border-indigo-200 text-xs py-1.5 rounded hover:bg-indigo-100">
                                    Lihat Detail
                                </a>
                                @if (auth()->user()->role === 'admin')
                                    <a href="{{ route('events.edit', $event) }}"
                                        class="text-center bg-gray-50 text-gray-700 border border-gray-200 text-xs px-3 py-1.5 rounded hover:bg-gray-100">
                                        Edit
                                    </a>
                                    <form action="{{ route('events.destroy', $event) }}" method="POST"
                                        onsubmit="return confirm('Hapus event ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-50 text-red-700 border border-red-200 text-xs px-3 py-1.5 rounded hover:bg-red-100">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-16 text-gray-400">
                        Belum ada event.
                        @if (auth()->user()->role === 'admin')
                            <a href="{{ route('events.create') }}" class="text-indigo-600 underline ml-1">Buat
                                sekarang</a>
                        @endif
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $events->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
