<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>


        
<div class="flex justify-between items-center mb-8">

    <div>
        <h1 class="text-4xl font-extrabold text-gray-800 mb-2">
            📊 Dashboard Global
        </h1>
        <p class="text-gray-500">
            Ringkasan performa semua event
        </p>
    </div>

    <!-- 🔥 LOGOUT BUTTON -->
    <form method="POST" action="/logout">
        @csrf
        <button class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
            🚪 Logout
        </button>
    </form>

</div>

<!-- 🔥 STATISTIK -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">

    <div class="bg-white p-5 rounded-2xl shadow hover:shadow-lg transition text-center">
        <p class="text-gray-500 text-sm">Total Order</p>
        <h2 class="text-3xl font-bold text-gray-800 mt-2">
            {{ $totalOrders }}
        </h2>
    </div>

    <div class="bg-gradient-to-r from-green-400 to-green-600 text-white p-5 rounded-2xl shadow text-center">
        <p class="text-sm">Paid</p>
        <h2 class="text-3xl font-bold mt-2">
            {{ $paid }}
        </h2>
    </div>

    <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 text-white p-5 rounded-2xl shadow text-center">
        <p class="text-sm">Pending</p>
        <h2 class="text-3xl font-bold mt-2">
            {{ $pending }}
        </h2>
    </div>

    <div class="bg-gradient-to-r from-red-400 to-red-600 text-white p-5 rounded-2xl shadow text-center">
        <p class="text-sm">Failed</p>
        <h2 class="text-3xl font-bold mt-2">
            {{ $failed }}
        </h2>
    </div>

</div>

<!-- 💰 REVENUE -->
<div class="bg-gradient-to-r from-purple-500 to-indigo-600 text-white p-6 rounded-2xl shadow mb-10 text-center">
    <p class="text-lg">💰 Total Revenue</p>
    <h2 class="text-4xl font-extrabold mt-2">
        Rp {{ number_format($revenue) }}
    </h2>
</div>

<!-- 📅 LIST EVENT -->
<div class="flex justify-between items-center mb-4">
    <h2 class="text-2xl font-semibold text-gray-800">
        📅 Daftar Event
    </h2>

    <a href="/admin/event/create"
       class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
        ➕ Tambah Event
    </a>
</div>


<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    @foreach($events as $event)
    <div class="bg-white p-6 rounded-2xl shadow hover:shadow-xl transition transform hover:-translate-y-1">

        <h3 class="text-lg font-bold text-gray-800 mb-2">
            {{ $event->name }}
        </h3>

        <div class="text-gray-500 text-sm mb-3">
            <p>📅 {{ $event->date }}</p>
            <p>📍 {{ $event->location }}</p>
        </div>

        <a href="/admin/event/{{ $event->id }}"
           class="block mt-4 bg-indigo-500 text-white text-center py-2 rounded-lg hover:bg-indigo-600 transition">
            Kelola Event
        </a>
        

    </div>
    @endforeach

    

</div>

</body>
</html>