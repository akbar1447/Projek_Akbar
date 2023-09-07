<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Barang;
use App\Models\KodeBarang;
use App\Models\BarangKeluar;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;  

class BarangController extends Controller
{
    public function index(Request $request){
        $query = Barang::orderBy('created_at', 'desc');

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
        if ($request->has('nama_barang')) {
            $nama_barang = $request->nama_barang;
            if (!empty($nama_barang)) {
                $query->where('nama_barang', $nama_barang);
            }
        }

        if ($request->has('type')) {
            $type = $request->type;
            if (!empty($type)) {
                $query->where('type', $type);
            }
        }

        $barang = $query->paginate(20);

        return view('barang.index')
            ->with('barang', $barang);
    }

    public function create(){
        return view('barang.create');
    }

    public function store(Request $request){
        $request->validate([
            'nama_barang' => 'required',
            'type' => 'required',
            'tahun' => 'required|numeric',
            'jumlah' => 'required|numeric',
            'gambar' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);

        
        DB::beginTransaction();

        try {
            $barang = new Barang;
            $barang->nama_barang= $request->nama_barang;
            $barang->tahun = $request->tahun;
            $barang->jumlah = $request->jumlah;

            $namabarang = $request->type . ' ' . $request->tahun; // Combine year and type
            $barang->type = $namabarang;

            if ($request->hasFile('gambar')) {
                $gambarFile = $request->file('gambar');
                $gambarFileName = $gambarFile->getClientOriginalName();
                $gambarFile->move(public_path('gambar_barang'), $gambarFileName);
                $barang->gambar = $gambarFileName;
            }

            $barang->save();

            $this->generateKodeBarang($barang);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['barang gagal disimpan'])->withInput();
        }
        return redirect('barang')->with('sukses', 'barang berhasil disimpan.');
    }

    private function generateKodeBarang(Barang $barang){
        $latestBarang = Barang::latest()->first();
        $newId = $latestBarang ? $latestBarang->id + 1 : 1;
        $barang->id = $newId;

        $barangFromTable = Barang::find($barang->id);

        if ($barangFromTable) {
            $code = $barangFromTable->code;
        } else {
            $code = $barang->id . $barang->tahun . date('m');
        }

        $barang->code = $code;
        $barang->save();
    }

    public function edit(string $id){
        $barang = Barang::find($id);
        return view('barang.edit')->with('barang',$barang);
    }

    public function update(Request $request, string $id){
        $request->validate([
            'nama_barang' => 'required',
            'type' => 'required',
            'tahun' => 'required|numeric',
            'jumlah' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);

        DB::beginTransaction();
        
        try{
            $barang = Barang::findOrFail($id);

            $barang->nama_barang = $request->nama_barang;
            $barang->type = $request->type;
            $barang->tahun = $request->tahun;
            $barang->jumlah = $request->jumlah;

            if ($request->hasFile('gambar')) {
                $gambarFile = $request->file('gambar');
                $gambarFileName = $gambarFile->getClientOriginalName();
                $gambarFile->move(public_path('gambar_barang'), $gambarFileName);
                $barang->gambar = $gambarFileName;
            } elseif (!$barang->gambar) {
                // Jika tidak ada gambar yang diunggah dan tidak ada gambar sebelumnya, atur gambar ke null atau isi dengan nilai default jika ada
                $barang->gambar = null; // Atau ganti dengan nilai default
            }

            $barang->save();
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->withErrors(['barang gagal disimpan'])->withInput();
        }
        return redirect('barang')->with('sukses','barang berhasil di simpan.');
    }

    public function destroy(string $id){
        DB::beginTransaction();

        try{
            BarangKeluar::where('nama_barang_id', $id)->delete();
            Barang::findOrFail($id)->delete();
            DB::commit();
        }
        catch(\Exception $e ){
            DB::rollback();
            return redirect()->back()->withErrors(['barang gagal dihapus']);
        }
        return redirect()->back()->with('sukses','barang berhasil dihapus');
    }

    public function print(Request $request){
        $query = Barang::orderBy('created_at', 'desc');

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

        if ($request->has('nama_barang')) {
            $nama_barang = $request->nama_barang;
            if (!empty($nama_barang)) {
                $query->where('nama_barang', $nama_barang);
            }
        }

        if ($request->has('type')) {
            $type = $request->type;
            if (!empty($type)) {
                $query->where('type', $type);
            }
        }

        $barang = $query->paginate(20);

        // Cetak PDF dengan tampilan 'barang.print'
        $pdf = PDF::loadView('barang.print', compact('barang'));
        return $pdf->stream('barang.pdf');
    }
}
