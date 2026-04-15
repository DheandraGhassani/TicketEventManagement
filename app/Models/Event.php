<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['name', 'date', 'location'];
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
