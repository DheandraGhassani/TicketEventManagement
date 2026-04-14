<?php

// app/Models/Event.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['title', 'slug', 'description', 'banner_url', 'venue_name', 'address', 'city', 'start_date', 'status', 'is_featured', 'users_id', 'categories_id'];

    protected $casts = [
        'start_date' => 'datetime',
        'is_featured' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id');
    }

    public function ticketTypes()
    {
        return $this->hasMany(TicketType::class, 'events_id'); // ← fix
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'events_id'); // ← fix
    }

    public function eTickets()
    {
        return $this->hasMany(ETicket::class, 'events_id'); // ← fix
    }

    public function waitingLists()
    {
        return $this->hasMany(WaitingList::class, 'events_id'); // ← fix
    }

    public function notifications()
    {
        return $this->belongsToMany(Notification::class, 'events_has_notifications', 'events_id', 'notifications_id'); // ← fix
    }
}
