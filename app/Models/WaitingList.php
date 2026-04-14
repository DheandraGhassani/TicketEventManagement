<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaitingList extends Model
{
    protected $fillable = ['events_id', 'users_id'];

    public function event()
    {
        return $this->belongsTo(Event::class, 'events_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function notifications()
    {
        return $this->belongsToMany(Notification::class, 'waiting_lists_has_notifications');
    }
}
