<div class="p-6">
    <h3 class="text-lg font-semibold text-gray-700 mb-4">Data Transaksi</h3>
    <table class="min-w-full table-auto">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2 border text-left">No</th>
                <th class="px-4 py-2 border text-left">Nama User</th>
                <th class="px-4 py-2 border text-left">Jenis Paket</th>
                <th class="px-4 py-2 border text-left">Jenis Transaksi</th>
                <th class="px-4 py-2 border text-left">Tanggal</th>
                <th class="px-4 py-2 border text-left">Harga</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalAmount = 0; // Variable untuk menyimpan total transaksi
            @endphp
            @forelse ($transactions as $index => $transaction)
                <tr>
                    <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 border">{{ $transaction->user_name }}</td>
                    <td class="px-4 py-2 border">{{ $transaction->membership_name }}</td>
                    <td class="px-4 py-2 border">{{ ucfirst($transaction->transaction_type) }}</td>
                    <td class="px-4 py-2 border">{{ $transaction->created_at->format('d M Y') }}</td>
                    <td class="px-4 py-2 border">Rp {{ number_format($transaction->amount_paid, 0, ',', '.') }}</td>
                </tr>
                @php
                    $totalAmount += $transaction->amount_paid; // Tambahkan jumlah transaksi ke total
                @endphp
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-2 border text-center text-gray-500">Tidak ada data ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
        @if ($transactions->count() > 0)
            <tfoot>
                <tr class="bg-gray-100">
                    <td colspan="5" class="px-4 py-2 border text-right font-semibold">Total Transaksi:</td>
                    <td class="px-4 py-2 border font-semibold">Rp {{ number_format($totalAmount, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        @endif
    </table>
</div>
