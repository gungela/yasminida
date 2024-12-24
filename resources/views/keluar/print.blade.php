<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Data Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .print-button {
            margin: 20px 0;
            display: block;
            text-align: center;
        }
    </style>
</head>
<body>

    <h1>Data Admin</h1>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>date</th>
                <th>Admin</th>
                <th>Pelanggan</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produksi as $key => $produksi)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $produksi->date }}</td>
                    <td>{{ $produksi->user->name }}</td>
                    <td>{{ $produksi->customer->name }}</td>
                    <td>{{ $produksi->product }}</td>
                    <td>{{ $produksi->jumlah }}</td>
                    <td>Rp {{ number_format($produksi->harga, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($produksi->total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="print-button">
        <button onclick="window.print();">Cetak</button>
    </div>

</body>
</html>
