<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\User;
use App\Models\Barang;
use App\Models\KodeBarang;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;    
use Illuminate\Support\Facades\DB;

class BarangKeluarController extends Controller
{
    public function index(Request $request){
        $barang = Barang::all();
        $query = BarangKeluar::orderBy('created_at', 'desc');

        // Filter berdasarkan tahun masuk
        if ($request->has('tahun')) {
            $tahun = $request->tahun;
            if (!empty($tahun)) {
                $query->whereYear('created_at', $tahun);
            }
        }

        // Filter berdasarkan bulan masuk
        if ($request->has('bulan')) {
            $bulan = $request->bulan;
            if (!empty($bulan)) {
                $query->whereMonth('created_at', $bulan);
            }
        }

        // Filter berdasarkan tanggal masuk
        if ($request->has('tanggal')) {
            $tanggal = $request->tanggal;
            if (!empty($tanggal)) {
                $query->whereDay('created_at', $tanggal);
            }
        }

        // Filter berdasarkan Barang
        if ($request->has('nama_barang_id')) {
            $nama_barang_id = $request->nama_barang_id;
            if (!empty($nama_barang_id)) {
                $query->where('nama_barang_id', $nama_barang_id);
            }
        }

        if ($request->has('nama')) {
            $nama = $request->nama;
            if (!empty($nama)) {
                $query->where('nama', $nama);
            }
        }
        
        if ($request->has('jabatan')) {
            $jabatan = $request->jabatan;
            if (!empty($jabatan)) {
                $query->where('jabatan', $jabatan);
            }
        }

        $barangkeluar = $query->paginate(20);

        return view('barangkeluar.index')
            ->with('barangkeluar', $barangkeluar)
            ->with('barang', $barang);
    }

    public function kurang(){   
        $barangkeluar = BarangKeluar::all();
        $barang = Barang::all();
        $user = Auth::user();
        return view('barangkeluar.keluar')->with('barangkeluar',$barangkeluar)->with('barang',$barang)->with('user', $user);
    }

