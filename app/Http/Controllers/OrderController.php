<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ETicket;
use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth; // Tambahkan ini
use App\Mail\TicketMail;
use Illuminate\Support\Facades\DB;   // Tambahkan untuk Database Transaction

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id'     => 'required|exists:events,id',
            'ticket_types' => 'required|array',
        ]);

        $event = Event::findOrFail($validated['event_id']);

        // Gunakan Transaction agar jika satu gagal, semua dibatalkan (mencegah data korup)
        return DB::transaction(function () use ($validated, $event) {
            $total = 0;
            $orderItemsData = [];

            foreach ($validated['ticket_types'] as $id => $qty) {
                if ($qty <= 0) continue; // Abaikan jika input 0 atau negatif

                $type = TicketType::lockForUpdate()->findOrFail($id);
                
                if ($type->sold_count + $qty > $type->quota) {
                    throw new \Exception('Kuota tiket ' . $type->name . ' tidak mencukupi!');
                }

                $subtotal = $type->price * $qty;
                $total += $subtotal;

                $orderItemsData[] = [
                    'ticket_types_id' => $id,
                    'quantity'        => $qty,
                    'subtotal'        => $subtotal,
                ];

                $type->increment('sold_count', $qty);
            }

            if (empty($orderItemsData)) {
                return back()->with('error', 'Silakan pilih minimal satu tiket.');
            }

            // Create Order
            $order = Order::create([
                'order_number'  => 'ORD-' . strtoupper(Str::random(10)),
                'total_amount'  => $total,
                'status'        => 'paid', // Langsung paid karena ini simulasi
                'expired_at'    => now()->addHours(24),
                'users_id'      => Auth::id(),
                'events_id'     => $event->id,
            ]);

            foreach ($orderItemsData as $item) {
                $item['orders_id'] = $order->id;
                $orderItem = OrderItem::create($item);

                for ($i = 0; $i < $item['quantity']; $i++) {
                    $ticketCode = 'TIX-' . strtoupper(Str::random(8));
                    
                    // PERBAIKAN: QrCode::generate() menghasilkan string SVG. 
                    // Pastikan di database kolom qr_code_data bertipe TEXT.
                    $qr = QrCode::size(300)->format('svg')->generate($ticketCode);

                    ETicket::create([
                        'ticket_code'    => $ticketCode,
                        'qr_code_data'   => $qr,
                        'status'         => 'valid',
                        'order_items_id' => $orderItem->id,
                        'users_id'       => Auth::id(),
                        'events_id'      => $event->id,
                    ]);
                }
            }

            // PERBAIKAN: Typo auth()->use() menjadi auth()->user()
            try {
                Mail::to(Auth::user()->email)->send(new TicketMail($order));
            } catch (\Exception $e) {
                // Jangan hentikan proses jika email gagal, tapi catat lognya
                Log::error("Email gagal dikirim: " . $e->getMessage());
            }

            return redirect()->route('orders.success', $order->id)
                            ->with('success', '✅ Pembelian berhasil! Tiket dikirim ke email.');
        });
    }

    public function success($id)
    {
        $order = Order::with(['orderItems.ticketType', 'eTickets'])->findOrFail($id);
        return view('orders.success', compact('order'));
    }
}