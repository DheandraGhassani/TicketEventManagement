<?php

namespace App\Http\Controllers;

use App\Models\Order;

class ScanController extends Controller
{
    public function scan($code)
    {
        // Cari order berdasarkan QR code (like untuk UUID di nama file)
        $order = Order::where('qr_code', 'like', "%$code%")->first();

        if (!$order) {
            return "QR tidak valid ❌";
        }

        // Cek apakah QR sudah pernah digunakan
        if ($order->used) {
            return "QR sudah pernah digunakan ❌";
        }

        // Tandai QR sebagai sudah digunakan
        $order->used = 1;
        $order->save();

        return "Tiket valid ✔️";
    }
}