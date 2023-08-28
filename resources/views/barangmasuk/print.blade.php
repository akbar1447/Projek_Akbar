<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Barang Masuk</title>
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
    <h1>Laporan Barang Masuk</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Masuk</th>
                <th>Nama Barang</th>
                <th>Tipe</th>
                <th>Tahun</th>
                <th>Jumlah Masuk</th>
                <th>Kode</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barangmasuk as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->created_at->format('Y-m-d') }}</td>
                    <td>{{ $item->barang->nama_barang }}</td>
                    <td>{{ $item->barang->type }}</td>
                    <td>{{ $item->barang->tahun }}</td>
                    <td>{{ $item->jumlahmasuk }}</td>
                    <td>{{ $item->barang->code }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
