<?php

namespace App\Http\Controllers;

use App\Mail\TicketMail;
use App\Models\ETicket;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PaymentController extends Controller
{
    public function simulate(Request $request, Order $order)
    {
        if ($order->users_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return redirect()->route('orders.success', $order->id)
                ->with('info', 'Order ini sudah diproses sebelumnya.');
        }

        $request->validate([
            'payment_method' => 'required|in:transfer_bank,qris,virtual_account',
        ]);

        $payment = Payment::create([
            'payment_method' => $request->payment_method,
            'transaction_id' => 'TRX-' . strtoupper(Str::random(10)),
            'paid_at' => now(),
        ]);

        $order->update([
            'status' => 'paid',
            'payments_id' => $payment->id,
        ]);

        // Generate e-tickets setelah pembayaran
        $order->load('orderItems');
        foreach ($order->orderItems as $orderItem) {
            for ($i = 0; $i < $orderItem->quantity; $i++) {
                $ticketCode = 'TIX-' . strtoupper(Str::random(8));
                $qr = QrCode::size(200)->format('svg')->generate($ticketCode);

                ETicket::create([
                    'ticket_code' => $ticketCode,
                    'qr_code_data' => $qr,
                    'status' => 'valid',
                    'order_items_id' => $orderItem->id,
                    'users_id' => $order->users_id,
                    'events_id' => $order->events_id,
                ]);
            }
        }

        // Kirim email tiket
        try {
            $order->load('orderItems.ticketType', 'orderItems.eTickets', 'event');
            Mail::to(Auth::user()->email)->send(new TicketMail($order));
        } catch (\Exception $e) {
            Log::error('Email tiket gagal dikirim: ' . $e->getMessage());
        }

        return redirect()->route('orders.success', $order->id)
            ->with('success', 'Pembayaran berhasil! E-ticket dikirim ke email Anda.');
    }

    public function cancel(Order $order)
    {
        if ($order->users_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return redirect()->route('dashboard')
                ->with('info', 'Order ini tidak dapat dibatalkan.');
        }

        // Kembalikan quota tiket
        $order->load('orderItems.ticketType');
        foreach ($order->orderItems as $item) {
            $item->ticketType->decrement('sold_count', $item->quantity);
        }

        $order->update(['status' => 'failed']);

        return redirect()->route('events.show', $order->events_id)
            ->with('info', 'Pesanan dibatalkan. Kuota tiket dikembalikan.');
    }
}
