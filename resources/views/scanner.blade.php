
<!DOCTYPE html>
<html>
<head>
    <title>Scanner Tiket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/html5-qrcode"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen flex flex-col items-center justify-center p-4">

<h2 class="text-2xl font-bold mb-4">📷 Scan Tiket</h2>

<div class="bg-white text-black p-6 rounded-xl shadow-lg w-full max-w-xl">

    <!-- BUTTON SWITCH -->
    <div class="flex gap-3 mb-4">
        <button onclick="startCamera()"
            class="flex-1 bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg font-semibold">
            📷 Kamera
        </button>

        <button onclick="showUpload()"
            class="flex-1 bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg font-semibold">
            📁 Upload
        </button>
    </div>

    <!-- CAMERA -->
    <div id="reader" class="w-full hidden"></div>

    <!-- UPLOAD -->
    <div id="uploadBox" class="hidden">
        <input type="file" id="qr-input-file"
            class="w-full border p-3 rounded-lg">
    </div>

</div>

<div id="result" class="mt-6 text-lg font-semibold text-center"></div>

<script>
let html5QrCode = new Html5Qrcode("reader");

// HANDLE RESULT
function handleResult(data) {
    document.getElementById("result").innerHTML = "⏳ Checking...";

    fetch(data)
        .then(res => res.text())
        .then(res => {
            if (res.includes("valid")) {
                document.body.className = "bg-green-500 text-white min-h-screen flex flex-col items-center justify-center";
            } else {
                document.body.className = "bg-red-500 text-white min-h-screen flex flex-col items-center justify-center";
            }

            document.getElementById("result").innerHTML = res;
        });
}

// START CAMERA
function startCamera() {
    document.getElementById("reader").classList.remove("hidden");
    document.getElementById("uploadBox").classList.add("hidden");

    Html5Qrcode.getCameras().then(devices => {
        if (devices.length) {
            html5QrCode.start(
                devices[0].id,
                { fps: 10, qrbox: 300 },
                decodedText => handleResult(decodedText)
            );
        }
    });
}

// SHOW UPLOAD
function showUpload() {
    document.getElementById("reader").classList.add("hidden");
    document.getElementById("uploadBox").classList.remove("hidden");

    html5QrCode.stop().catch(() => {});
}

// HANDLE FILE UPLOAD
document.getElementById('qr-input-file').addEventListener('change', function (e) {
    if (e.target.files.length == 0) return;

    html5QrCode.scanFile(e.target.files[0], true)
        .then(decodedText => handleResult(decodedText))
        .catch(() => alert("Gagal membaca QR!"));
});
</script>

</body>
</html>
