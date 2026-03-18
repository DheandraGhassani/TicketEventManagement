<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function simulate(Request $request, Order $order)
    {
        $payment = Payment::create([
            'payment_method' => $request->payment_method ?? 'transfer_bank',
            'transaction_id' => 'TRX-' . strtoupper(Str::random(10)),
            'paid_at'        => now(),
        ]);

        $order->update([
            'status'      => 'paid',
            'payments_id' => $payment->id,
        ]);

        return redirect()->route('orders.success', $order)
                        ->with('success', '✅ Pembayaran berhasil disimulasikan!');
    }
}