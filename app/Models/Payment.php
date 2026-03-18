<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function order() { return $this->hasOne(Order::class); }
    public function notifications() { return $this->belongsToMany(Notification::class, 'payments_has_notifications'); }
}
