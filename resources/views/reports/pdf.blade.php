<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Barang {{ ucfirst($type) }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin-top: 10px;
        }
        h2, h3 {
            text-align: center;
            margin: 5px 0;
            color: #111;
        }
        .header {
            margin-bottom: 20px;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px 5px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 11px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>SISTEM MANAJEMEN STOK</h2>
        <h3>LAPORAN BARANG {{ strtoupper($type) }}</h3>
        <p class="text-center">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kode - Nama Barang</th>
                <th class="text-center">Qty</th>
                <th>Keterangan</th>
                <th>Petugas</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $index => $trx)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($trx->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $trx->item->kode_barang ?? '-' }} <br/> <strong>{{ $trx->item->nama_barang ?? '-' }}</strong></td>
                <td class="text-center badge">
                    @if($type == 'masuk')
                        +{{ $trx->qty }}
                    @else
                        -{{ $trx->qty }}
                    @endif
                </td>
                <td>{{ $trx->keterangan ?? '-' }}</td>
                <td>{{ $trx->createdBy->name ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center" style="padding: 20px;">Tidak ada transaksi ditemukan pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>
