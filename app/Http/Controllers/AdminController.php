<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\WaitingList;
use App\Models\Event;

class AdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | GLOBAL DASHBOARD (SEMUA EVENT)
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $events = Event::all();
        $orders = Order::with('ticket')->get();

        $totalOrders = $orders->count();
        $paid = $orders->where('status', 'paid')->count();
        $pending = $orders->where('status', 'pending')->count();
        $failed = $orders->where('status', 'failed')->count();

        $revenue = $orders->where('status', 'paid')
            ->sum(fn($o) => $o->ticket->price ?? 0);

        return view('admin.dashboard', compact(
            'events',
            'totalOrders',
            'paid',
            'pending',
            'failed',
            'revenue'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD PER EVENT
    |--------------------------------------------------------------------------
    */
    public function eventDashboard($id)
    {
        $event = Event::with('tickets')->findOrFail($id);

        $orders = Order::whereHas('ticket', function ($q) use ($id) {
            $q->where('event_id', $id);
        })->with('ticket')->get();

        $totalOrders = $orders->count();
        $paid = $orders->where('status', 'paid')->count();
        $pending = $orders->where('status', 'pending')->count();
        $failed = $orders->where('status', 'failed')->count();

        $soldTickets = $orders->where('status', 'paid')->count();

        $revenue = $orders->where('status', 'paid')
            ->sum(fn($o) => $o->ticket->price ?? 0);

        $conversion = $totalOrders > 0
            ? round(($paid / $totalOrders) * 100, 2)
            : 0;

        return view('admin.event_dashboard', compact(
            'event',
            'orders',
            'totalOrders',
            'paid',
            'pending',
            'failed',
            'soldTickets',
            'revenue',
            'conversion'
        ));
    }

    // FORM CREATE EVENT
    public function createEvent()
    {
        return view('admin.create_event');
    }

    // SIMPAN EVENT
    public function storeEvent(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'date' => 'required',
            'location' => 'required',
        ]);

        \App\Models\Event::create([
            'name' => $request->name,
            'date' => $request->date,
            'location' => $request->location,
        ]);

        return redirect('/admin')->with('success', 'Event berhasil dibuat!');
    }

    /*
    |--------------------------------------------------------------------------
    | TAMBAH TIKET (PER EVENT) ✅ FIX ERROR event_id
    |--------------------------------------------------------------------------
    */
    public function storeTicketByEvent(Request $request, $eventId)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        Ticket::create([
            'event_id' => $eventId, // 🔥 INI YANG PENTING
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return back()->with('success', 'Tiket berhasil ditambahkan!');
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE TIKET
    |--------------------------------------------------------------------------
    */
    public function updateTicket(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $request->validate([
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $ticket->update([
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return back()->with('success', 'Tiket berhasil diupdate!');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE TIKET
    |--------------------------------------------------------------------------
    */
    public function deleteTicket($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return back()->with('success', 'Tiket berhasil dihapus!');
    }

    /*
    |--------------------------------------------------------------------------
    | WAITING LIST
    |--------------------------------------------------------------------------
    */
    public function waitingList()
    {
        $waiting = WaitingList::orderBy('created_at', 'desc')->get();
        return view('admin.waiting_list', compact('waiting'));
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL ORDER
    |--------------------------------------------------------------------------
    */
    public function orderDetail($id)
    {
        $order = Order::with('ticket')->findOrFail($id);
        return view('admin.order_detail', compact('order'));
    }
}