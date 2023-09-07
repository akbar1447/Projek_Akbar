<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Barang Kembali</title>
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
    <x-table id="tabel_barang">
        <x-slot name="header">
            <tr>
                <x-table-column>No</x-table-column>
                <x-table-column>Tanggal</x-table-column>
                <x-table-column>Barang</x-table-column>
                <x-table-column>Jumlah Kembali</x-table-column>
                <x-table-column>Status</x-table-column>
                <x-table-column>Keterangan</x-table-column>
            </tr>
        </x-slot>
        @foreach ($barangkembali as $item)
            <tr>
                <x-table-column>{{ $loop->iteration }}</x-table-column>
                <x-table-column>{{ $item->created_at->format('Y-m-d') }}</x-table-column>
                <x-table-column>{{ $item->barang->nama_barang }}</x-table-column>
                <x-table-column>{{ $item->jumlahkembali }}</x-table-column>
                <x-table-column>{{ $item->status }}</x-table-column>
                <x-table-column>{{ $item->keterangan }}</x-table-column>
            </tr>
        @endforeach
    </x-table>
</body>
</html>
