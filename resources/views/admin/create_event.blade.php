<!DOCTYPE html>
<html>
<head>
    <title>Tambah Event</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

<div class="bg-white p-8 rounded-xl shadow w-full max-w-md">

    <h1 class="text-2xl font-bold mb-4 text-center">➕ Tambah Event</h1>

    <form method="POST" action="/admin/event/store">
        @csrf

        <input type="text" name="name" placeholder="Nama Event"
            class="w-full border p-2 rounded mb-3" required>

        <input type="date" name="date"
            class="w-full border p-2 rounded mb-3" required>

        <input type="text" name="location" placeholder="Lokasi"
            class="w-full border p-2 rounded mb-4" required>

        <button class="w-full bg-indigo-500 text-white py-2 rounded hover:bg-indigo-600">
            Simpan Event
        </button>

    </form>

    <a href="/admin" class="block text-center mt-4 text-gray-500 hover:underline">
        ⬅ Kembali
    </a>

</div>

</body>
</html>