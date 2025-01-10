<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MembershipTransaction;

class CheckMembershipTransaction
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Cek apakah user memiliki transaksi aktif
        $activeTransaction = MembershipTransaction::where('user_id', $user->id)
            ->where('end_date', '>=', now())
            ->latest('end_date') // Ambil transaksi terbaru
            ->first();

        if (!$activeTransaction) {
            return response()->json(['message' => 'No active membership found.'], 403);
        }

        // Jika transaksi aktif ditemukan, lanjutkan ke rute berikutnya
        return $next($request);
    }
}
