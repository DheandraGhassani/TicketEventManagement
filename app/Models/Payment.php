<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['transaction_id', 'payment_method', 'paid_at'];

    protected $casts = ['paid_at' => 'datetime'];

    public function order()
    {
        return $this->hasOne(Order::class, 'payments_id');
    }

    public function notifications()
    {
        return $this->belongsToMany(Notification::class, 'payments_has_notifications');
    }
}
