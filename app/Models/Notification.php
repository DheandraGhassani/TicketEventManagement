<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public function events() { return $this->belongsToMany(Event::class, 'events_has_notifications'); }
    public function payments() { return $this->belongsToMany(Payment::class, 'payments_has_notifications'); }
    public function waitingLists() { return $this->belongsToMany(WaitingList::class, 'waiting_lists_has_notifications'); }
}
