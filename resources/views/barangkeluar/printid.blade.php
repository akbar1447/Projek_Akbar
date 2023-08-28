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
        .column {
            width: 50%;
            float: left;
        }
        .clear {
            clear: both;
        }
    </style>
</head>
<body>
    <h1>Data Barang Keluar</h1>
    <div class="column">
        <strong>Tanggal Keluar :</strong> {{ $barangkeluar->created_at->format('Y-m-d') }}<br>
        <strong>Nama Pengambil :</strong> {{ $barangkeluar->nama }}<br>
        <strong>Jabatan :</strong> {{ $barangkeluar->jabatan }}<br>
        <strong>Nomor HP :</strong> {{ $barangkeluar->hp }}<br>
    </div>
    <div class="column">
        <strong>Nama Barang :</strong> {{ $barangkeluar->barang->nama_barang }}<br>
        <strong>Jumlah keluar :</strong> {{ $barangkeluar->jumlahkeluar }}<br>
        <strong>Tipe :</strong> {{ $barangkeluar->barang->type }}<br>
        <strong>Keterangan :</strong> {{ $barangkeluar->keterangan }}<br>
    </div>
    <div class="clear"></div>
    
    <h2>Daftar Kode Barang Keluar</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang keluar</th>
                <th>No</th>
                <th>Kode Barang keluar</th>
            </tr>
        </thead>
        <tbody>
            @php
                $kodeBarangkeluar = explode(',', $barangkeluar->kode_barang_keluar);
            @endphp
            @for ($i = 0; $i < count($kodeBarangkeluar); $i+=2)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $kodeBarangkeluar[$i] }}</td>
                <td>{{ $i + 2 }}</td>
                <td>{{ isset($kodeBarangkeluar[$i + 1]) ? $kodeBarangkeluar[$i + 1] : '' }}</td>
            </tr>
            @endfor
        </tbody>
    </table>
</body>
</html>
