
<!DOCTYPE html>
<html>
<head>
    <title>Waiting List</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-yellow-100 min-h-screen flex items-center justify-center">

<div class="bg-white p-8 rounded-2xl shadow-xl text-center max-w-md">

    <h2 class="text-2xl font-bold text-yellow-600 mb-4">
        ⏳ Masuk Waiting List
    </h2>

    <p class="text-gray-700 mb-2">
        Maaf, tiket <strong>{{ $ticket }}</strong> sedang habis.
    </p>

    <p class="text-gray-700 mb-4">
        Email <strong>{{ $email }}</strong> sudah masuk dalam waiting list.
    </p>

    <p class="text-sm text-gray-500 mb-6">
        Kami akan menghubungi Anda jika tiket tersedia kembali.
    </p>

    <a href="/buy"
       class="inline-block bg-indigo-500 text-white px-5 py-2 rounded-lg hover:bg-indigo-600 transition">
        Kembali
    </a>

</div>

</body>
</html>
