<!DOCTYPE html>
<html>
<head>
    <title>Waiting List</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">

<h1 class="text-3xl font-bold mb-6">Waiting List</h1>

<table class="table-auto w-full bg-white shadow rounded">
    <thead class="bg-gray-200">
        <tr>
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">Email</th>
            <th class="px-4 py-2">Tiket</th>
            <th class="px-4 py-2">Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($waiting as $item)
        <tr>
            <td class="border px-4 py-2">{{ $item->id }}</td>
            <td class="border px-4 py-2">{{ $item->email }}</td>
            <td class="border px-4 py-2">{{ $item->ticket->id }}</td>
            <td class="border px-4 py-2">{{ $item->created_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>