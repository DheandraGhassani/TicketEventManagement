<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['orders_id', 'ticket_types_id', 'quantity', 'subtotal'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'orders_id');
    }

    public function ticketType()
    {
        return $this->belongsTo(TicketType::class, 'ticket_types_id');
    }

    public function eTickets()
    {
        return $this->hasMany(ETicket::class, 'order_items_id');
    }
}
