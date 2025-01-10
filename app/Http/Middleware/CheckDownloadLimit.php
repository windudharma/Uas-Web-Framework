<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MembershipTransaction;

class CheckDownloadLimit
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();  // Ambil pengguna yang sedang login

        // Cari transaksi membership aktif
        $activeMembership = MembershipTransaction::where('user_id', $user->id)
            ->where('end_date', '>=', now())
            ->latest('start_date')
            ->first();

        if (!$activeMembership) {
            return redirect()->route('subscription')->with('error', 'Anda tidak memiliki membership aktif.');
        }

        $dailyLimit = $activeMembership->membership->daily_limit;

        // Cek apakah unduhan sudah dilakukan hari ini menggunakan session
        $today = now()->toDateString();  // Format YYYY-MM-DD

        // Jika unduhan sudah dilakukan hari ini (di session), jangan tambah downloads_today
        if (session()->has('downloaded_today') && session('downloaded_today') == $today) {
            return $next($request);  // Lewati penambahan unduhan hari ini
        }

        // Jika unduhan belum dilakukan hari ini, pastikan batas unduhan belum tercapai
        if ($activeMembership->downloads_today >= $dailyLimit) {
            return redirect('/membership')->with('error', 'Anda telah mencapai batas maksimum unduhan hari ini.');
        }

        // Increment downloads_today jika belum mencapai batas dan belum diunduh hari ini
        $activeMembership->increment('downloads_today');

        // Simpan status unduhan di session
        session(['downloaded_today' => $today]);

        return $next($request);
    }
}
