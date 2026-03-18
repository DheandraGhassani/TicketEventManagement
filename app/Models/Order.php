<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['order_number', 'total_amount', 'status', 'expired_at', 'users_id', 'events_id', 'payments_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'events_id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payments_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'orders_id');
    }
}
