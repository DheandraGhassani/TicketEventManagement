<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Selesaikan Pembayaran</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-5">

            <x-flash-messages />

            {{-- Order Summary --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="font-semibold text-gray-800 dark:text-gray-200">Ringkasan Pesanan</h3>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $order->order_number }}</p>
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full bg-yellow-100 text-yellow-700 font-medium">
                        Menunggu Pembayaran
                    </span>
                </div>

                <div class="mb-4 pb-4 border-b dark:border-gray-700">
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $order->event->title }}</p>
                    <p class="text-xs text-gray-500">{{ $order->event->start_date->format('d M Y, H:i') }} &bull;
                        {{ $order->event->city }}</p>
                </div>

                <div class="space-y-2 mb-4">
                    @foreach ($order->orderItems as $item)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-700 dark:text-gray-300">{{ $item->ticketType->name }} &times;
                                {{ $item->quantity }}</span>
                            <span class="font-medium text-gray-800 dark:text-gray-200">Rp
                                {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="border-t dark:border-gray-700 pt-3 flex justify-between items-center">
                    <span class="font-semibold text-gray-700 dark:text-gray-300">Total</span>
                    <span class="text-xl font-bold text-indigo-600">Rp
                        {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>

                <p class="text-xs text-gray-400 mt-2">Berlaku hingga: {{ $order->expired_at->format('d M Y, H:i') }}</p>
            </div>

            {{-- Payment Simulation --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4">Metode Pembayaran (Simulasi)</h3>

                <form action="{{ route('payments.simulate', $order) }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="space-y-2">
                        @foreach (['transfer_bank' => 'Transfer Bank', 'qris' => 'QRIS', 'virtual_account' => 'Virtual Account'] as $val => $label)
                            <label
                                class="flex items-center gap-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700
                                          dark:border-gray-600 has-[:checked]:border-indigo-400 has-[:checked]:bg-indigo-50 dark:has-[:checked]:bg-indigo-900/30">
                                <input type="radio" name="payment_method" value="{{ $val }}"
                                    {{ $val === 'transfer_bank' ? 'checked' : '' }} class="text-indigo-600">
                                <span class="text-sm text-gray-700 dark:text-gray-300">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>

                    <div
                        class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 rounded-md px-4 py-3 text-xs text-yellow-700 dark:text-yellow-400">
                        Ini adalah simulasi pembayaran. Klik "Bayar Sekarang" untuk mensimulasikan pembayaran berhasil.
                    </div>

                    <div class="flex gap-3">
                        <button type="submit"
                            class="flex-1 bg-indigo-600 text-white py-2.5 rounded-md text-sm font-medium hover:bg-indigo-700">
                            Bayar Sekarang
                        </button>
                    </div>
                </form>

                <form action="{{ route('payments.cancel', $order) }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit"
                        onclick="return confirm('Yakin batalkan pesanan ini? Kuota tiket akan dikembalikan.')"
                        class="w-full border border-red-300 text-red-600 py-2 rounded-md text-sm hover:bg-red-50">
                        Batalkan Pesanan
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
