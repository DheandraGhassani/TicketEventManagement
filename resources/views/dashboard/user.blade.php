<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            My Tickets
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                @forelse($myTickets as $ticket)
                <div class="border-b py-4">
                    <p class="font-semibold">{{ $ticket->event->title ?? '-' }}</p>
                    <p class="text-sm text-gray-500">{{ $ticket->ticket_code }}</p>
                    <span class="text-xs px-2 py-1 rounded bg-green-100 text-green-800">{{ $ticket->status }}</span>
                </div>
                @empty
                <p class="text-gray-500">Belum ada tiket.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
