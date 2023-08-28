<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Data</title>
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
    <h1>Data Barang Masuk</h1>
    <strong>Tanggal Masuk:</strong> {{ $barangmasuk->created_at->format('Y-m-d') }}<br>
    <strong>Tipe:</strong> {{ $barangmasuk->barang->type }}<br>
    <strong>Nama Barang:</strong> {{ $barangmasuk->barang->nama_barang }}<br>
    <strong>Tahun:</strong> {{ $barangmasuk->barang->tahun }}<br>
    <strong>Jumlah Masuk:</strong> {{ $barangmasuk->jumlahmasuk }}<br>

    <h2>Daftar Kode Barang Masuk</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang Masuk</th>
                <th>No</th>
                <th>Kode Barang Masuk</th>
            </tr>
        </thead>
        <tbody>
            @php
                $kodeBarangMasuk = explode(',', $barangmasuk->kode_barang_masuk);
            @endphp
            @for ($i = 0; $i < count($kodeBarangMasuk); $i+=2)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $kodeBarangMasuk[$i] }}</td>
                <td>{{ $i + 2 }}</td>
                <td>{{ isset($kodeBarangMasuk[$i + 1]) ? $kodeBarangMasuk[$i + 1] : '' }}</td>
            </tr>
            @endfor
        </tbody>
    </table>
</body>
</html>
