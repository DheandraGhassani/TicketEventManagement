<?php

namespace App\Http\Controllers;

use App\Exports\SalesReportExport;
use App\Models\ETicket;
use App\Models\Event;
use App\Models\Order;
use App\Models\OrderItem; // Tambahkan ini
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

   // Tambahkan ini untuk selectRaw

class DashboardController extends Controller
{
    public function index()
    {
        // Gunakan Auth::user() yang lebih standar
        $user = Auth::user();

        if (in_array($user->role, ['admin', 'organizer'])) {
            $totalRevenue = Order::where('status', 'paid')->sum('total_amount');

            // Perbaikan: Pastikan relasi 'order' di OrderItem sudah ada jika ingin filter paid
            $totalTicketsSold = OrderItem::whereHas('order', function ($q) {
                $q->where('status', 'paid');
            })->sum('quantity');

            $activeEvents = Event::where('status', 'published')->count();
            $recentOrders = Order::with('user')->latest()->take(5)->get();

            // Gunakan DB::raw agar query selectRaw dikenali IDE
            $salesData = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as revenue')
            )
                ->where('status', 'paid')
                ->where('created_at', '>=', now()->subDays(6)->startOfDay())
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderBy('date')
                ->get();

            return view('dashboard.admin', compact(
                'totalRevenue', 'totalTicketsSold', 'activeEvents', 'recentOrders', 'salesData'
            ));
        }

        $pendingOrders = Order::with(['event', 'orderItems.ticketType'])
            ->where('users_id', $user->id)
            ->where('status', 'pending')
            ->latest()
            ->get();

        $myTickets = ETicket::where('users_id', $user->id)
            ->with(['event', 'orderItem.ticketType'])
            ->latest()
            ->get();

        return view('dashboard.user', compact('pendingOrders', 'myTickets'));
    }

    public function exportExcel()
    {
        // Pastikan package Maatwebsite/Laravel-Excel sudah terinstall
        // Jika belum: composer require maatwebsite/excel
        return Excel::download(
            new SalesReportExport,
            'laporan-penjualan-'.now()->format('Y-m-d').'.xlsx'
        );
    }
}
