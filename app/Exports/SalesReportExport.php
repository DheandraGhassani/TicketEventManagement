<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SalesReportExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{
    /**
     * Ambil data dari database
     */
    public function collection()
    {
        // Mengambil pesanan yang sudah dibayar, lengkap dengan data user dan event
        return Order::with(['user', 'event'])
            ->where('status', 'paid')
            ->latest()
            ->get();
    }

    /**
     * Tentukan Judul Kolom di Excel
     */
    public function headings(): array
    {
        return [
            'Nomor Pesanan',
            'Nama Pembeli',
            'Email',
            'Nama Event',
            'Total Pembayaran',
            'Status',
            'Tanggal Transaksi',
        ];
    }

    /**
     * Map data untuk setiap baris (Format Data)
     */
    public function map($order): array
    {
        return [
            $order->order_number,
            $order->user->name ?? 'Guest',
            $order->user->email ?? '-',
            $order->event->title ?? 'N/A',
            'Rp '.number_format($order->total_amount, 0, ',', '.'),
            strtoupper($order->status),
            $order->created_at->format('d M Y H:i'),
        ];
    }
}
