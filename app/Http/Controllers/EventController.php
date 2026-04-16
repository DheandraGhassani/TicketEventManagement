<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with(['category', 'ticketTypes'])->latest()->paginate(10);

        return view('events.index', compact('events'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();

        return view('events.create', compact('categories'));
    }

    public function store(Request $request)
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        $validated = $request->validate([
            'title' => 'required|string|max:220',
            'description' => 'nullable',
            'banner' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'venue_name' => 'required|string|max:200',
            'address' => 'nullable',
            'city' => 'required|string|max:100',
            'start_date' => 'required|date',
            'categories_id' => 'required|exists:categories,id',
            'status' => 'required|in:draft,published,cancelled,completed',
        ]);

        if ($request->hasFile('banner')) {
            $validated['banner_url'] = $request->file('banner')->store('banners', 'public');
        }

        $validated['users_id'] = Auth::id();
        $validated['slug'] = Str::slug($validated['title']);

        Event::create($validated);

        return redirect()->route('events.index')->with('success', 'Event berhasil dibuat!');
    }

    public function show(Event $event)
    {
        $event->load(['category', 'ticketTypes', 'user', 'waitingLists']);

        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $categories = Category::where('is_active', true)->get();

        return view('events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, Event $event)
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        $validated = $request->validate([
            'title' => 'required|string|max:220',
            'description' => 'nullable',
            'banner' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'venue_name' => 'required|string|max:200',
            'city' => 'required|string|max:100',
            'start_date' => 'required|date',
            'categories_id' => 'required|exists:categories,id',
            'status' => 'required|in:draft,published,cancelled,completed',
        ]);

        if ($request->hasFile('banner')) {
            if ($event->banner_url) {
                Storage::disk('public')->delete($event->banner_url);
            }
            $validated['banner_url'] = $request->file('banner')->store('banners', 'public');
        }

        $validated['slug'] = Str::slug($validated['title']);
        $event->update($validated);

        return redirect()->route('events.index')->with('success', 'Event berhasil diupdate!');
    }

    public function destroy(Event $event)
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        if ($event->banner_url) {
            Storage::disk('public')->delete($event->banner_url);
        }
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event berhasil dihapus!');
    }
}
