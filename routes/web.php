<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;    

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.Register');
});

Route::get('/barang', function () {
    return view('barang');
})->middleware(['auth','verified'])->name('barang');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class,'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class,'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class,'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// user
Route::get('user',[UserController::class,'index'])->middleware(['role:admin'])->name('user.index');
Route::get('user/create',[UserController::class,'create'])->middleware(['role:admin'])->name('user.create');
Route::post('user/store',[UserController::class,'store'])->middleware(['role:admin'])->name('user.store');
Route::get('user/edit/{id}',[UserController::class,'edit'])->middleware(['role:admin'])->name('user.edit');
Route::put('user/{id}',[UserController::class,'update'])->middleware(['role:admin'])->name('user.update');
Route::get('user/show/{id}',[UserController::class,'show'])->middleware(['role:admin'])->name('user.show');
Route::delete('user/destroy/{id}',[UserController::class,'destroy'])->middleware(['role:admin'])->name('user.destroy');

// barang
Route::get('barang',[BarangController::class,'index'])->middleware(['role:admin,karyawan,atasan'])->name('barang.index');
Route::get('barang/create',[BarangController::class,'create'])->middleware(['role:admin'])->name('barang.create');
Route::post('barang/store',[BarangController::class,'store'])->middleware(['role:admin'])->name('barang.store');
Route::get('barang/edit/{id}',[BarangController::class,'edit'])->middleware(['role:admin'])->name('barang.edit');
Route::put('barang/{id}',[BarangController::class,'update'])->middleware(['role:admin'])->name('barang.update');
Route::delete('barang/destroy/{id}',[BarangController::class,'destroy'])->middleware(['role:admin'])->name('barang.destroy');
Route::get('barang/print', [BarangController::class,'print'])->middleware(['role:admin,karyawan'])->name('barang.print');

// barang keluar
Route::get('barangkeluar', [BarangKeluarController::class,'index'])->middleware(['role:admin,karyawan,atasan'])->name('barangkeluar.index');
Route::get('barangkeluar/keluar', [BarangKeluarController::class,'kurang'])->middleware(['role:admin,karyawan'])->name('barangkeluar.kurang');
Route::post('barangkeluar/store/',[BarangkeluarController::class,'store'])->middleware(['role:admin,karyawan'])->name('barangkeluar.store');
Route::delete('barangkeluar/destroy/{id}',[BarangKeluarController::class,'destroy'])->middleware(['role:admin,karyawan'])->name('barangkeluar.destroy');
Route::get('barangkeluar/print', [BarangKeluarController::class,'print'])->middleware(['role:admin,karyawan'])->name('barangkeluar.print');
Route::get('barangkeluar/printdata/{id}', [BarangKeluarController::class,'printid'])->middleware(['role:admin,karyawan'])->name('barangkeluar.printid');

// barang masuk
Route::get('barangmasuk', [BarangMasukController::class, 'index'])->middleware(['role:admin,karyawan,atasan'])->name('barangmasuk.index');
Route::get('barangmasuk/tambah', [BarangMasukController::class,'tambah'])->middleware(['role:admin'])->name('barangmasuk.tambah');
Route::post('barangmasuk/store/',[BarangMasukController::class,'store'])->middleware(['role:admin'])->name('barangmasuk.store');
Route::delete('barangmasuk/destroy/{id}',[BarangMasukController::class,'destroy'])->middleware(['role:admin'])->name('barangmasuk.destroy');
Route::get('barangmasuk/print', [BarangMasukController::class,'print'])->middleware(['role:admin,karyawan'])->name('barangmasuk.print');
Route::get('barangmasuk/printdata/{id}', [BarangMasukController::class,'printid'])->middleware(['role:admin,karyawan'])->name('barangmasuk.printid');

// barang kembali
Route::get('barangkembali', [BarangKembaliController::class, 'index'])->middleware(['role:admin,karyawan,atasan'])->name('barangkembali.index');
Route::get('barangkembali/kembali', [BarangKembaliController::class,'kembali'])->middleware(['role:admin,karyawan'])->name('barangkembali.kembali');
Route::post('barangkembali/store/',[BarangKembaliController::class,'store'])->middleware(['role:admin,karyawan'])->name('barangkembali.store');
Route::delete('barangkembali/destroy/{id}',[BarangKembaliController::class,'destroy'])->middleware(['role:admin,karyawan'])->name('barangkembali.destroy');
Route::get('barangkembali/print', [BarangKembaliController::class,'print'])->middleware(['role:admin,karyawan'])->name('barangkembali.print');
Route::get('barangkembali/printdata/{id}', [BarangKembaliController::class,'printid'])->middleware(['role:admin,karyawan'])->name('barangkembali.printid');   

// kode barang
Route::get('kodebarang',[KodeBarangController::class,'index'])->middleware(['role:admin,karyawan,atasan'])->name('kodebarang.index');
Route::get('kodebarang/print', [KodeBarangController::class,'print'])->middleware(['role:admin,karyawan'])->name('kodebarang.print');
