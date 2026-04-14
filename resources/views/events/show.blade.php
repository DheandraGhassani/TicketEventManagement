<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('events.index') }}" class="text-gray-500 hover:text-gray-700 text-sm">← Semua Event</a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight truncate">{{ $event->title }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <x-flash-messages />

            {{-- Banner & Info Event --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                @if ($event->banner_url)
                    <img src="{{ Storage::url($event->banner_url) }}" alt="Banner" class="w-full h-56 object-cover">
                @endif
                <div class="p-6">
                    <div class="flex flex-wrap justify-between items-start gap-3 mb-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $event->title }}</h1>
                            <p class="text-sm text-gray-500 mt-1">{{ $event->category->name ?? '-' }}</p>
                        </div>
                        <div class="flex gap-2 items-center">
                            <span
                                class="text-xs px-3 py-1 rounded-full font-medium
                                @if ($event->status === 'published') bg-green-100 text-green-700
                                @elseif($event->status === 'draft') bg-yellow-100 text-yellow-700
                                @elseif($event->status === 'cancelled') bg-red-100 text-red-700
                                @else bg-gray-100 text-gray-600 @endif">
                                {{ ucfirst($event->status) }}
                            </span>
                            @if (in_array(auth()->user()->role, ['admin', 'organizer']))
                                <a href="{{ route('events.edit', $event) }}"
                                    class="text-xs bg-indigo-50 text-indigo-700 border border-indigo-200 px-3 py-1 rounded hover:bg-indigo-100">Edit</a>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-sm text-gray-600 dark:text-gray-400 mb-4">
                        <div>
                            <span class="font-medium text-gray-700 dark:text-gray-300">Tanggal</span>
                            <p>{{ $event->start_date->format('d M Y, H:i') }}</p>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700 dark:text-gray-300">Venue</span>
                            <p>{{ $event->venue_name }}</p>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700 dark:text-gray-300">Kota</span>
                            <p>{{ $event->city }}</p>
                        </div>
                    </div>

                    @if ($event->address)
                        <p class="text-sm text-gray-500 mb-4">{{ $event->address }}</p>
                    @endif

                    @if ($event->description)
                        <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">{{ $event->description }}
                        </p>
                    @endif
                </div>
            </div>

            {{-- ============================================================ --}}
            {{-- ADMIN / ORGANIZER: Manajemen Jenis Tiket --}}
            {{-- ============================================================ --}}
            @if (in_array(auth()->user()->role, ['admin', 'organizer']))
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6" x-data="{ showForm: false }">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200">Jenis Tiket</h3>
                        <button @click="showForm = !showForm"
                            class="text-sm bg-indigo-600 text-white px-3 py-1.5 rounded hover:bg-indigo-700">
                            + Tambah Tiket
                        </button>
                    </div>

                    {{-- Form Tambah Jenis Tiket --}}
                    <div x-show="showForm" x-transition
                        class="border border-indigo-100 rounded-lg p-4 mb-4 bg-indigo-50 dark:bg-gray-700">
                        <h4 class="font-medium text-sm text-gray-700 dark:text-gray-200 mb-3">Tambah Jenis Tiket Baru
                        </h4>
                        <form action="{{ route('ticket-types.store', $event) }}" method="POST"
                            class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @csrf
                            <div>
                                <label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Nama
                                    *</label>
                                <input type="text" name="name" placeholder="cth. VIP, Regular" required
                                    class="w-full border border-gray-300 dark:border-gray-600 rounded px-2.5 py-1.5 text-sm dark:bg-gray-800 dark:text-gray-200">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Harga
                                    (Rp) *</label>
                                <input type="number" name="price" min="0" placeholder="0" required
                                    class="w-full border border-gray-300 dark:border-gray-600 rounded px-2.5 py-1.5 text-sm dark:bg-gray-800 dark:text-gray-200">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Kuota
                                    *</label>
                                <input type="number" name="quota" min="1" placeholder="100" required
                                    class="w-full border border-gray-300 dark:border-gray-600 rounded px-2.5 py-1.5 text-sm dark:bg-gray-800 dark:text-gray-200">
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Deskripsi</label>
                                <input type="text" name="description" placeholder="Opsional"
                                    class="w-full border border-gray-300 dark:border-gray-600 rounded px-2.5 py-1.5 text-sm dark:bg-gray-800 dark:text-gray-200">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Mulai
                                    Penjualan</label>
                                <input type="datetime-local" name="sale_start"
                                    class="w-full border border-gray-300 dark:border-gray-600 rounded px-2.5 py-1.5 text-sm dark:bg-gray-800 dark:text-gray-200">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Akhir
                                    Penjualan</label>
                                <input type="datetime-local" name="sale_end"
                                    class="w-full border border-gray-300 dark:border-gray-600 rounded px-2.5 py-1.5 text-sm dark:bg-gray-800 dark:text-gray-200">
                            </div>
                            <div class="sm:col-span-2 flex justify-end gap-2">
                                <button type="button" @click="showForm = false"
                                    class="text-sm px-3 py-1.5 border border-gray-300 rounded text-gray-600 hover:bg-gray-50">Batal</button>
                                <button type="submit"
                                    class="text-sm px-3 py-1.5 bg-indigo-600 text-white rounded hover:bg-indigo-700">Simpan</button>
                            </div>
                        </form>
                    </div>

                    {{-- Tabel Jenis Tiket --}}
                    @if ($event->ticketTypes->isEmpty())
                        <p class="text-sm text-gray-400 text-center py-6">Belum ada jenis tiket. Klik "+ Tambah Tiket".
                        </p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="text-left border-b dark:border-gray-700 text-gray-500">
                                        <th class="pb-2 font-medium">Nama</th>
                                        <th class="pb-2 font-medium">Harga</th>
                                        <th class="pb-2 font-medium">Terjual / Kuota</th>
                                        <th class="pb-2 font-medium">Periode Jual</th>
                                        <th class="pb-2 font-medium text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($event->ticketTypes as $tt)
                                        <tr class="border-b dark:border-gray-700">
                                            <td class="py-2 font-medium">{{ $tt->name }}</td>
                                            <td class="py-2">Rp {{ number_format($tt->price, 0, ',', '.') }}</td>
                                            <td class="py-2">
                                                <span
                                                    class="{{ $tt->sold_count >= $tt->quota ? 'text-red-600' : 'text-green-600' }}">
                                                    {{ $tt->sold_count }}
                                                </span> / {{ $tt->quota }}
                                            </td>
                                            <td class="py-2 text-gray-500 text-xs">
                                                @if ($tt->sale_start)
                                                    {{ \Carbon\Carbon::parse($tt->sale_start)->format('d M Y') }}
                                                    –
                                                    {{ $tt->sale_end ? \Carbon\Carbon::parse($tt->sale_end)->format('d M Y') : '∞' }}
                                                @else
                                                    Tidak dibatasi
                                                @endif
                                            </td>
                                            <td class="py-2 text-right">
                                                <a href="{{ route('ticket-types.edit', $tt) }}"
                                                    class="text-xs text-indigo-600 hover:underline mr-2">Edit</a>
                                                <form action="{{ route('ticket-types.destroy', $tt) }}" method="POST"
                                                    class="inline" onsubmit="return confirm('Hapus jenis tiket ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        class="text-xs text-red-600 hover:underline">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            @endif

            {{-- ============================================================ --}}
            {{-- USER: Form Pembelian Tiket --}}
            {{-- ============================================================ --}}
            @if (auth()->user()->role === 'user')
                @php
                    $availableTypes = $event->ticketTypes->filter(fn($t) => $t->sold_count < $t->quota);
                    $isOnWaitingList = $event->waitingLists->contains('users_id', auth()->id());
                @endphp

                @if ($event->status !== 'published')
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-center text-gray-500">
                        Event ini belum tersedia untuk pembelian.
                    </div>
                @elseif($availableTypes->isEmpty())
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 mb-3">Tiket</h3>
                        <p class="text-sm text-red-600 mb-4">Semua tiket sudah habis.</p>
                        @if ($isOnWaitingList)
                            <div class="flex items-center gap-3">
                                <span class="text-sm text-green-700 bg-green-100 px-3 py-2 rounded">Kamu sudah di
                                    waiting list</span>
                                <form action="{{ route('waiting-list.leave', $event) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-sm text-red-600 hover:underline">Keluar dari
                                        Waiting List</button>
                                </form>
                            </div>
                        @else
                            <form action="{{ route('waiting-list.join', $event) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="bg-yellow-500 text-white text-sm px-4 py-2 rounded hover:bg-yellow-600">
                                    Daftar Waiting List
                                </button>
                            </form>
                        @endif
                    </div>
                @else
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6" x-data="{
                        quantities: {{ json_encode($event->ticketTypes->pluck('price', 'id')) }},
                        prices: {{ json_encode($event->ticketTypes->pluck('price', 'id')) }},
                        qty: {},
                        get total() {
                            return Object.keys(this.qty).reduce((sum, id) => {
                                return sum + ((parseInt(this.qty[id]) || 0) * (this.prices[id] || 0));
                            }, 0);
                        },
                        fmt(n) { return 'Rp ' + n.toLocaleString('id-ID'); }
                    }">
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 mb-4">Beli Tiket</h3>

                        <form action="{{ route('orders.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="event_id" value="{{ $event->id }}">

                            <div class="space-y-3 mb-5">
                                @foreach ($event->ticketTypes as $tt)
                                    @php $remaining = $tt->quota - $tt->sold_count; @endphp
                                    <div
                                        class="flex items-center justify-between border dark:border-gray-700 rounded-lg p-3
                                        {{ $remaining <= 0 ? 'opacity-50' : '' }}">
                                        <div>
                                            <p class="font-medium text-sm text-gray-800 dark:text-gray-200">
                                                {{ $tt->name }}</p>
                                            <p class="text-xs text-gray-500">Rp
                                                {{ number_format($tt->price, 0, ',', '.') }}
                                                &bull; Sisa: {{ $remaining }}</p>
                                            @if ($tt->description)
                                                <p class="text-xs text-gray-400 mt-0.5">{{ $tt->description }}</p>
                                            @endif
                                        </div>
                                        <input type="number" name="ticket_types[{{ $tt->id }}]"
                                            x-model="qty[{{ $tt->id }}]" min="0"
                                            max="{{ $remaining }}" value="0"
                                            {{ $remaining <= 0 ? 'disabled' : '' }}
                                            class="w-20 border border-gray-300 dark:border-gray-600 rounded px-2 py-1 text-sm text-center dark:bg-gray-700 dark:text-gray-200">
                                    </div>
                                @endforeach
                            </div>

                            <div class="flex justify-between items-center border-t dark:border-gray-700 pt-4">
                                <div>
                                    <p class="text-xs text-gray-500">Total</p>
                                    <p class="text-xl font-bold text-gray-800 dark:text-gray-100" x-text="fmt(total)">
                                        Rp 0</p>
                                </div>
                                <button type="submit"
                                    class="bg-indigo-600 text-white px-5 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">
                                    Pesan Sekarang
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            @endif

        </div>
    </div>
</x-app-layout>
