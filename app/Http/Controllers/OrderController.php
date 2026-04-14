<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'ticket_types' => 'required|array',
        ]);

        $event = Event::findOrFail($validated['event_id']);

        return DB::transaction(function () use ($validated, $event) {
            $total = 0;
            $orderItemsData = [];

            foreach ($validated['ticket_types'] as $id => $qty) {
                $qty = (int) $qty;
                if ($qty <= 0) {
                    continue;
                }

                $type = TicketType::lockForUpdate()->findOrFail($id);

                if ($type->sold_count + $qty > $type->quota) {
                    throw new \Exception('Kuota tiket "'.$type->name.'" tidak mencukupi!');
                }

                $subtotal = $type->price * $qty;
                $total += $subtotal;

                $orderItemsData[] = [
                    'ticket_types_id' => $id,
                    'quantity' => $qty,
                    'subtotal' => $subtotal,
                ];

                $type->increment('sold_count', $qty);
            }

            if (empty($orderItemsData)) {
                throw new \Exception('Silakan pilih minimal satu tiket.');
            }

            $order = Order::create([
                'order_number' => 'ORD-'.strtoupper(Str::random(10)),
                'total_amount' => $total,
                'status' => 'pending',
                'expired_at' => now()->addHours(24),
                'users_id' => Auth::id(),
                'events_id' => $event->id,
            ]);

            foreach ($orderItemsData as $item) {
                $item['orders_id'] = $order->id;
                OrderItem::create($item);
            }

            return redirect()->route('orders.show', $order->id)
                ->with('info', 'Order dibuat. Silakan selesaikan pembayaran.');
        });
    }

    public function show($id)
    {
        $order = Order::with(['orderItems.ticketType', 'event'])->findOrFail($id);

        if ($order->users_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status === 'paid') {
            return redirect()->route('orders.success', $order->id);
        }

        return view('orders.show', compact('order'));
    }

    public function success($id)
    {
        $order = Order::with(['orderItems.ticketType', 'orderItems.eTickets', 'event'])->findOrFail($id);

        if ($order->users_id !== Auth::id()) {
            abort(403);
        }

        return view('orders.success', compact('order'));
    }
}
