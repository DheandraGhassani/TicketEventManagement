
<!DOCTYPE html>
<html>
<head>
    <title>Ticket Berhasil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-100 min-h-screen flex items-center justify-center">

<div class="bg-white p-8 rounded-2xl shadow-xl text-center max-w-md">
    
    <h2 class="text-2xl font-bold text-green-600 mb-4">
        ✅ Ticket Berhasil Dibeli!
    </h2>

    <p class="text-gray-700 mb-2">
        <strong>Jenis:</strong> {{ $order->ticket->name }}
    </p>

    <p class="text-gray-700 mb-4">
        <strong>Email:</strong> {{ $order->email }}
    </p>

    <div class="flex justify-center mb-4">
        <img src="{{ asset('storage/'.$order->qr_code) }}" class="w-48">
    </div>

    <!-- DOWNLOAD BUTTON -->
    <a href="{{ asset('storage/'.$order->qr_code) }}" download
       class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-lg font-semibold transition mb-3">
        ⬇️ Download QR
    </a>

    <br>

    <a href="/"
       class="inline-block bg-indigo-500 text-white px-5 py-2 rounded-lg hover:bg-indigo-600 transition">
        Kembali
    </a>

</div>

</body>
</html>
