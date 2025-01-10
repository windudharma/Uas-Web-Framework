<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Membership;
use Illuminate\Http\Request;
use App\Models\DownloadHistory;
use App\Http\Controllers\Controller;
use App\Models\MembershipTransaction;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function download(Request $request)
    {
        if ($request->has('download')) {
            $assetId = $request->query('download');
            $asset = Asset::findOrFail($assetId);

            if ($asset->file_zip) {
                $filePath = storage_path('app/public/' . $asset->file_zip);

                if (file_exists($filePath)) {
                    // Mengubah nama file menjadi nama aset
                    $newFileName = $asset->nama_aset . '.zip';

                    // Mengunduh file dengan nama yang diubah
                    return response()->download($filePath, $newFileName);
                } else {
                    return back()->withErrors(['error' => 'File tidak ditemukan.']);
                }
            } else {
                return back()->withErrors(['error' => 'File tidak tersedia.']);
            }
        }

        // Logika untuk menampilkan halaman
        $histories = DownloadHistory::with('asset')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('pages.dashboard.download', compact('histories'));
    }





    public function subscription()
    {
        // Ambil riwayat transaksi untuk pengguna yang sedang login
        $transactions = MembershipTransaction::where('user_id', auth()->id())
            ->latest() // Urutkan dari transaksi terbaru
            ->paginate(10); // Pagination untuk membatasi jumlah data per halaman

        // Ambil membership aktif
        $activeMembership = MembershipTransaction::where('user_id', auth()->id())
        ->where('end_date', '>=', now()) // Hanya transaksi yang masih aktif
        ->orderByDesc('membership_id')  // Prioritaskan membership dengan level tertinggi
        ->orderByDesc('end_date')       // Jika level sama, pilih yang terbaru
        ->with('membership')            // Pastikan relasi membership dimuat
        ->first();

        // Ambil data semua membership untuk ditampilkan
        $memberships = Membership::all();

        // Kirim data ke view
        return view('pages.dashboard.langganan', compact('transactions', 'activeMembership', 'memberships'));
    }


    public function transaksi(Request $request)
    {
        $transactions = MembershipTransaction::query()
            ->join('users', 'membership_transactions.user_id', '=', 'users.id')
            ->join('memberships', 'membership_transactions.membership_id', '=', 'memberships.id')
            ->select('membership_transactions.*', 'users.name as user_name', 'memberships.name as membership_name')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('users.name', 'like', "%$search%")
                             ->orWhere('memberships.name', 'like', "%$search%")
                             ->orWhere('membership_transactions.transaction_type', 'like', "%$search%");
                });
            })
            ->when($request->filled('year_filter'), function ($query) use ($request) {
                $query->whereYear('membership_transactions.created_at', $request->year_filter);
            })
            ->when($request->filled('month_filter'), function ($query) use ($request) {
                $query->whereMonth('membership_transactions.created_at', $request->month_filter);
            })
            ->when($request->filled('start_date') && $request->filled('end_date'), function ($query) use ($request) {
                $query->whereBetween('membership_transactions.created_at', [$request->start_date, $request->end_date]);
            })
            ->orderBy('membership_transactions.created_at', 'desc')
            ->get();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('pages.dashboard.partials.transaction_table', compact('transactions'))->render(),
            ]);
        }

        $memberships = Membership::all();
        return view('pages.dashboard.transaksi', compact('transactions', 'memberships'));
    }


    public function exportPdf(Request $request)
    {
        $transactions = MembershipTransaction::query()
            ->join('users', 'membership_transactions.user_id', '=', 'users.id')
            ->join('memberships', 'membership_transactions.membership_id', '=', 'memberships.id')
            ->select('membership_transactions.*', 'users.name as user_name', 'memberships.name as membership_name')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('users.name', 'like', "%$search%")
                             ->orWhere('memberships.name', 'like', "%$search%")
                             ->orWhere('membership_transactions.transaction_type', 'like', "%$search%");
                });
            })
            ->when($request->filled('year_filter'), function ($query) use ($request) {
                $query->whereYear('membership_transactions.created_at', $request->year_filter);
            })
            ->when($request->filled('month_filter') && $request->filled('year_filter'), function ($query) use ($request) {
                $query->whereYear('membership_transactions.created_at', $request->year_filter)
                      ->whereMonth('membership_transactions.created_at', $request->month_filter);
            })
            ->orderBy('membership_transactions.created_at', 'desc')
            ->get();

        // Render the view into a PDF
        $pdf = \PDF::loadView('pages.dashboard.partials.transaction_pdf', compact('transactions'));

        // Return the generated PDF
        return $pdf->download('laporan-transaksi-membership.pdf');
    }







}


