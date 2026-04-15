<!DOCTYPE html>
<html>
<head>
    <title>Event Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 p-8">

<!-- HEADER -->
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">
            🎯 {{ $event->name }}
        </h1>
        <p class="text-gray-500">
            📅 {{ $event->date }} | 📍 {{ $event->location }}
        </p>
    </div>

    <div class="flex gap-2">
        <a href="/admin"
           class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
           ⬅ Kembali
        </a>

        <a href="/home"
           class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">
           🌐 Lihat Website
        </a>
    </div>
</div>

<!-- 🔥 STATISTIK -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">

    <div class="bg-white p-5 rounded-2xl shadow text-center">
        <p class="text-gray-500 text-sm">Total Order</p>
        <h2 class="text-3xl font-bold">{{ $totalOrders }}</h2>
    </div>

    <div class="bg-green-100 p-5 rounded-2xl text-center">
        <p>Paid</p>
        <h2 class="text-3xl font-bold text-green-600">{{ $paid }}</h2>
    </div>

    <div class="bg-yellow-100 p-5 rounded-2xl text-center">
        <p>Pending</p>
        <h2 class="text-3xl font-bold text-yellow-600">{{ $pending }}</h2>
    </div>

    <div class="bg-red-100 p-5 rounded-2xl text-center">
        <p>Failed</p>
        <h2 class="text-3xl font-bold text-red-600">{{ $failed }}</h2>
    </div>

</div>

<!-- 💰 STATS TAMBAHAN -->
<div class="grid grid-cols-2 md:grid-cols-3 gap-6 mb-8">

    <div class="bg-indigo-100 p-5 rounded-2xl text-center">
        <p>🎟️ Tiket Terjual</p>
        <h2 class="text-3xl font-bold text-indigo-600">{{ $soldTickets }}</h2>
    </div>

    <div class="bg-purple-100 p-5 rounded-2xl text-center">
        <p>💰 Revenue</p>
        <h2 class="text-3xl font-bold text-purple-600">
            Rp {{ number_format($revenue) }}
        </h2>
    </div>

    <div class="bg-blue-100 p-5 rounded-2xl text-center">
        <p>📊 Conversion</p>
        <h2 class="text-3xl font-bold text-blue-600">
            {{ $conversion }}%
        </h2>
    </div>

</div>

<!-- 📊 CHART -->
<div class="bg-white p-6 rounded-2xl shadow mb-8 max-w-md mx-auto">
    <canvas id="chart"></canvas>
</div>

<script>
new Chart(document.getElementById('chart'), {
    type: 'pie',
    data: {
        labels: ['Paid', 'Pending', 'Failed'],
        datasets: [{
            data: [{{ $paid }}, {{ $pending }}, {{ $failed }}],
        }]
    }
});
</script>
<div class="bg-white p-6 rounded-2xl shadow mb-6">

    <h2 class="text-xl font-semibold mb-4">➕ Tambah Tiket</h2>

    <form method="POST" action="/admin/event/{{ $event->id }}/tickets" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @csrf

        <input type="text" name="name" placeholder="Nama Tiket"
            class="border p-2 rounded w-full" required>

        <input type="number" name="price" placeholder="Harga"
            class="border p-2 rounded w-full" required>

        <input type="number" name="stock" placeholder="Stok"
            class="border p-2 rounded w-full" required>

        <button class="md:col-span-3 bg-green-500 text-white py-2 rounded hover:bg-green-600">
            Tambah Tiket
        </button>
    </form>

</div>
<!-- 🎟️ LIST TIKET -->
<div class="bg-white p-6 rounded-2xl shadow mb-8">

    <h2 class="text-xl font-semibold mb-4">🎟️ Tiket Event</h2>

    <table class="w-full text-left">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-3">Nama</th>
                <th class="p-3">Harga</th>
                <th class="p-3">Stok</th>
                <th class="p-3">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($event->tickets as $ticket)
            <tr class="border-b">

                <td class="p-3 font-semibold">
                    {{ $ticket->name }}
                </td>

                <td class="p-3">
                    <form method="POST" action="/admin/tickets/{{ $ticket->id }}/update" class="flex items-center gap-2">
                        @csrf
                        <input type="number" name="price"
                            value="{{ $ticket->price }}"
                            class="border p-1 w-24 rounded">
                </td>

                <td class="p-3">
                        <input type="number" name="stock"
                            value="{{ $ticket->stock }}"
                            class="border p-1 w-20 rounded">
                </td>

                <td class="p-3 flex gap-2">

                        <button class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                            Update
                        </button>
                    </form>

                    <form method="POST" action="/admin/tickets/{{ $ticket->id }}/delete">
                        @csrf
                        <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                            Hapus
                        </button>
                    </form>

                </td>

            </tr>
            @endforeach
        </tbody>
    </table>

</div>

<!-- 📦 ORDER -->
<div class="bg-white p-6 rounded-2xl shadow">

    <h2 class="text-xl font-semibold mb-4">📦 Order Event</h2>

    <table class="w-full text-left">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-3">ID</th>
                <th class="p-3">Email</th>
                <th class="p-3">Tiket</th>
                <th class="p-3">Status</th>
                <th class="p-3">QR</th>
            </tr>
        </thead>

        <tbody>
            @foreach($orders as $order)
            <tr class="border-b">

                <td class="p-3">{{ $order->id }}</td>
                <td class="p-3">{{ $order->email }}</td>
                <td class="p-3">{{ $order->ticket->name }}</td>

                <td class="p-3">
                    @if($order->status == 'paid')
                        <span class="text-green-600 font-bold">Paid</span>
                    @elseif($order->status == 'pending')
                        <span class="text-yellow-600 font-bold">Pending</span>
                    @else
                        <span class="text-red-600 font-bold">Failed</span>
                    @endif
                </td>

                <td class="p-3">
                    @if($order->qr_code)
                        <a href="{{ asset('storage/'.$order->qr_code) }}"
                           target="_blank"
                           class="text-blue-500 underline">
                           Lihat QR
                        </a>

                        <br>

                        <span class="{{ $order->used ? 'text-red-500' : 'text-green-500' }}">
                            {{ $order->used ? 'Sudah digunakan' : 'Belum digunakan' }}
                        </span>
                    @else
                        -
                    @endif
                </td>

            </tr>
            @endforeach
        </tbody>

    </table>

</div>

</body>
</html>