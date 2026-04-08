<?php

namespace App\Http\Controllers;

use App\Models\Order;

class ScanController extends Controller
{
    public function scan($code)
    {
        $order = Order::where('qr_code', 'like', "%$code%")->first();

        if (!$order) {
            return "QR tidak valid!";
        }

        if (!$order->is_valid) {
            return "Tiket sudah digunakan!";
        }

        $order->update(['is_valid' => false]);

        return "Tiket valid ✔️";
    }
}