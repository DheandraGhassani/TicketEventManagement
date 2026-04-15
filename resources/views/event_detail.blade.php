<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Event</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-indigo-100 via-white to-blue-100 min-h-screen p-6">

<div class="max-w-5xl mx-auto">

    <!-- Header -->
    <div class="bg-white shadow-xl rounded-2xl p-6 mb-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">
            {{ $event->name }}
        </h1>

        <p class="text-gray-500 flex flex-wrap gap-4 text-sm">
            <span>📅 {{ $event->date }}</span>
            <span>📍 {{ $event->location }}</span>
        </p>

        <p class="mt-4 text-gray-700 leading-relaxed">
            {{ $event->description }}
        </p>
    </div>

    <!-- Ticket Section -->
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">
        🎟️ Pilih Tiket
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        @foreach($event->tickets as $ticket)
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 p-6 border border-gray-100">

            <h3 class="text-xl font-bold text-gray-800 mb-2">
                {{ $ticket->name }}
            </h3>

            <p class="text-indigo-600 font-semibold text-lg mb-1">
                Rp {{ number_format($ticket->price) }}
            </p>

            <p class="text-sm text-gray-500 mb-4">
                Stok: {{ $ticket->stock }}
            </p>

            <form action="/buy" method="POST" class="space-y-3">
                @csrf

                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

                <input 
                    type="email" 
                    name="email" 
                    placeholder="Masukkan email"
                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 outline-none"
                    required
                >

                <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-lg transition duration-200">
                    Beli Tiket
                </button>
            </form>

        </div>
        @endforeach

    </div>

</div>

</body>
</html>