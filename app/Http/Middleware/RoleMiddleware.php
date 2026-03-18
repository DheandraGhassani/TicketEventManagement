<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Middleware ini mendukung multiple role, contoh:
     * ->middleware('role:admin')
     * ->middleware('role:admin,organizer')
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan login terlebih dahulu!'
                ], 401);
            }

            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu!');
        }

        $user = Auth::user();

        // 2. Cek apakah user memiliki salah satu role yang diizinkan
        // Menggunakan in_array lebih efisien daripada foreach manual
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // 3. Jika role tidak cocok
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak! Role Anda tidak diizinkan.'
            ], 403);
        }

        $roleList = implode(', ', $roles);
        return redirect()->route('dashboard')
            ->with('error', "Akses ditolak! Halaman ini hanya untuk role: {$roleList}");
    }
}