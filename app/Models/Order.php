<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['email', 'ticket_id', 'qr_code', 'is_valid'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
