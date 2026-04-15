<!DOCTYPE html>
<html>
<head>
    <title>Event List</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">

<h1 class="text-3xl font-bold mb-6 text-center">🎉 Daftar Event</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @foreach($events as $event)
    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
        <h2 class="text-xl font-bold mb-2">{{ $event->name }}</h2>

        <p class="text-gray-600 mb-2">
            📅 {{ $event->date }}
        </p>

        <p class="text-gray-600 mb-4">
            📍 {{ $event->location }}
        </p>

        @auth
            @if(auth()->user()->role_id == 1)
                <a href="/admin/event/{{ $event->id }}"
                class="block bg-purple-500 text-white text-center py-2 rounded">
                    Kelola Event
                </a>
            @else
                <a href="/event/{{ $event->id }}"
                class="block bg-indigo-500 text-white text-center py-2 rounded">
                    Lihat Event
                </a>
            @endif
        @else
            <a href="/event/{{ $event->id }}"
            class="block bg-indigo-500 text-white text-center py-2 rounded">
                Lihat Event
            </a>
        @endauth
    </div>
    @endforeach
</div>

</body>
</html>