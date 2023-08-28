<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Barang;
use App\Models\KodeBarang;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
{
    public function index(Request $request){
        $barang = Barang::all();
        
        $query = BarangMasuk::orderBy('created_at', 'desc');

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

        $barangmasuk = $query->paginate(20);

        return view('barangmasuk.index')
            ->with('barangmasuk',$barangmasuk)
            ->with('barang',$barang);
    }

    public function tambah(){
        $barang = Barang::all();
        return view('barang.tambah')->with('barang', $barang);
    }

    public function store(Request $request){
        $request->validate([
            'nama_barang_id' => 'required',
            'jumlahmasuk' => 'required|numeric',
        ]);
        
        DB::beginTransaction();

        try {

            $barangmasuk = new BarangMasuk;
            $barangmasuk->nama_barang_id = $request->nama_barang_id;
            $barangmasuk->jumlahmasuk = $request->jumlahmasuk;
            if ($request->jumlahmasuk > 0) {
                $barang = Barang::findOrFail($request->nama_barang_id);
                $barang->jumlah += $request->jumlahmasuk;
                $barang->save();

                $newCodes =$this->addMasukCodes($barang, $request->jumlahmasuk);
                
                $barangmasuk->kode_barang_masuk = implode(',', $newCodes);
                $barangmasuk->save();
            }

            DB::commit();

        }catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors('Barang gagal disimpan')->withInput();
        }
        return redirect('barangmasuk')->with('sukses', 'Barang berhasil disimpan.');
    }

    private function addMasukCodes(Barang $barang, $jumlahmasuk){
        $lastCodeBarang = KodeBarang::where('nama_barang_id', $barang->id)->orderByDesc('id')->first();

        if ($lastCodeBarang) {
            $lastCode = $lastCodeBarang->code;
            $lastNumber = intval(substr($lastCode, -strlen($barang->jumlah)));
        } else {
            $lastNumber = 0;
        }

        $newCodes = [];

        for ($i = $lastNumber + 1; $i <= $lastNumber + $jumlahmasuk; $i++) {
            $newNumber = ltrim(strval($i), '0');

            $newCode = $barang->code . $newNumber;
            $newCodes[] = $newCode;

            $kodeBarang = new KodeBarang();
            $kodeBarang->nama_barang_id = $barang->id;
            $kodeBarang->code = $newCode;
            $kodeBarang->status = 'Tersedia';
            $kodeBarang->save();
        }
        return $newCodes;
    }

    public function destroy($id){
        DB::beginTransaction();

        try {
            $barangmasuk = BarangMasuk::findOrFail($id);
            $kodeBarangMasuk = explode(',', $barangmasuk->kode_barang_masuk);

            foreach ($kodeBarangMasuk as $kode) {
                $code = KodeBarang::where('code', trim($kode))->first();

                if($code){
                    $code->delete();
                }
            }

            $barang = Barang::findOrFail($barangmasuk->nama_barang_id);
            if ($barang->jumlah >= $barangmasuk->jumlahmasuk) {
                $barang->jumlah -= $barangmasuk->jumlahmasuk;
                $barang->save();

                $barangmasuk->delete();
            }else{
                DB::rollback();
                return redirect()->back()->withErrors('Jumlah Barang tidak mencukupi');
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors('Barang gagal dihapus');
        }return redirect()->back()->with('sukses', 'Barang berhasil dihapus');
    }

    public function print(Request $request){
        $query = BarangMasuk::orderBy('created_at', 'desc');

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

        $barangmasuk = $query->paginate(20);

        $pdf = PDF::loadView('barangmasuk.print', compact('barangmasuk'));
        return $pdf->stream('barangmasuk.pdf');
    }

    public function printid($id){
        $barangmasuk = BarangMasuk::findOrFail($id);
        $pdf = PDF::loadView('barangmasuk.printid', compact('barangmasuk'));
        return $pdf->stream('barangmasuk.pdf');
    }
}
