<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi Membership</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        tfoot {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Laporan Transaksi Membership</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama User</th>
                <th>Jenis Paket</th>
                <th>Jenis Transaksi</th>
                <th>Waktu</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalAmount = 0; // Variable untuk menyimpan total transaksi
            @endphp
            @foreach ($transactions as $index => $transaction)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $transaction->user_name }}</td>
                    <td>{{ $transaction->membership_name }}</td>
                    <td>{{ ucfirst($transaction->transaction_type) }}</td>
                    <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                    <td>Rp {{ number_format($transaction->amount_paid, 0, ',', '.') }}</td>
                </tr>
                @php
                    $totalAmount += $transaction->amount_paid; // Tambahkan jumlah transaksi ke total
                @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" style="text-align:right;">Total Transaksi:</td>
                <td>Rp {{ number_format($totalAmount, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
