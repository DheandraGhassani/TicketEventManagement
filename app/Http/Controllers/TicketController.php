<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Order;
use App\Models\WaitingList;

class TicketController extends Controller
{
    public function buy(Request $request)
    {
        $ticket = Ticket::findOrFail($request->ticket_id);

        // ❌ Kalau stok habis → masuk waiting list
        if ($ticket->stock <= 0) {

            WaitingList::create([
                'email' => $request->email,
                'ticket_id' => $ticket->id,
            ]);

            return view('waiting', [
                'email' => $request->email,
                'ticket' => $ticket->name
            ]);
        }

        // ✅ Buat order dulu (BELUM ADA QR)
        $order = Order::create([
            'email' => $request->email,
            'ticket_id' => $ticket->id,
            'status' => 'pending', // penting!
        ]);

        // 🔥 Redirect ke halaman pembayaran
        return redirect('/payment/' . $order->id);
    }
}