<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kode Barang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table td, table th {
            border: 1px solid #ddd;
            padding: 8px;
        }
        table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Laporan Barang Kembali</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Barang</th>
                <th>Status</th>
                <th>Keterangan</th>
                <th>Kode</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kodebarang as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->created_at->format('Y-m-d') }}</td>
                    <td>{{ $item->barang->nama_barang }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td>{{ $item->code }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
