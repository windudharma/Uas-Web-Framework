<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama_aset',
        'jenis_aset',
        'deskripsi',
        'kategori',
        'gambar',
        'file_zip',
        'is_aktif',
        'uploaded_by',
    ];

    /**
     * Relasi ke tabel download_histories.
     */
    public function downloadHistories()
    {
        return $this->hasMany(DownloadHistory::class, 'asset_id');
    }

    /**
     * Relasi ke pengguna yang mengunggah aset.
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
