<?php

namespace App\Http\Controllers;

use App\Models\ETicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan ini agar Auth dikenali IDE

class ETicketController extends Controller
{
    public function scan(Request $request)
    {
        // Pastikan input ticket_code ada
        $request->validate([
            'ticket_code' => 'required|string'
        ]);

        $ticket = ETicket::where('ticket_code', $request->ticket_code)->firstOrFail();

        if ($ticket->status === 'scanned') {
            return response()->json([
                'success' => false, 
                'message' => 'Tiket sudah pernah discan!'
            ], 400); // Tambahkan status code 400 (Bad Request)
        }

        // Gunakan Auth::id() - lebih stabil dan tidak menyebabkan error 'Undefined method'
        $ticket->update([
            'status'     => 'scanned',
            'scanned_at' => now(),
            'scanned_by' => Auth::id(), 
        ]);

        return response()->json([
            'success' => true,
            'message' => '✅ Tiket berhasil discan!',
            'ticket'  => $ticket
        ]);
    }
}