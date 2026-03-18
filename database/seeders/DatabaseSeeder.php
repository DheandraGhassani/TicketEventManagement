<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Event;
use App\Models\TicketType;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ETicket;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // --- 1. SEED USERS (Role: admin, organizer, user) ---
        $admin = User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $organizer = User::create([
            'name' => 'EO Jakarta Pro',
            'email' => 'organizer@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'organizer',
        ]);

        $customer = User::create([
            'name' => 'Budi Pembeli',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // --- 2. SEED CATEGORIES ---
        $categories = [
            ['name' => 'Music Concert', 'slug' => 'music-concert', 'icon' => 'fas fa-music'],
            ['name' => 'Workshop Tech', 'slug' => 'workshop-tech', 'icon' => 'fas fa-laptop-code'],
            ['name' => 'Sports Event', 'slug' => 'sports-event', 'icon' => 'fas fa-running'],
        ];

        foreach ($categories as $cat) {
            $createdCat = Category::create($cat);
            $catIds[] = $createdCat->id;
        }

        // --- 3. SEED EVENTS ---
        $event = Event::create([
            'title' => 'Jakarta K-Pop Festival 2026',
            'slug' => 'jakarta-kpop-festival-2026',
            'description' => 'Festival musik K-Pop terbesar di Indonesia dengan bintang tamu internasional.',
            'venue_name' => 'Stadion Madya GBK',
            'city' => 'Jakarta Pusat',
            'address' => 'Jl. Pintu Satu Senayan, Gelora, Kec. Tanah Abang',
            'start_date' => now()->addDays(30),
            'status' => 'published',
            'is_featured' => true,
            'users_id' => $organizer->id,
            'categories_id' => $catIds[0], // Music
        ]);

        // --- 4. SEED TICKET TYPES ---
        $vip = TicketType::create([
            'name' => 'VIP Section',
            'price' => 2500000,
            'quota' => 50,
            'sold_count' => 2, // Simulasi terjual 2
            'events_id' => $event->id,
        ]);

        $reg = TicketType::create([
            'name' => 'Regular',
            'price' => 750000,
            'quota' => 200,
            'sold_count' => 5, // Simulasi terjual 5
            'events_id' => $event->id,
        ]);

        // --- 5. SEED ORDERS (Simulasi Penjualan untuk Grafik Dashboard) ---
        // Kita buat 5 order dalam 5 hari terakhir agar grafik tidak datar
        for ($i = 0; $i < 5; $i++) {
            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'total_amount' => 750000,
                'status' => 'paid',
                'expired_at' => now()->addHours(24),
                'users_id' => $customer->id,
                'events_id' => $event->id,
                'created_at' => now()->subDays(5 - $i),
            ]);

            $orderItem = OrderItem::create([
                'orders_id' => $order->id,
                'ticket_types_id' => $reg->id,
                'quantity' => 1,
                'subtotal' => 750000,
            ]);

            // --- 6. SEED E-TICKET ---
            ETicket::create([
                'ticket_code' => 'TIX-' . strtoupper(Str::random(8)),
                'qr_code_data' => 'SIMULASI_QR_DATA_' . Str::random(5),
                'status' => 'valid',
                'order_items_id' => $orderItem->id,
                'users_id' => $customer->id,
                'events_id' => $event->id,
            ]);
        }

        $this->command->info('✅ Database Seeded Successfully!');
        $this->command->warn('Admin Login: admin@gmail.com | password');
    }
}