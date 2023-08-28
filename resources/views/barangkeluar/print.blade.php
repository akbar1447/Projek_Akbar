<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Barang Keluar</title>
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
    <h1>Laporan Barang Keluar</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Pengambil</th>
                <th>Barang</th>
                <th>Jumlah Keluar</th>
                <th>Jabatan</th>
                <th>Nomor HP</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barangkeluar as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->created_at->format('Y-m-d') }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->barang->nama_barang }}</td>
                    <td>{{ $item->jumlahkeluar }}</td>
                    <td>{{ $item->jabatan }}</td>
                    <td>{{ $item->hp }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
