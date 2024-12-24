<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Produksi</title>
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 10px;
        }

        p {
            text-align: center;
            font-size: 14px;
            margin-bottom: 20px;
        }

        /* Styling for the table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
        }

        table th, table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        /* Styling for the table rows */
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:nth-child(odd) {
            background-color: #fff;
        }
    </style>
</head>
<body>
    <h2>Laporan Perusahaan PT Karya Yasminida Bali</h2>
    <p>Tanggal: {{ $start_date }} sampai {{ $end_date }}</p>
    <p>Status: {{ ucfirst($status) }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Admin</th>
                @if ($status == 'masuk')
                <th>Produk Mentah</th>
                @endif
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produksis as $index => $produksi)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $produksi->user->name }}</td>
                    @if ($status == 'masuk')
                    <td>{{ $produksi->praproduct }}</td>
                    @endif
                    <td>{{ $produksi->product }}</td>
                    <td>{{ $produksi->jumlah }}</td>
                    <td>{{ number_format($produksi->harga, 2) }}</td>
                    <td>{{ number_format($produksi->total, 2) }}</td>
                    <td>{{ ucfirst($produksi->status) }}</td>
                    <td>{{ \Carbon\Carbon::parse($produksi->date)->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
