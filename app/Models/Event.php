<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['title','description','banner_url','venue_name','address','city','start_date','status','is_featured','users_id','categories_id'];

    public function user() { return $this->belongsTo(User::class, 'users_id'); }
    public function category() { return $this->belongsTo(Category::class, 'categories_id'); }
    public function ticketTypes() { return $this->hasMany(TicketType::class); }
    public function orders() { return $this->hasMany(Order::class); }
    public function eTickets() { return $this->hasMany(ETicket::class); }
    public function waitingLists() { return $this->hasMany(WaitingList::class); }
    public function notifications() { return $this->belongsToMany(Notification::class, 'events_has_notifications'); }
}
