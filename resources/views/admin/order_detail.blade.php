<!DOCTYPE html>
<html>
<head>
    <title>Detail Order</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">

<h1 class="text-3xl font-bold mb-6">Detail Order #{{ $order->id }}</h1>

<div class="bg-white p-6 rounded shadow max-w-lg">
    <p><strong>Email:</strong> {{ $order->email }}</p>
    <p><strong>Tiket:</strong> {{ $order->ticket->name }}</p>
    <p><strong>Status:</strong> {{ $order->status }}</p>
    @if($order->qr_code)
    <p><strong>QR:</strong> <a href="{{ asset('storage/'.$order->qr_code) }}" target="_blank" class="text-blue-500 underline">Lihat QR</a></p>
    @endif
    <p><strong>Waktu beli:</strong> {{ $order->created_at }}</p>
</div>

</body>
</html>