    public function store(Request $request){
        $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'hp' => 'required|numeric|digits_between:11,13',
            'nama_barang_id' => 'required',
            'option' => 'required',
        ]);
        if ($request->option === 'kode') {
            $codes = explode(',', $request->kodebarang);
            $codes = array_map('trim', $codes);

            if (empty($codes)) {
                return redirect()->route('barangkeluar.index')->withErrors(['Kode barang tidak valid atau tidak tersedia.']);
            }

            DB::beginTransaction();

            try {
                $invalidCodes = [];
                $jumlahKodeKeluar = 0;
    
                foreach ($codes as $code) {
                    $kodeBarang = KodeBarang::where('code', $code)->where('status', 'Tersedia')->first();
                    if (!$kodeBarang) {
                        $invalidCodes[] = $code;
                        continue;
                    }
    
                    if ($kodeBarang->nama_barang_id == $request->nama_barang_id) {
                        $jumlahKodeKeluar++;
                    } else {
                        DB::rollback();
                        return redirect()->route('barangkeluar.index')->withErrors(['Kode barang ' . $code . ' tidak sesuai dengan nama barang yang dipilih.']);
                    }
                }
    
                if ($jumlahKodeKeluar === 0) {
                    DB::rollback();
                    return redirect()->route('barangkeluar.index')->withErrors(['Tidak ada kode barang yang sesuai dengan nama barang yang dipilih.']);
                }
    
                $barangkeluar = new BarangKeluar;
                $barangkeluar->nama_barang_id = $request->nama_barang_id;
                $barangkeluar->jumlahkeluar = $jumlahKodeKeluar;
                $barangkeluar->keterangan = $request->keterangan;
                $barangkeluar->kode_barang_keluar = $request->kodebarang;
                $barangkeluar->nama = $request->nama;
                $barangkeluar->jabatan = $request->jabatan;
                $barangkeluar->hp = $request->hp;
                $barangkeluar->save();
                
                $barang = Barang::findOrFail($request->nama_barang_id);
                $barang->jumlah -= $jumlahKodeKeluar;
                $barang->save();

                $this->addKeluarCodes($barangkeluar, $barang, $jumlahKodeKeluar);
    
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->route('barangkeluar.index')->withErrors(['Barang gagal disimpan.']);
            }

        } elseif ($request->option === 'jumlah') {
            if (!$request->has('nama_barang_id') || !$request->has('jumlahkeluar')) {
                return redirect()->route('barangkeluar.index')->withErrors(['Isi nama barang dan jumlah keluar jika memilih opsi "Jumlah".']);
            }

            DB::beginTransaction();

            try {
                $barang = Barang::findOrFail($request->nama_barang_id);

                $codes = KodeBarang::where('nama_barang_id', $barang->id)
                    ->where('status', 'Tersedia')
                    ->take($request->jumlahkeluar)
                    ->get();
                    
                if ($barang->jumlah < $request->jumlahkeluar) {
                    DB::rollback();
                    return redirect()->route('barangkeluar.index')->withErrors(['Jumlah barang tidak mencukupi']);
                }else{
                    $barang->jumlah -= $request->jumlahkeluar;
                    $barang->save();
                }

                $kode_barang_keluar = $codes->pluck('code')->implode(',');

                $barangkeluar = new BarangKeluar;
                $barangkeluar->nama_barang_id = $request->nama_barang_id;
                $barangkeluar->jumlahkeluar = $request->jumlahkeluar;
                $barangkeluar->keterangan = $request->keterangan;
                $barangkeluar->kode_barang_keluar = $kode_barang_keluar;
                $barangkeluar->nama = $request->nama;
                $barangkeluar->jabatan = $request->jabatan;
                $barangkeluar->hp = $request->hp;
                $barangkeluar->save();

                foreach ($codes as $code) {
                    $code->status = 'Keluar';
                    $code->barang_keluar_id = $barangkeluar->id;
                    $code->keterangan = $barangkeluar->keterangan; 
                    $code->save();
                }

                DB::commit();

            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->route('barangkeluar.index')->withErrors(['Barang gagal disimpan.']);
            }
        } else {
            DB::rollback();
            return redirect()->route('barangkeluar.index')->withErrors(['Pilih salah satu: kodebarang atau jumlahkeluar.']);
        }return redirect()->route('barangkeluar.index')->with('sukses', 'Barang berhasil disimpan.');
    }

    public function destroy($id){
        DB::beginTransaction();
        try {
            $barangkeluar = BarangKeluar::findOrFail($id);
            $barang = Barang::findOrFail($barangkeluar->nama_barang_id);
            $kodeBarangKeluar = explode(',', $barangkeluar->kode_barang_keluar);

            
            if ($kodeBarangKeluar->status === 'Keluar') {
                foreach ($kodeBarangKeluar as $kode) {
                    $code = KodeBarang::where('code', trim($kode))->first();

                    if ($code) {
                        $code->status = 'Tersedia';
                        $code->keterangan = 'Tersedia';
                        $code->barang_keluar_id = null;
                        $code->save();
                    }
                }
            } else {
                DB::rollback();
                return redirect()->route('barangkeluar.index')->withErrors(['Barang Tidak Bisa Dihapus.']);
            } 

            $barang->jumlah += $barangkeluar->jumlahkeluar;
            $barang->save();

            $barangkeluar->delete();
            DB::commit();
            
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors('Barang gagal dihapus');
        }return redirect()->back()->with('sukses', 'Barang berhasil dihapus');
    }

    public function print(Request $request){
        $barang = Barang::all();
        $query = BarangKeluar::orderBy('created_at', 'desc');

        // Terapkan filter berdasarkan parameter di URL
        if ($request->has('tahun')) {
            $tahun = $request->tahun;
            if (!empty($tahun)) {
                $query->whereYear('created_at', $tahun);
            }
        }

        if ($request->has('bulan')) {
            $bulan = $request->bulan;
            if (!empty($bulan)) {
                $query->whereMonth('created_at', $bulan);
            }
        }

        if ($request->has('tanggal')) {
            $tanggal = $request->tanggal;
            if (!empty($tanggal)) {
                $query->whereDay('created_at', $tanggal);
            }
        }

        if ($request->has('nama_barang_id')) {
            $nama_barang_id = $request->nama_barang_id;
            if (!empty($nama_barang_id)) {
                $query->where('nama_barang_id', $nama_barang_id);
            }
        }

        if ($request->has('nama')) {
            $nama = $request->nama;
            if (!empty($nama)) {
                $query->where('nama', $nama);
            }
        }
        
        if ($request->has('jabatan')) {
            $jabatan = $request->jabatan;
            if (!empty($jabatan)) {
                $query->where('jabatan', $jabatan);
            }
        }

        $barangkeluar = $query->paginate(20);

        // Cetak PDF dengan tampilan 'barangkeluar.print'
        $pdf = PDF::loadView('barangkeluar.print', compact('barangkeluar'));
        return $pdf->stream('barangkeluar.pdf');
    }

    public function printid($id){
        $barangkeluar = BarangKeluar::findOrFail($id);
        $pdf = PDF::loadView('barangkeluar.printid', compact('barangkeluar'));
        return $pdf->stream('barangkeluar.pdf');
    }
}