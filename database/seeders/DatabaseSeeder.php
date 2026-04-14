<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ETicket;
use App\Models\Event;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\TicketType;
use App\Models\User;
use App\Models\WaitingList;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─────────────────────────────────────────
        // 1. USERS
        // ─────────────────────────────────────────
        $admin = User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '08111000001',
        ]);

        $organizer = User::create([
            'name' => 'EO Jakarta Pro',
            'email' => 'organizer@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'organizer',
            'phone' => '08111000002',
        ]);

        $user1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'phone' => '08111000003',
        ]);

        $user2 = User::create([
            'name' => 'Siti Rahma',
            'email' => 'siti@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'phone' => '08111000004',
        ]);

        $user3 = User::create([
            'name' => 'Rizky Pratama',
            'email' => 'rizky@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'phone' => '08111000005',
        ]);

        // ─────────────────────────────────────────
        // 2. CATEGORIES
        // ─────────────────────────────────────────
        $catMusic = Category::create(['name' => 'Music Concert', 'slug' => 'music-concert', 'icon' => '🎵', 'is_active' => true]);
        $catTech = Category::create(['name' => 'Workshop Tech', 'slug' => 'workshop-tech', 'icon' => '💻', 'is_active' => true]);
        $catSport = Category::create(['name' => 'Sports Event', 'slug' => 'sports-event', 'icon' => '⚽', 'is_active' => true]);
        $catArt = Category::create(['name' => 'Arts & Culture', 'slug' => 'arts-culture', 'icon' => '🎨', 'is_active' => true]);
        $catBusiness = Category::create(['name' => 'Business Expo', 'slug' => 'business-expo', 'icon' => '💼', 'is_active' => false]);

        // ─────────────────────────────────────────
        // 3. EVENTS
        // ─────────────────────────────────────────

        // Event 1: Published — untuk demo pembelian
        $eventKpop = Event::create([
            'title' => 'Jakarta K-Pop Festival 2026',
            'slug' => 'jakarta-kpop-festival-2026',
            'description' => 'Festival musik K-Pop terbesar di Indonesia dengan bintang tamu internasional dari Korea Selatan. Nikmati penampilan live dari idol-idol favoritmu!',
            'venue_name' => 'Stadion Madya GBK',
            'city' => 'Jakarta Pusat',
            'address' => 'Jl. Pintu Satu Senayan, Gelora, Kec. Tanah Abang, Jakarta Pusat',
            'start_date' => now()->addDays(30),
            'status' => 'published',
            'users_id' => $organizer->id,
            'categories_id' => $catMusic->id,
        ]);

        // Event 2: Published — IT Conference
        $eventTech = Event::create([
            'title' => 'Tech Summit Indonesia 2026',
            'slug' => 'tech-summit-indonesia-2026',
            'description' => 'Konferensi teknologi terbesar di Indonesia. Pelajari tren AI, Cloud Computing, dan Web Development dari para ahli industri.',
            'venue_name' => 'Jakarta Convention Center',
            'city' => 'Jakarta Selatan',
            'address' => 'Jl. Gatot Subroto, Senayan, Jakarta Selatan',
            'start_date' => now()->addDays(15),
            'status' => 'published',
            'users_id' => $organizer->id,
            'categories_id' => $catTech->id,
        ]);

        // Event 3: Draft
        $eventSport = Event::create([
            'title' => 'Turnamen Futsal Piala Nusantara',
            'slug' => 'turnamen-futsal-piala-nusantara',
            'description' => 'Turnamen futsal antar komunitas se-Jabodetabek. Daftarkan tim kamu sekarang!',
            'venue_name' => 'GOR Soemantri Brodjonegoro',
            'city' => 'Jakarta Selatan',
            'address' => 'Jl. HR Rasuna Said, Kuningan, Jakarta Selatan',
            'start_date' => now()->addDays(45),
            'status' => 'draft',
            'users_id' => $organizer->id,
            'categories_id' => $catSport->id,
        ]);

        // Event 4: Completed — untuk data historis dashboard
        $eventPast = Event::create([
            'title' => 'Pameran Seni Kontemporer',
            'slug' => 'pameran-seni-kontemporer',
            'description' => 'Pameran karya seni kontemporer dari seniman lokal dan internasional.',
            'venue_name' => 'Museum Nasional Indonesia',
            'city' => 'Jakarta Pusat',
            'address' => 'Jl. Merdeka Barat No. 12, Jakarta Pusat',
            'start_date' => now()->subDays(10),
            'status' => 'completed',
            'users_id' => $organizer->id,
            'categories_id' => $catArt->id,
        ]);

        // ─────────────────────────────────────────
        // 4. TICKET TYPES
        // ─────────────────────────────────────────

        // Tiket K-Pop Festival
        $kpopVip = TicketType::create([
            'name' => 'VIP Platinum',
            'description' => 'Kursi paling depan, meet & greet, merchandise eksklusif',
            'price' => 3500000,
            'quota' => 50,
            'sold_count' => 12,
            'events_id' => $eventKpop->id,
        ]);
        $kpopVip2 = TicketType::create([
            'name' => 'VIP Gold',
            'description' => 'Area VIP, akses backstage',
            'price' => 2000000,
            'quota' => 100,
            'sold_count' => 35,
            'events_id' => $eventKpop->id,
        ]);
        $kpopReg = TicketType::create([
            'name' => 'Regular',
            'description' => 'Standing area',
            'price' => 750000,
            'quota' => 500,
            'sold_count' => 120,
            'events_id' => $eventKpop->id,
        ]);

        // Tiket Tech Summit
        $techEarly = TicketType::create([
            'name' => 'Early Bird',
            'description' => 'Harga spesial untuk pendaftar awal',
            'price' => 350000,
            'quota' => 100,
            'sold_count' => 100, // habis — untuk demo waiting list
            'events_id' => $eventTech->id,
        ]);
        $techStd = TicketType::create([
            'name' => 'Standard',
            'description' => 'Akses penuh semua sesi',
            'price' => 500000,
            'quota' => 300,
            'sold_count' => 300, // habis — trigger waiting list
            'events_id' => $eventTech->id,
        ]);
        $techPremium = TicketType::create([
            'name' => 'Premium Workshop',
            'description' => 'Termasuk workshop hands-on + sertifikat',
            'price' => 1200000,
            'quota' => 50,
            'sold_count' => 50, // habis — trigger waiting list
            'events_id' => $eventTech->id,
        ]);

        // Tiket Sport (Draft — bisa buat demo)
        TicketType::create([
            'name' => 'Penonton Umum',
            'price' => 50000,
            'quota' => 1000,
            'sold_count' => 0,
            'events_id' => $eventSport->id,
        ]);

        // Tiket Past Event (Completed)
        $artTicket = TicketType::create([
            'name' => 'Tiket Masuk',
            'price' => 100000,
            'quota' => 300,
            'sold_count' => 280,
            'events_id' => $eventPast->id,
        ]);

        // ─────────────────────────────────────────
        // 5. ORDERS + PAYMENTS + E-TICKETS (data historis 7 hari)
        // ─────────────────────────────────────────

        $buyers = [$user1, $user2, $user3];

        // Data untuk grafik: 7 hari terakhir, revenue bervariasi
        $orderData = [
            ['days_ago' => 6, 'type' => $kpopReg, 'qty' => 2, 'buyer' => $user1],
            ['days_ago' => 6, 'type' => $artTicket, 'qty' => 3, 'buyer' => $user2],
            ['days_ago' => 5, 'type' => $kpopVip2, 'qty' => 1, 'buyer' => $user3],
            ['days_ago' => 5, 'type' => $techStd, 'qty' => 2, 'buyer' => $user1],
            ['days_ago' => 4, 'type' => $kpopReg, 'qty' => 4, 'buyer' => $user2],
            ['days_ago' => 4, 'type' => $artTicket, 'qty' => 5, 'buyer' => $user3],
            ['days_ago' => 3, 'type' => $techPremium, 'qty' => 1, 'buyer' => $user1],
            ['days_ago' => 3, 'type' => $kpopVip, 'qty' => 2, 'buyer' => $user2],
            ['days_ago' => 2, 'type' => $techStd, 'qty' => 3, 'buyer' => $user3],
            ['days_ago' => 2, 'type' => $kpopReg, 'qty' => 2, 'buyer' => $user1],
            ['days_ago' => 1, 'type' => $kpopVip2, 'qty' => 1, 'buyer' => $user2],
            ['days_ago' => 1, 'type' => $artTicket, 'qty' => 4, 'buyer' => $user3],
            ['days_ago' => 0, 'type' => $techStd, 'qty' => 2, 'buyer' => $user1],
            ['days_ago' => 0, 'type' => $kpopReg, 'qty' => 1, 'buyer' => $user2],
        ];

        foreach ($orderData as $od) {
            $ticketType = $od['type'];
            $buyer = $od['buyer'];
            $qty = $od['qty'];
            $subtotal = $ticketType->price * $qty;

            // Payment record
            $payment = Payment::create([
                'payment_method' => collect(['transfer_bank', 'qris', 'virtual_account'])->random(),
                'transaction_id' => 'TRX-' . strtoupper(Str::random(10)),
                'paid_at' => now()->subDays($od['days_ago']),
            ]);

            // Order
            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'total_amount' => $subtotal,
                'status' => 'paid',
                'expired_at' => now()->addHours(24),
                'users_id' => $buyer->id,
                'events_id' => $ticketType->event->id,
                'payments_id' => $payment->id,
                'created_at' => now()->subDays($od['days_ago'])->subHours(rand(0, 8)),
                'updated_at' => now()->subDays($od['days_ago'])->subHours(rand(0, 8)),
            ]);

            // Order Item
            $orderItem = OrderItem::create([
                'orders_id' => $order->id,
                'ticket_types_id' => $ticketType->id,
                'quantity' => $qty,
                'subtotal' => $subtotal,
            ]);

            // E-Tickets dengan QR Code asli
            for ($i = 0; $i < $qty; $i++) {
                $ticketCode = 'TIX-' . strtoupper(Str::random(8));
                $qrData = QrCode::size(200)->format('svg')->generate($ticketCode);

                ETicket::create([
                    'ticket_code' => $ticketCode,
                    'qr_code_data' => $qrData,
                    'status' => 'valid',
                    'order_items_id' => $orderItem->id,
                    'users_id' => $buyer->id,
                    'events_id' => $ticketType->event->id,
                ]);
            }
        }

        // Satu order PENDING — untuk demo alur pembayaran
        $pendingOrder = Order::create([
            'order_number' => 'ORD-PENDING0001',
            'total_amount' => $kpopReg->price * 2,
            'status' => 'pending',
            'expired_at' => now()->addHours(24),
            'users_id' => $user3->id,
            'events_id' => $eventKpop->id,
        ]);
        OrderItem::create([
            'orders_id' => $pendingOrder->id,
            'ticket_types_id' => $kpopReg->id,
            'quantity' => 2,
            'subtotal' => $kpopReg->price * 2,
        ]);

        // ─────────────────────────────────────────
        // 6. WAITING LIST — demo untuk event yang tiketnya habis
        // ─────────────────────────────────────────
        WaitingList::create(['events_id' => $eventTech->id, 'users_id' => $user1->id]);
        WaitingList::create(['events_id' => $eventTech->id, 'users_id' => $user2->id]);
        WaitingList::create(['events_id' => $eventTech->id, 'users_id' => $user3->id]);

        // ─────────────────────────────────────────
        // Summary
        // ─────────────────────────────────────────
        $this->command->info('');
        $this->command->info('Database berhasil di-seed!');
        $this->command->info('');
        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['Admin', 'admin@gmail.com', 'password'],
                ['Organizer', 'organizer@gmail.com', 'password'],
                ['User 1', 'user@gmail.com', 'password'],
                ['User 2', 'siti@gmail.com', 'password'],
                ['User 3', 'rizky@gmail.com', 'password'],
            ]
        );
        $this->command->info('');
        $this->command->warn('Order PENDING demo: ORD-PENDING0001 (login sebagai rizky@gmail.com)');
        $this->command->warn('Waiting List demo: Tech Summit Early Bird habis, user1/2/3 sudah di waiting list');
    }
}
