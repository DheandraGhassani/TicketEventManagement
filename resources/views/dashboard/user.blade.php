<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tiket Saya</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <x-flash-messages />

            {{-- Pending Orders --}}
            @if ($pendingOrders->isNotEmpty())
                <div class="mb-6">
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">Menunggu Pembayaran</h3>
                    @foreach ($pendingOrders as $order)
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-3 flex items-center justify-between gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $order->event->title ?? '-' }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $order->order_number }} &bull;
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                <p class="text-xs text-yellow-600 mt-0.5">
                                    Berlaku hingga {{ $order->expired_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                            <a href="{{ route('orders.show', $order->id) }}"
                                class="shrink-0 px-4 py-2 bg-yellow-500 text-white text-xs font-medium rounded-lg hover:bg-yellow-600 transition">
                                Bayar
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- My Tickets --}}
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Tiket Aktif</h3>

            @forelse ($myTickets as $ticket)
                <div class="bg-white rounded-lg shadow overflow-hidden mb-4">
                    <div class="bg-indigo-600 px-5 py-3 flex justify-between items-center">
                        <span class="text-white font-semibold text-sm">
                            {{ $ticket->orderItem->ticketType->name ?? '-' }}
                        </span>
                        <span
                            class="text-xs px-2 py-0.5 rounded-full font-medium
                            {{ $ticket->status === 'valid' ? 'bg-green-400 text-white' : 'bg-gray-300 text-gray-700' }}">
                            {{ $ticket->status === 'valid' ? 'Valid' : 'Sudah Discan' }}
                        </span>
                    </div>

                    <div class="p-5 flex flex-col sm:flex-row gap-5 items-center">
                        <div class="shrink-0 bg-white p-2 rounded border border-gray-200">
                            {!! $ticket->qr_code_data !!}
                        </div>

                        <div class="text-center sm:text-left">
                            <p class="text-xs text-gray-500 mb-1">Kode Tiket</p>
                            <p class="text-xl font-bold tracking-widest text-gray-800 mb-3">
                                {{ $ticket->ticket_code }}
                            </p>
                            <p class="text-sm font-medium text-gray-800">{{ $ticket->event->title ?? '-' }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">
                                {{ $ticket->event->start_date->format('d M Y, H:i') }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $ticket->event->venue_name }}, {{ $ticket->event->city }}
                            </p>
                            @if ($ticket->status === 'scanned' && $ticket->scanned_at)
                                <p class="text-xs text-gray-400 mt-2">
                                    Discan: {{ $ticket->scanned_at->format('d M Y, H:i') }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow p-12 text-center text-gray-400">
                    <p class="mb-2">Belum ada tiket.</p>
                    <a href="{{ route('events.index') }}" class="text-indigo-600 text-sm hover:underline">Cari event
                        sekarang</a>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>
