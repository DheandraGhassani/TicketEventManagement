<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Event;
use App\Models\ETicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan ini
use Illuminate\Support\Facades\DB;   // Tambahkan ini untuk selectRaw

class DashboardController extends Controller
{
    public function index()
    {
        // Gunakan Auth::user() yang lebih standar
        $user = Auth::user();

        if (in_array($user->role, ['admin', 'organizer'])) {
            $totalRevenue     = Order::where('status', 'paid')->sum('total_amount');
            
            // Perbaikan: Pastikan relasi 'order' di OrderItem sudah ada jika ingin filter paid
            $totalTicketsSold = OrderItem::whereHas('order', function($q) {
                $q->where('status', 'paid');
            })->sum('quantity');

            $activeEvents     = Event::where('status', 'published')->count();
            $recentOrders     = Order::with('user')->latest()->take(5)->get();

            // Gunakan DB::raw agar query selectRaw dikenali IDE
            $salesData = Order::select(
                    DB::raw('DATE(created_at) as date'), 
                    DB::raw('SUM(total_amount) as revenue')
                )
                ->where('status', 'paid')
                ->groupBy('date')
                ->orderBy('date')
                ->take(7)
                ->get();

            return view('dashboard.admin', compact(
                'totalRevenue', 'totalTicketsSold', 'activeEvents', 'recentOrders', 'salesData'
            ));
        }

        // Dashboard User - Pastikan kolom di database adalah 'users_id' sesuai migration kita
        $myTickets = ETicket::where('users_id', $user->id)
            ->with(['event', 'orderItem.ticketType']) // Eager load agar tidak N+1 query
            ->latest()
            ->get();
            
        return view('dashboard.user', compact('myTickets'));
    }

    public function exportExcel()
    {
        // Pastikan package Maatwebsite/Laravel-Excel sudah terinstall
        // Jika belum: composer require maatwebsite/excel
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\SalesReportExport,
            'laporan-penjualan-' . now()->format('Y-m-d') . '.xlsx'
        );
    }
}