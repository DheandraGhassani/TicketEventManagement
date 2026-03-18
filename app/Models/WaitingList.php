<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaitingList extends Model
{
    public function event() { return $this->belongsTo(Event::class); }
    public function user() { return $this->belongsTo(User::class); }
    public function notifications() { return $this->belongsToMany(Notification::class, 'waiting_lists_has_notifications'); }
}
