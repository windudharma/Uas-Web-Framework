<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Membership;
use App\Models\MembershipTransaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;


class HomeController extends Controller
{

    public function index()
    {
        $assets = Asset::withCount('downloadHistories')
            ->orderBy('download_histories_count', 'desc') // Urutkan dari yang paling banyak diunduh
            ->where('is_aktif', 1) // Hanya ambil aset yang aktif
            ->take(15) // Ambil hanya 15 data
            ->get();

        // Ambil semua data membership
        $memberships = Membership::all();

        // Ambil membership aktif user jika login
        $activeMembership = null;
        if (auth()->check()) {
            $activeMembership = MembershipTransaction::where('user_id', auth()->id())
                ->where('end_date', '>=', now()) // Hanya transaksi yang masih aktif
                ->orderByDesc('membership_id')  // Prioritaskan membership dengan level tertinggi
                ->orderByDesc('end_date')       // Jika level sama, pilih yang terbaru
                ->with('membership')            // Pastikan relasi membership dimuat
                ->first();
        }

        // Kirim data ke view
        return view('welcome', compact('assets', 'memberships', 'activeMembership'));
    }




    public function search(Request $request)
    {
        $query = $request->input('aset'); // Mengambil 'aset' sebagai parameter pencarian

        // Validasi input pencarian
        $request->validate([
            'aset' => 'nullable|string|max:255', // Validasi untuk parameter 'aset'
        ]);

        // Lakukan pencarian berdasarkan kolom yang relevan dan urutkan berdasarkan unduhan terbanyak
        $assets = Asset::where('is_aktif', 1) // Tambahkan filter untuk hanya mengambil asset yang aktif
            ->where(function ($q) use ($query) {
                $q->where('nama_aset', 'LIKE', "%{$query}%")
                    ->orWhere('jenis_aset', 'LIKE', "%{$query}%")
                    ->orWhere('deskripsi', 'LIKE', "%{$query}%")
                    ->orWhere('kategori', 'LIKE', "%{$query}%");
            })
            ->withCount('downloadHistories') // Menghitung jumlah unduhan setiap aset
            ->orderBy('download_histories_count', 'desc') // Urutkan berdasarkan jumlah unduhan terbanyak
            ->paginate(20);

        // Rekomendasi aset global (tidak bergantung pada pencarian)
        $recommendedAssets = Asset::where('is_aktif', 1) // Tambahkan filter untuk hanya mengambil asset yang aktif
            ->withCount('downloadHistories')
            ->orderBy('download_histories_count', 'desc') // Urutkan berdasarkan unduhan terbanyak
            ->take(20)
            ->get();

        // Kembalikan view dengan hasil pencarian dan query
        return view('pages.search', compact('assets', 'query', 'recommendedAssets'));
    }




    public function show($id, $nama_aset)
    {
        $asset = Asset::with('uploader')->find($id);

        if (!$asset) {
            abort(404, 'Asset not found');
        }

        return view('pages.show', compact('asset'));
    }



}
