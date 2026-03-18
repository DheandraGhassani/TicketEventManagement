<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <p class="text-gray-500 text-sm">Total Revenue</p>
                    <p class="text-2xl font-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <p class="text-gray-500 text-sm">Tickets Sold</p>
                    <p class="text-2xl font-bold">{{ $totalTicketsSold }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <p class="text-gray-500 text-sm">Active Events</p>
                    <p class="text-2xl font-bold">{{ $activeEvents }}</p>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Recent Orders</h3>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left border-b">
                            <th class="pb-2">Order #</th>
                            <th class="pb-2">Customer</th>
                            <th class="pb-2">Amount</th>
                            <th class="pb-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                        <tr class="border-b">
                            <td class="py-2">{{ $order->order_number }}</td>
                            <td class="py-2">{{ $order->user->name ?? '-' }}</td>
                            <td class="py-2">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td class="py-2">{{ $order->status }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
