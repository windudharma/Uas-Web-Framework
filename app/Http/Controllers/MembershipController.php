<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\MembershipTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    /**
     * Halaman checkout untuk konfirmasi paket.
     */
    public function checkout($membershipId)
    {
        $membership = Membership::findOrFail($membershipId);
        return view('pages.checkout', compact('membership'));
    }

    /**
     * Proses checkout dan arahkan ke halaman Thank You.
     */
    public function processCheckout(Request $request, $membershipId)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login')->with('error', 'Anda harus login untuk melanjutkan.');
        }

        $membership = Membership::findOrFail($membershipId);

        // Cek transaksi aktif
        $activeTransaction = MembershipTransaction::where('user_id', auth()->id())
        ->where('end_date', '>=', now())
        ->orderByDesc('membership_id') // Selalu prioritaskan level membership tertinggi
        ->orderByDesc('end_date')      // Jika level sama, ambil tanggal akhir terbaru
        ->first();


        // Aturan 1: Tidak bisa membeli paket lebih rendah
        if ($activeTransaction && $activeTransaction->membership_id > $membershipId) {
            return redirect()->route('membership.checkout', $membershipId)
                ->with('error', 'Anda tidak dapat membeli membership dengan level lebih rendah.');
        }

        // Aturan 2: Jika paket setara, perpanjang
        if ($activeTransaction && $activeTransaction->membership_id == $membershipId) {
            $activeTransaction->update([
                'end_date' => $activeTransaction->end_date->addDays($membership->duration_days),
            ]);

            MembershipTransaction::create([
                'user_id' => $user->id,
                'membership_id' => $membershipId,
                'start_date' => $activeTransaction->end_date,
                'end_date' => $activeTransaction->end_date->addDays($membership->duration_days),
                'amount_paid' => $membership->price,
                'transaction_type' => 'renewal',
            ]);

            return redirect()->route('membership.thankYou');
        }

        // Aturan 3: Jika paket lebih tinggi, upgrade
        MembershipTransaction::create([
            'user_id' => $user->id,
            'membership_id' => $membershipId,
            'start_date' => now(),
            'end_date' => now()->addDays($membership->duration_days),
            'amount_paid' => $membership->price,
            'transaction_type' => 'upgrade',
        ]);

        return redirect()->route('membership.thankYou');
    }

    /**
     * Halaman Thank You setelah transaksi berhasil.
     */
    public function thankYou()
    {
        return view('pages.thankyou');
    }
}
