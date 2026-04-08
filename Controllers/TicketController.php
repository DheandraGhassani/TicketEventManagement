<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Order;
use App\Models\WaitingList;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Mail\TicketMail;

class TicketController extends Controller
{
    public function buy(Request $request)
    {
        $ticket = Ticket::find($request->ticket_id);

        if ($ticket->stock > 0) {

            $ticket->decrement('stock');

            $code = Str::uuid();
            $scanUrl = url('/scan/'.$code);

            $qr = QrCode::format('svg')->size(200)->generate($scanUrl);

            // simpan ke public disk
            Storage::disk('public')->put('qr/'.$code.'.svg', $qr);

            // simpan path RELATIVE (tanpa public/)
            $order = Order::create([
                'email' => $request->email,
                'ticket_id' => $ticket->id,
                'qr_code' => 'qr/'.$code.'.svg',
            ]);

            Mail::to($request->email)->queue(new TicketMail($order));

            return view('success', compact('order'));
        } else {

            WaitingList::create([
                'email' => $request->email,
                'ticket_id' => $ticket->id,
            ]);

            return view('waiting', [
                'email' => $request->email,
                'ticket' => $ticket->name
            ]);
        }
    }
}
