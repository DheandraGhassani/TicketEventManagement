<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ETicket extends Model
{
    protected $fillable = ['ticket_code', 'qr_code_data', 'status', 'scanned_at', 'scanned_by', 'order_items_id', 'users_id', 'events_id'];
    protected $casts = [
        'scanned_at' => 'datetime',
    ];
    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class, 'order_items_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'events_id');
    }
}
