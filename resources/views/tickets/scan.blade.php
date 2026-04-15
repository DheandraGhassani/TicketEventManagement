<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Scan Tiket
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6"
                x-data='{
                    code: "",
                    loading: false,
                    result: null,
                    scanner: null,
                    showCamera: false,
                    showUpload: false,

                    async scan() {
                        if (!this.code.trim()) return;
                        this.loading = true;
                        this.result = null;

                        try {
                            const resp = await fetch("{{ route('tickets.scan') }}", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": document.querySelector("meta[name=csrf-token]").content,
                                    "Accept": "application/json",
                                },
                                body: JSON.stringify({ ticket_code: this.code })
                            });

                            this.result = await resp.json();
                            if (this.result.success) this.code = "";
                        } catch (e) {
                            this.result = { success: false, message: "Terjadi kesalahan koneksi." };
                        }

                        this.loading = false;
                    },

                    startCamera() {
                        this.showCamera = true;
                        this.showUpload = false;

                        this.$nextTick(() => {
                            this.scanner = new Html5Qrcode("reader");

                            Html5Qrcode.getCameras().then(devices => {
                                if (devices.length) {
                                    this.scanner.start(
                                        devices[0].id,
                                        { fps: 10, qrbox: 250 },
                                        (decodedText) => {
                                            this.code = decodedText;
                                            this.scan();
                                        }
                                    );
                                }
                            });
                        });
                    },

                    stopCamera() {
                        if (this.scanner) {
                            this.scanner.stop().catch(() => {});
                        }
                        this.showCamera = false;
                    },

                    showUploadBox() {
                        this.showUpload = true;
                        this.showCamera = false;
                        this.stopCamera();
                    },

                    handleFile(e) {
                        if (!e.target.files.length) return;

                        this.scanner = new Html5Qrcode("reader");
                        this.scanner.scanFile(e.target.files[0], true)
                            .then(decodedText => {
                                this.code = decodedText;
                                this.scan();
                            })
                            .catch(() => alert("Gagal membaca QR"));
                    }
                }'>

                <p class="text-sm text-gray-500 mb-5">
                    Masukkan kode tiket atau scan QR.
                </p>

                <!-- INPUT -->
                <div class="flex gap-2 mb-4">
                    <input type="text" x-model="code" @keydown.enter="scan()"
                        placeholder="TIX-XXXXXXXX"
                        class="flex-1 border rounded-md px-3 py-2 text-sm">

                    <button @click="scan()" :disabled="loading || !code.trim()"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm">
                        <span x-show="!loading">Scan</span>
                        <span x-show="loading">...</span>
                    </button>
                </div>

                <!-- BUTTON -->
                <div class="flex gap-2 mb-4">
                    <button @click="startCamera()" class="bg-blue-500 text-white px-3 py-2 rounded text-sm">
                        📷 Kamera
                    </button>

                    <button @click="showUploadBox()" class="bg-green-500 text-white px-3 py-2 rounded text-sm">
                        📁 Upload
                    </button>

                    <button @click="stopCamera()" class="bg-gray-500 text-white px-3 py-2 rounded text-sm">
                        ❌ Stop
                    </button>
                </div>

                <!-- CAMERA -->
                <div id="reader" x-show="showCamera" class="w-full mb-4"></div>

                <!-- UPLOAD -->
                <div x-show="showUpload" class="mb-4">
                    <input type="file" @change="handleFile" class="w-full border p-2 rounded text-sm">
                </div>

                <!-- RESULT -->
                <div x-show="result">
                    <div :class="result?.success ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'"
                        class="p-3 rounded">
                        <p x-text="result?.message"></p>
                    </div>
                </div>

                <!-- INFO -->
            <div class="mt-6 bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-3 text-sm">
                    Info
                </h3>
                <ul class="text-xs text-gray-500 space-y-1 list-disc list-inside">
                    <li>Tiket hanya bisa discan sekali.</li>
                    <li>Format kode: TIX-XXXXXXXX</li>
                    <li>Bisa scan via kamera atau upload QR</li>
                </ul>
            </div>

            </div>

        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode"></script>
</x-app-layout>
