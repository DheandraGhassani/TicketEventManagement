<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\Ticket;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        // EVENT 1
        $event1 = Event::create([
            'name' => 'Music Festival 2026',
            'description' => 'Festival musik terbesar dengan artis internasional.',
            'location' => 'Jakarta',
            'date' => '2026-06-10',
        ]);

        Ticket::create([
            'event_id' => $event1->id,
            'name' => 'VIP',
            'price' => 1000000,
            'stock' => 50,
        ]);

        Ticket::create([
            'event_id' => $event1->id,
            'name' => 'Regular',
            'price' => 500000,
            'stock' => 100,
        ]);

        // EVENT 2
        $event2 = Event::create([
            'name' => 'Tech Conference',
            'description' => 'Konferensi teknologi dan startup.',
            'location' => 'Bandung',
            'date' => '2026-07-15',
        ]);

        Ticket::create([
            'event_id' => $event2->id,
            'name' => 'Early Bird',
            'price' => 300000,
            'stock' => 30,
        ]);

        Ticket::create([
            'event_id' => $event2->id,
            'name' => 'Normal',
            'price' => 600000,
            'stock' => 80,
        ]);

        // EVENT 3
        $event3 = Event::create([
            'name' => 'Seminar Bisnis',
            'description' => 'Belajar strategi bisnis dari expert.',
            'location' => 'Surabaya',
            'date' => '2026-08-01',
        ]);

        Ticket::create([
            'event_id' => $event3->id,
            'name' => 'VIP',
            'price' => 750000,
            'stock' => 40,
        ]);

        Ticket::create([
            'event_id' => $event3->id,
            'name' => 'Regular',
            'price' => 350000,
            'stock' => 90,
        ]);
    }
}