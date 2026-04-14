<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard Admin</h2>
            <a href="{{ route('dashboard.export') }}"
                class="bg-green-600 text-white px-4 py-2 rounded-md text-sm hover:bg-green-700">
                Export Excel
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow">
                    <p class="text-sm text-gray-500 mb-1">Total Revenue</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                        Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow">
                    <p class="text-sm text-gray-500 mb-1">Tiket Terjual</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $totalTicketsSold }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow">
                    <p class="text-sm text-gray-500 mb-1">Event Aktif</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $activeEvents }}</p>
                </div>
            </div>

            {{-- Chart Penjualan 7 Hari --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
                <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200 mb-4">Grafik Penjualan (7 Hari
                    Terakhir)</h3>
                <canvas id="salesChart" height="80"></canvas>
            </div>

            {{-- Quick Actions --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <a href="{{ route('events.index') }}"
                    class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 hover:bg-indigo-50 dark:hover:bg-gray-700 transition flex items-center gap-3">
                    <span class="text-2xl">📅</span>
                    <div>
                        <p class="font-medium text-sm text-gray-800 dark:text-gray-200">Kelola Event</p>
                        <p class="text-xs text-gray-500">Lihat & buat event</p>
                    </div>
                </a>
                <a href="{{ route('categories.index') }}"
                    class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 hover:bg-indigo-50 dark:hover:bg-gray-700 transition flex items-center gap-3">
                    <span class="text-2xl">🏷️</span>
                    <div>
                        <p class="font-medium text-sm text-gray-800 dark:text-gray-200">Kelola Kategori</p>
                        <p class="text-xs text-gray-500">Atur kategori event</p>
                    </div>
                </a>
                <a href="{{ route('tickets.scan.index') }}"
                    class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 hover:bg-indigo-50 dark:hover:bg-gray-700 transition flex items-center gap-3">
                    <span class="text-2xl">🔍</span>
                    <div>
                        <p class="font-medium text-sm text-gray-800 dark:text-gray-200">Scan Tiket</p>
                        <p class="text-xs text-gray-500">Validasi tiket masuk</p>
                    </div>
                </a>
            </div>

            {{-- Recent Orders --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
                <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200 mb-4">Pesanan Terbaru</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left border-b dark:border-gray-700 text-gray-500">
                                <th class="pb-2 font-medium">Order #</th>
                                <th class="pb-2 font-medium">Pembeli</th>
                                <th class="pb-2 font-medium">Total</th>
                                <th class="pb-2 font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                                <tr class="border-b dark:border-gray-700 last:border-0">
                                    <td class="py-2 text-gray-600 dark:text-gray-400">{{ $order->order_number }}</td>
                                    <td class="py-2 text-gray-700 dark:text-gray-300">{{ $order->user->name ?? '-' }}
                                    </td>
                                    <td class="py-2 font-medium text-gray-800 dark:text-gray-200">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="py-2">
                                        <span
                                            class="text-xs px-2 py-0.5 rounded-full
                                            @if ($order->status === 'paid') bg-green-100 text-green-700
                                            @elseif($order->status === 'pending') bg-yellow-100 text-yellow-700
                                            @elseif($order->status === 'failed') bg-red-100 text-red-700
                                            @else bg-gray-100 text-gray-500 @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-gray-400">Belum ada pesanan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        const salesData = @json($salesData);
        const labels = salesData.map(d => d.date);
        const revenue = salesData.map(d => parseFloat(d.revenue));

        new Chart(document.getElementById('salesChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Revenue (Rp)',
                    data: revenue,
                    borderColor: '#4f46e5',
                    backgroundColor: 'rgba(79,70,229,0.1)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#4f46e5',
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: ctx => 'Rp ' + ctx.parsed.y.toLocaleString('id-ID')
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: v => 'Rp ' + v.toLocaleString('id-ID')
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>
