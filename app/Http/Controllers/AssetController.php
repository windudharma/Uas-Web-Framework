<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DownloadHistory;
use App\Models\MembershipTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AssetController extends Controller
{
    // Menampilkan daftar asset
    public function index(Request $request)
    {
        $query = $request->input('search'); // Ambil input pencarian

        // Interpretasi untuk pencarian status aktif/nonaktif
        $statusQuery = null;
        if (strtolower($query) === 'aktif') {
            $statusQuery = 1;
        } elseif (strtolower($query) === 'nonaktif') {
            $statusQuery = 0;
        }

        // Query pencarian
        $assets = Asset::where(function ($q) use ($query, $statusQuery) {
            $q->where('kode', 'LIKE', "%{$query}%")
                ->orWhere('nama_aset', 'LIKE', "%{$query}%")
                ->orWhere('jenis_aset', 'LIKE', "%{$query}%")
                ->orWhere('deskripsi', 'LIKE', "%{$query}%")
                ->orWhere('kategori', 'LIKE', "%{$query}%");

            // Tambahkan pencarian berdasarkan status aktif/nonaktif
            if (!is_null($statusQuery)) {
                $q->orWhere('is_aktif', $statusQuery);
            }
        })
        ->orderBy('created_at', 'desc') // Urutkan berdasarkan waktu dibuat (terbaru)
        ->paginate(10);

        return view('pages.dashboard.asset', compact('assets'));
    }




    // Form untuk menambah asset baru
    public function create()
    {
        return view('pages.dashboard.asset.create');
    }

    // Simpan data asset baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_aset' => 'required|max:255',
            'jenis_aset' => 'nullable|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file_zip' => 'nullable|mimes:zip|max:5120',
            'deskripsi' => 'nullable|max:500',
            'kategori' => 'nullable|max:100',
        ]);

        // Generate kode aset otomatis
        $kodeAset = 'KD-' . Str::random(10); // Misalnya kode dengan format "AS-XXXXXXXXXX"

        // Proses Gambar
        $gambarPath = $this->processImage($request->file('gambar'));

        // Proses File ZIP
        $zipPath = $this->processZip($request->file('file_zip'));

        // Simpan data ke database
        Asset::create([
            'kode' => $kodeAset, // Menggunakan kode yang telah di-generate
            'nama_aset' => $request->nama_aset,
            'jenis_aset' => $request->jenis_aset,
            'gambar' => $gambarPath,
            'file_zip' => $zipPath,
            'deskripsi' => $request->deskripsi,
            'kategori' => $request->kategori,
            'uploaded_by' => auth()->id(), // Tambahkan ini

        ]);

        return redirect()->route('assets.index')->with('success', 'Aset berhasil ditambahkan.');
    }


    // Form untuk edit asset
    public function edit(Asset $asset)
    {
        return view('pages.asset.edit', compact('asset'));
    }

    // Perbarui data asset
    public function update(Request $request, Asset $asset)
    {
        $request->validate([
            'kode' => 'required|unique:assets,kode,' . $asset->id . '|max:50',
            'nama_aset' => 'required|max:255',
            'jenis_aset' => 'nullable|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file_zip' => 'nullable|mimes:zip|max:5120',
            'deskripsi' => 'nullable|max:500',
            'kategori' => 'nullable|max:100',
        ]);

        // Update Gambar
        if ($request->hasFile('gambar')) {
            if ($asset->gambar) {
                Storage::disk('public')->delete($asset->gambar);
            }
            $asset->gambar = $this->processImage($request->file('gambar'));
        }

        // Update File ZIP
        if ($request->hasFile('file_zip')) {
            if ($asset->file_zip) {
                Storage::disk('public')->delete($asset->file_zip);
            }
            $asset->file_zip = $this->processZip($request->file('file_zip'));
        }

        // Update Data
        $asset->update([
            'kode' => $request->kode,
            'nama_aset' => $request->nama_aset,
            'jenis_aset' => $request->jenis_aset,
            'deskripsi' => $request->deskripsi,
            'kategori' => $request->kategori,
            'is_aktif' => $request->is_aktif ?? true,
        ]);

        return redirect()->route('assets.index')->with('success', 'Asset berhasil diperbarui.');
    }

    // Proses Unduhan File
    public function download(Request $request)
    {
        $request->validate(['id' => 'required|exists:assets,id']);
        $asset = Asset::findOrFail($request->id);

        if (!$asset->is_aktif) {
            return back()->with('error', 'Aset tidak aktif.');
        }

        $activeMembership = MembershipTransaction::where('user_id', auth()->id())
            ->where('end_date', '>=', now())
            ->latest('start_date')
            ->first();

        if (!$activeMembership) {
            return back()->with('error', 'Anda tidak memiliki membership aktif.');
        }

        if ($activeMembership->downloads_today >= $activeMembership->membership->daily_limit) {
            return back()->with('error', 'Anda telah mencapai batas maksimum unduhan harian.');
        }

        $alreadyDownloaded = DownloadHistory::where('user_id', auth()->id())
            ->where('asset_id', $asset->id)
            ->whereDate('downloaded_at', now()->toDateString())
            ->exists();

        if (!$alreadyDownloaded) {
            DownloadHistory::create([
                'user_id' => auth()->id(),
                'asset_id' => $asset->id,
                'downloaded_at' => now(),
            ]);
            $activeMembership->increment('downloads_today');
        }

        $filePath = storage_path('app/public/' . $asset->file_zip);
        if (!file_exists($filePath)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        // Mengubah nama file menjadi nama aset
        $newFileName = $asset->nama_aset . '.zip';

        return response()->download($filePath, $newFileName);
    }


    // Fungsi untuk memproses gambar dengan watermark
    private function processImage($imageFile)
    {
        if (!$imageFile) {
            return null;
        }

        $gambarPath = 'uploads/assets/' . $imageFile->hashName();
        $imagePath = storage_path('app/public/' . $gambarPath);
        $imageFile->storeAs('uploads/assets', $imageFile->hashName(), 'public');

        $watermarkPath = storage_path('app/public/uploads/watermark/watermark.png');
        if (file_exists($watermarkPath)) {
            $extension = $imageFile->getClientOriginalExtension();
            $image = match ($extension) {
                'jpeg', 'jpg' => imagecreatefromjpeg($imagePath),
                'png' => imagecreatefrompng($imagePath),
                'webp' => imagecreatefromwebp($imagePath),
                default => null,
            };

            if ($image) {
                $watermark = imagecreatefrompng($watermarkPath);
                $imageWidth = imagesx($image);
                $imageHeight = imagesy($image);
                $watermarkWidth = imagesx($watermark);
                $watermarkHeight = imagesy($watermark);

                for ($y = 0; $y < $imageHeight; $y += $watermarkHeight + 10) {
                    for ($x = 0; $x < $imageWidth; $x += $watermarkWidth + 10) {
                        imagecopy($image, $watermark, $x, $y, 0, 0, $watermarkWidth, $watermarkHeight);
                    }
                }

                match ($extension) {
                    'jpeg', 'jpg' => imagejpeg($image, $imagePath, 90),
                    'png' => imagepng($image, $imagePath),
                    'webp' => imagewebp($image, $imagePath, 90),
                };

                imagedestroy($image);
                imagedestroy($watermark);
            }
        }

        return $gambarPath;
    }

    // Fungsi untuk memproses file ZIP
    private function processZip($zipFile)
    {
        if (!$zipFile) {
            return null;
        }
        return $zipFile->store('uploads/zips', 'public');
    }
}
