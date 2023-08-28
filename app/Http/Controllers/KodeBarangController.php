<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Barang;
use App\Models\KodeBarang;
use Illuminate\Http\Request;

class KodeBarangController extends Controller
{
    public function index(Request $request){   
        $barang = Barang::all();
        $query = KodeBarang::orderBy('created_at', 'desc');

        // Filter berdasarkan Barang
        if ($request->has('nama_barang_id')) {
            $nama_barang_id = $request->nama_barang_id;
            if (!empty($nama_barang_id)) {
                $query->where('nama_barang_id', $nama_barang_id);
            }
        }

        if ($request->has('status')) {
            $status = $request->status;
            if (!empty($status)) {
                $query->where('status', $status);
            }
        }
        
        if ($request->has('keterangan')) {
            $keterangan = $request->keterangan;
            if (!empty($keterangan)) {
                $query->where('keterangan', $keterangan);
            }
        }

        if ($request->has('code')) {
            $code = $request->code;
            if (!empty($code)) {
                $query->where('code', $code);
            }
        }

        $kodebarang = $query->paginate(50);

        return view('kodebarang.index')->with('kodebarang',$kodebarang)->with('barang',$barang);
    }

    public function print(Request $request){
        $barang = Barang::all();
        $query = KodeBarang::orderBy('created_at', 'desc');

        // Filter berdasarkan Barang
        if ($request->has('nama_barang_id')) {
            $nama_barang_id = $request->nama_barang_id;
            if (!empty($nama_barang_id)) {
                $query->where('nama_barang_id', $nama_barang_id);
            }
        }

        if ($request->has('status')) {
            $status = $request->status;
            if (!empty($status)) {
                $query->where('status', $status);
            }
        }
        
        if ($request->has('keterangan')) {
            $keterangan = $request->keterangan;
            if (!empty($keterangan)) {
                $query->where('keterangan', $keterangan);
            }
        }

        if ($request->has('code')) {
            $code = $request->code;
            if (!empty($code)) {
                $query->where('code', $code);
            }
        }

        $kodebarang = $query->paginate(50);

        $pdf = PDF::loadView('kodebarang.print', compact('kodebarang'));
        return $pdf->stream('kodebarang.pdf');
    }
}
