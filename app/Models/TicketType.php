<?php

// app/Models/TicketType.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    protected $fillable = ['name', 'description', 'price', 'quota', 'sold_count', 'sale_start', 'sale_end', 'is_active', 'events_id', 'users_id'];

    public function event()
    {
        return $this->belongsTo(Event::class, 'events_id'); // ← fix
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'ticket_types_id'); // ← fix
    }
}
