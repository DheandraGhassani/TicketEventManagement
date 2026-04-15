<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
  protected $fillable = ['event_id','name', 'stock', 'price'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
