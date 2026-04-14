<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Scan Tiket</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6" x-data="{
                code: '',
                loading: false,
                result: null,
                async scan() {
                    if (!this.code.trim()) return;
                    this.loading = true;
                    this.result = null;
                    try {
                        const resp = await fetch('{{ route('tickets.scan') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({ ticket_code: this.code })
                        });
                        this.result = await resp.json();
                        if (this.result.success) this.code = '';
                    } catch (e) {
                        this.result = { success: false, message: 'Terjadi kesalahan koneksi.' };
                    }
                    this.loading = false;
                }
            }">

                <p class="text-sm text-gray-500 mb-5">Masukkan kode tiket secara manual atau arahkan scanner ke sini.</p>

                <div class="flex gap-2 mb-5">
                    <input type="text" x-model="code" @keydown.enter="scan()" placeholder="TIX-XXXXXXXX"
                        class="flex-1 border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 text-sm uppercase dark:bg-gray-700 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                    <button @click="scan()" :disabled="loading || !code.trim()"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700 disabled:opacity-50">
                        <span x-show="!loading">Scan</span>
                        <span x-show="loading">...</span>
                    </button>
                </div>

                {{-- Result --}}
                <div x-show="result" x-transition>
                    <div :class="result?.success ? 'bg-green-50 border-green-400 text-green-700' :
                        'bg-red-50 border-red-400 text-red-700'"
                        class="border rounded-md px-4 py-4">
                        <p class="font-semibold text-sm" x-text="result?.message"></p>
                        <template x-if="result?.success && result?.ticket">
                            <div class="mt-3 text-xs space-y-1 text-green-800">
                                <p>Kode: <strong x-text="result.ticket.ticket_code"></strong></p>
                                <p>Scan pada: <strong x-text="result.ticket.scanned_at"></strong></p>
                            </div>
                        </template>
                    </div>
                </div>

            </div>

            {{-- Riwayat scan hari ini --}}
            <div class="mt-6 bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-3 text-sm">Info</h3>
                <ul class="text-xs text-gray-500 space-y-1 list-disc list-inside">
                    <li>Tiket yang sudah discan tidak dapat discan ulang.</li>
                    <li>Kode tiket bersifat unik (format: TIX-XXXXXXXX).</li>
                    <li>Gunakan tombol "Enter" setelah mengetik kode untuk scan cepat.</li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
