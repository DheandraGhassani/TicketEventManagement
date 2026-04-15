
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Beli Tiket</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-100 to-indigo-200 min-h-screen flex items-center justify-center">

<div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
        🎫 Beli Tiket Event
    </h2>

    <form method="POST" action="/buy" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-semibold text-gray-600 mb-1">Pilih Tiket</label>
            <select name="ticket_id" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-indigo-400">
                @foreach($tickets as $ticket)
                    <option value="{{ $ticket->id }}">
                        {{ $ticket->name }} - Rp {{ number_format($ticket->price) }} (Stock: {{ $ticket->stock }})
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-600 mb-1">Email</label>
            <input type="email" name="email" required
                class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-indigo-400"
                placeholder="example@gmail.com">
        </div>

        <button type="submit"
            class="w-full bg-indigo-500 hover:bg-indigo-600 text-white py-3 rounded-lg font-semibold transition">
            Beli Sekarang
        </button>
    </form>
</div>

</body>
</html>
