<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MembershipTransaction;

class ResetDailyDownloads extends Command
{
    protected $signature = 'reset:daily-downloads';
    protected $description = 'Reset daily downloads for all users';

    public function handle()
    {
        // Mengupdate kolom downloads_today menjadi 0 untuk transaksi yang sudah lama
        $updatedRows = MembershipTransaction::whereDate('updated_at', '<', now()->toDateString())
            ->update(['downloads_today' => 0]);

        // Menampilkan informasi apakah ada data yang diupdate
        if ($updatedRows > 0) {
            $this->info("Daily downloads have been reset for {$updatedRows} transactions.");
        } else {
            $this->info('No transactions were updated. All downloads are already reset.');
        }
    }
}
