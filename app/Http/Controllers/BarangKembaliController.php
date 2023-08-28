<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Barang;
use App\Models\KodeBarang;
use App\Models\BarangKeluar;
use App\Models\BarangKembali;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;  

class BarangKembaliController extends Controller
{
    public function index(Request $request){$barang = Barang::all();
        $query = BarangKembali::orderBy('created_at', 'desc');

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

        if ($request->has('status')) {
            $status = $request->status;
            if (!empty($status)) {
                $query->where('status', $status);
            }
        }

        $barangkembali = $query->paginate(20);

        return view('barangkembali.index')
            ->with('barangkembali', $barangkembali)
            ->with('barang', $barang);
    }

    public function kembali(){
        $barangkembali = BarangKembali::all();
        $barang = Barang::all();
        return view('barangkembali.kembali')->with('barangkembali',$barangkembali)->with('barang',$barang);
    }

    public function store(Request $request){
        $request->validate([
            'nama_barang_id' => 'required',
            'keterangan' => 'required',
            'option' => 'required',
            'status' => 'required',
        ]);
        if ($request->option === 'kode') {
            $codes = explode(',', $request->kodebarang);
            $codes = array_map('trim', $codes);

            if (empty($codes)) {
                return redirect()->route('barangkembali.index')->withErrors(['Kode barang tidak valid atau tidak tersedia.']);
            }

            DB::beginTransaction();

            try {
                $invalidCodes = [];
                $jumlahKodeKembali = 0;
    
                foreach ($codes as $code) {
                    $kodebarang = KodeBarang::where('code', $code)->first();
                    if (!$kodebarang) {
                        $invalidCodes[] = $code;
                        continue;
                    }

                    if ($kodebarang->status !== 'Keluar' ) {
                        DB::rollback();
                        return redirect()->route('barangkembali.index')->withErrors(['Kode barang ' . $code . ' Masih Tersedia']);
                    }

                    if ($kodebarang) {
                        $kodebarang->status = ($request->status === 'Baik') ? 'Tersedia' : 'Tidak Bisa Digunakan';
                        $kodebarang->keterangan = ($request->status === 'Baik') ? 'Tersedia' : $request->keterangan;
                        $kodebarang->save();
                    }
    
                    if ($kodebarang->nama_barang_id == $request->nama_barang_id) {
                        $jumlahKodeKembali++;
                    } else {
                        DB::rollback();
                        return redirect()->route('barangkembali.index')->withErrors(['Kode barang ' . $code . ' tidak sesuai dengan nama barang yang dipilih.']);
                    }
                }
    
                if ($jumlahKodeKembali === 0) {
                    DB::rollback();
                    return redirect()->route('barangkembali.index')->withErrors(['Tidak ada kode barang yang sesuai dengan nama barang yang dipilih.']);
                }

                if ($request->status === 'Baik') {
                    $barang = Barang::findOrFail($request->nama_barang_id);
                    $barang->jumlah += $jumlahKodeKembali;
                    $barang->save();
                }
    
                $barangkembali = new Barangkembali;
                $barangkembali->nama_barang_id = $request->nama_barang_id;
                $barangkembali->jumlahkembali = $jumlahKodeKembali;
                $barangkembali->keterangan = $request->keterangan;
                $barangkembali->status = $request->status;
                $barangkembali->kode_barang_kembali = $request->kodebarang;
                $barangkembali->save();
    
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->route('barangkembali.index')->withErrors(['Barang gagal disimpan.']);
            }

        } elseif ($request->option === 'jumlah') {
            if (!$request->has('nama_barang_id') || !$request->has('jumlahkembali')) {
                return redirect()->route('barangkembali.index')->withErrors(['Isi nama barang dan jumlah kembali jika memilih opsi "Jumlah".']);
            }
            
            DB::beginTransaction();

            try {
                $barang = Barang::findOrFail($request->nama_barang_id);
        
                $codes = KodeBarang::where('nama_barang_id', $barang->id)
                    ->where('status', 'Keluar')
                    ->take($request->jumlahkembali)
                    ->get();

                if ($codes->count() < $request->jumlahkembali) {
                    DB::rollback();
                    return redirect()->route('barangkembali.index')->withErrors('Tidak ada atau Kurang Barang yang bisa dikembalikan.');
                }
        
                foreach ($codes as $code) {
                    $code->status = ($request->status === 'Baik') ? 'Tersedia' : 'Tidak Bisa Digunakan';
                    $code->keterangan = ($request->status === 'Baik') ? 'Tersedia' : $request->keterangan;
                    $code->save();
                }
                
                if($request->status === 'Baik'){
                    $barang = Barang::findOrFail($request->nama_barang_id);
                    $barang->jumlah += $request->jumlahkembali;
                    $barang->save();
                }
        
                $kode_barang_kembali = $codes->pluck('code')->implode(',');
                
                $barangkembali = new Barangkembali;
                $barangkembali->nama_barang_id = $request->nama_barang_id;
                $barangkembali->jumlahkembali = $request->jumlahkembali;
                $barangkembali->keterangan = $request->keterangan;
                $barangkembali->status = $request->status;
                $barangkembali->kode_barang_kembali = $kode_barang_kembali;
                $barangkembali->save();
        
                DB::commit();
        
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->route('barangkembali.index')->withErrors(['Barang gagal disimpan.']);
            }
        } else {
            DB::rollback();
            return redirect()->route('barangkembali.index')->withErrors(['Pilih salah satu: kodebarang atau jumlahkembali.']);
        } 
        return redirect('barangkembali')->with('sukses', 'Barang berhasil dikembalikan.');
    }

    public function destroy($id){
        DB::beginTransaction();
        try {
            $barangkembali = BarangKembali::findOrFail($id);
            $kodeBarangKembali = explode(',', $barangkembali->kode_barang_kembali);

            foreach ($kodeBarangKembali as $kode) {
                $code = KodeBarang::where('code', trim($kode))->first();

                if ($code) {
                    $barangkeluar = BarangKeluar::findOrFail($code->barang_keluar_id);
                    $code->keterangan = $barangkeluar->keterangan;
                    $code->status = 'Keluar';
                    $code->save();
                }
            }

            if ($barangkembali->status === 'Baik') {
                $barang = Barang::findOrFail($barangkembali->nama_barang_id);
                $barang->jumlah += $barangkembali->jumlahkembali;
                $barang->save();
            }

            // Delete the BarangKembali
            $barangkembali->delete();
            DB::commit();
            
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors('Barang gagal dihapus');
        }

        return redirect()->back()->with('sukses', 'Barang berhasil dihapus');
    }
    
    public function print(Request $request){
        $barang = Barang::all();
        $query = Barangkembali::orderBy('created_at', 'desc');

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

        $barangkembali = $query->paginate(20);

        // Cetak PDF dengan tampilan 'barangkembali.print'
        $pdf = PDF::loadView('barangkembali.print', compact('barangkembali'));
        return $pdf->stream('barangkembali.pdf');
    }

    public function printid($id){
        $barangkembali = BarangKembali::findOrFail($id);
        $pdf = PDF::loadView('barangkembali.printid', compact('barangkembali'));
        return $pdf->stream('barangkembali.pdf');
    }
}
 