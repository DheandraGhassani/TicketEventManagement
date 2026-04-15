<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-100 min-h-screen flex items-center justify-center">

<div class="bg-white p-8 rounded-2xl shadow-xl text-center max-w-md">

    <h2 class="text-2xl font-bold mb-4">💳 Pembayaran</h2>

    <p class="mb-2">Tiket: <strong>{{ $order->ticket->name }}</strong></p>
    <p class="mb-4">Email: <strong>{{ $order->email }}</strong></p>

    <p class="mb-6 text-gray-500">Status: {{ $order->status }}</p>

    <form method="POST" action="/payment/{{ $order->id }}/pay">
        @csrf
        <button class="w-full bg-green-500 text-white py-2 rounded mb-3">
            ✔ Bayar (Simulasi Berhasil)
        </button>
    </form>

    <form method="POST" action="/payment/{{ $order->id }}/fail">
        @csrf
        <button class="w-full bg-red-500 text-white py-2 rounded">
            ❌ Gagal Bayar
        </button>
    </form>

</div>

</body>
</html>
