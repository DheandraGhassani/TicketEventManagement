<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\WaitingList;
use Illuminate\Support\Facades\Auth;

class WaitingListController extends Controller
{
    public function index()
    {
        $waitingLists = WaitingList::where('users_id', Auth::id())
            ->with('event')
            ->latest()
            ->get();

        return view('waiting-list.index', compact('waitingLists'));
    }

    public function join(Event $event)
    {
        $exists = WaitingList::where('events_id', $event->id)
            ->where('users_id', Auth::id())
            ->exists();

        if ($exists) {
            return back()->with('info', 'Kamu sudah terdaftar di waiting list event ini.');
        }

        WaitingList::create([
            'events_id' => $event->id,
            'users_id' => Auth::id(),
        ]);

        return back()->with('success', 'Berhasil bergabung ke waiting list!');
    }

    public function leave(Event $event)
    {
        WaitingList::where('events_id', $event->id)
            ->where('users_id', Auth::id())
            ->delete();

        return back()->with('success', 'Berhasil keluar dari waiting list.');
    }
}
