<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Pembayaran Berhasil</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-5">

            <x-flash-messages />

            {{-- Header sukses --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-center">
                <div class="text-5xl mb-3">🎉</div>
                <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-1">Pembelian Berhasil!</h3>
                <p class="text-sm text-gray-500">E-ticket sudah dikirim ke email Anda.</p>
            </div>

            {{-- Ringkasan Order --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-4">Detail Pesanan</h4>
                <div class="grid grid-cols-2 gap-3 text-sm mb-4">
                    <div>
                        <p class="text-gray-500 text-xs">No. Order</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $order->order_number }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Status</p>
                        <span
                            class="text-xs px-2 py-0.5 rounded-full bg-green-100 text-green-700 font-medium">Lunas</span>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Event</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $order->event->title }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Tanggal</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">
                            {{ $order->event->start_date->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Lokasi</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $order->event->venue_name }},
                            {{ $order->event->city }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Total Bayar</p>
                        <p class="text-lg font-bold text-indigo-600">Rp
                            {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            {{-- E-Tickets --}}
            @foreach ($order->orderItems as $item)
                @foreach ($item->eTickets as $ticket)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                        <div class="bg-indigo-600 px-5 py-3 flex justify-between items-center">
                            <span class="text-white font-semibold text-sm">{{ $item->ticketType->name }}</span>
                            <span class="text-indigo-200 text-xs">{{ $order->event->title }}</span>
                        </div>
                        <div class="p-5 flex flex-col sm:flex-row gap-5 items-center">
                            <div class="shrink-0 bg-white p-2 rounded border border-gray-200">
                                {!! $ticket->qr_code_data !!}
                            </div>
                            <div class="text-center sm:text-left">
                                <p class="text-xs text-gray-500 mb-1">Kode Tiket</p>
                                <p class="text-2xl font-bold tracking-widest text-gray-800 dark:text-gray-100">
                                    {{ $ticket->ticket_code }}</p>
                                <p class="text-xs text-gray-400 mt-2">
                                    {{ $order->event->start_date->format('d M Y, H:i') }}</p>
                                <p class="text-xs text-gray-400">{{ $order->event->venue_name }},
                                    {{ $order->event->city }}</p>
                                <span
                                    class="inline-block mt-2 text-xs px-2 py-0.5 rounded-full
                                    {{ $ticket->status === 'valid' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                    {{ ucfirst($ticket->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach

            <div class="flex justify-center gap-4 pb-4">
                <a href="{{ route('dashboard') }}"
                    class="px-5 py-2 border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50">
                    Ke Dashboard
                </a>
                <a href="{{ route('events.index') }}"
                    class="px-5 py-2 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700">
                    Lihat Event Lainnya
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
