<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Http\Request;

class TicketTypeController extends Controller
{
    public function index(Event $event)
    {
        $ticketTypes = $event->ticketTypes()->latest()->get();

        return view('ticket-types.index', compact('event', 'ticketTypes'));
    }

    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:1',
            'sale_start' => 'nullable|date',
            'sale_end' => 'nullable|date|after_or_equal:sale_start',
        ]);

        $validated['events_id'] = $event->id;
        TicketType::create($validated);

        return redirect()->route('events.show', $event)
            ->with('success', 'Jenis tiket berhasil ditambahkan!');
    }

    public function edit(TicketType $ticketType)
    {
        return view('ticket-types.edit', compact('ticketType'));
    }

    public function update(Request $request, TicketType $ticketType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:' . $ticketType->sold_count,
            'sale_start' => 'nullable|date',
            'sale_end' => 'nullable|date|after_or_equal:sale_start',
        ]);
        $ticketType->update($validated);

        return redirect()->route('events.show', $ticketType->event)
            ->with('success', 'Jenis tiket berhasil diupdate!');
    }

    public function destroy(TicketType $ticketType)
    {
        $ticketType->delete();

        return back()->with('success', 'Jenis tiket berhasil dihapus!');
    }
}
