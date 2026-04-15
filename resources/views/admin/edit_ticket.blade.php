<!DOCTYPE html>
<html>
<head>
    <title>Edit Tiket</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">

<h1 class="text-3xl font-bold mb-6">Edit Tiket #{{ $ticket->id }}</h1>

<div class="bg-white p-6 rounded shadow max-w-lg">
    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form action="/admin/tickets/{{ $ticket->id }}/update" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Nama Tiket</label>
            <input type="text" name="name" value="{{ $ticket->name }}" class="w-full border px-3 py-2 rounded bg-gray-100" readonly>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Harga</label>
            <input type="number" name="price" value="{{ $ticket->price }}" class="w-full border px-3 py-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Stok</label>
            <input type="number" name="stock" value="{{ $ticket->stock }}" class="w-full border px-3 py-2 rounded">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update Tiket</button>
    </form>
</div>

</body>
</html>