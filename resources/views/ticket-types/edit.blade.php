<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('events.show', $ticketType->event) }}" class="text-gray-500 hover:text-gray-700 text-sm">←
                Kembali</a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Jenis Tiket</h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">

                <form action="{{ route('ticket-types.update', $ticketType) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="name" :value="'Nama *'" />
                        <x-text-input id="name" name="name" type="text" class="w-full mt-1 text-sm"
                            :value="old('name', $ticketType->name)" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="description" :value="'Deskripsi'" />
                        <textarea id="description" name="description" rows="2"
                            class="mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">{{ old('description', $ticketType->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-1" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="price" :value="'Harga (Rp) *'" />
                            <x-text-input id="price" name="price" type="number" min="0"
                                class="w-full mt-1 text-sm" :value="old('price', $ticketType->price)" required />
                            <x-input-error :messages="$errors->get('price')" class="mt-1" />
                        </div>
                        <div>
                            <x-input-label for="quota" :value="'Kuota *'" />
                            <p class="text-xs text-gray-400 mb-1">min: {{ $ticketType->sold_count }} terjual</p>
                            <x-text-input id="quota" name="quota" type="number"
                                min="{{ $ticketType->sold_count }}" class="w-full text-sm"
                                :value="old('quota', $ticketType->quota)" required />
                            <x-input-error :messages="$errors->get('quota')" class="mt-1" />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="sale_start" :value="'Mulai Penjualan'" />
                            <x-text-input id="sale_start" name="sale_start" type="datetime-local"
                                class="w-full mt-1 text-sm"
                                :value="old('sale_start', $ticketType->sale_start ? \Carbon\Carbon::parse($ticketType->sale_start)->format('Y-m-d\TH:i') : '')" />
                            <x-input-error :messages="$errors->get('sale_start')" class="mt-1" />
                        </div>
                        <div>
                            <x-input-label for="sale_end" :value="'Akhir Penjualan'" />
                            <x-text-input id="sale_end" name="sale_end" type="datetime-local"
                                class="w-full mt-1 text-sm"
                                :value="old('sale_end', $ticketType->sale_end ? \Carbon\Carbon::parse($ticketType->sale_end)->format('Y-m-d\TH:i') : '')" />
                            <x-input-error :messages="$errors->get('sale_end')" class="mt-1" />
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <a href="{{ route('events.show', $ticketType->event) }}"
                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition">
                            Batal
                        </a>
                        <x-primary-button>Update</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
