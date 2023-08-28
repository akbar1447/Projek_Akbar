<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Barang</title>
    <style>
        /* CSS untuk tampilan cetak */
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
    <h1>Laporan Barang</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Masuk</th>
                <th>Nama Barang</th>
                <th>Tipe</th>
                <th>Tahun</th>
                <th>Jumlah</th>
                <th>Kode</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barang as $barang)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $barang->created_at->format('Y-m-d') }}</td>
                    <td>{{ $barang->nama_barang }}</td>
                    <td>{{ $barang->type }}</td>
                    <td>{{ $barang->tahun }}</td>
                    <td>{{ $barang->jumlah }}</td>
                    <td>{{ $barang->code }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
