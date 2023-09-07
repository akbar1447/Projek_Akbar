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
        .break-words {
            word-wrap: break-word;
            max-width: 700px;
        }
    </style>
</head>
<body>
    <div class="break-words">
        <h1>Data Barang Kembali</h1>
        <strong>Tanggal Kembali:</strong> {{ $barangkembali->created_at->format('Y-m-d') }}</br>
        <strong>Nama Barang:</strong> {{ $barangkembali->barang->nama_barang }}</br>
        <strong>Jumlah Kembali:</strong> {{ $barangkembali->jumlahkembali }}</br>
        <strong>Status:</strong> {{ $barangkembali->status }}</br>
        <strong>Keterangan:</strong> {{ $barangkembali->keterangan }}</br>
    </div>

    <h2>Daftar Kode Barang Kembali</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang Kembali</th>
                <th>No</th>
                <th>Kode Barang Kembali</th>    
            </tr>
        </thead>
        <tbody>
            @php
                $kodeBarangkembali = explode(',', $barangkembali->kode_barang_kembali);
            @endphp
            @for ($i = 0; $i < count($kodeBarangkembali); $i+=2)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $kodeBarangkembali[$i] }}</td>
                <td>{{ $i + 2 }}</td>
                <td>{{ isset($kodeBarangkembali[$i + 1]) ? $kodeBarangkembali[$i + 1] : '' }}</td>
            </tr>
            @endfor
        </tbody>
    </table>
</body>
</html>
