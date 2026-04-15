<?php

namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('payment', compact('order'));
    }

    public function pay($id)
    {
        $order = Order::findOrFail($id);

        // SIMULASI BERHASIL
        $order->status = 'paid';

        // generate QR
        $code = Str::uuid();
        $qr = QrCode::format('svg')->size(200)->generate(url('/scan/'.$code));

        Storage::disk('public')->put('qr/'.$code.'.svg', $qr);

        $order->qr_code = 'qr/'.$code.'.svg';

        // kurangi stok
        $order->ticket->decrement('stock');

        $order->save();

        return redirect('/success/'.$order->id);
    }

    public function fail($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'failed';
        $order->save();

        return view('payment_failed', compact('order'));
    }
}
