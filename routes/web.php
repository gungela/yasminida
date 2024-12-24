<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CetakController;
use App\Http\Controllers\MasukController;
use App\Http\Controllers\RusakController;
use App\Http\Controllers\KeluarController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProduksiController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TersediaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;

Route::get('/', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('user', UserController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('pelanggan', PelangganController::class);
    Route::get('/produksi/print', [ProduksiController::class, 'print'])->name('produksi.print');
    Route::get('/tersedia/print', [TersediaController::class, 'print'])->name('tersedia.print');
    Route::get('/masuk/print', [MasukController::class, 'print'])->name('masuk.print');
    Route::get('/keluar/print', [KeluarController::class, 'print'])->name('keluar.print');
    Route::get('/rusak/print', [RusakController::class, 'print'])->name('rusak.print');
    Route::resource('produksi', ProduksiController::class);
    Route::resource('tersedia', TersediaController::class);
    Route::resource('masuk', MasukController::class);
    Route::resource('keluar', KeluarController::class);
    Route::resource('rusak', RusakController::class);
    Route::get('/cetak',[CetakController::class,'index'])->name('cetak');
    Route::post('/cetak-pdf', [CetakController::class, 'cetakPDF'])->name('cetak.pdf');
    Route::get('/users/print', [UserController::class, 'print'])->name('user.print');
    Route::get('/suppliers/print', [SupplierController::class, 'print'])->name('suppliers.print');
    Route::get('/pelanggans/print', [PelangganController::class, 'print'])->name('pelanggans.print');

    Route::get('/get-jumlah-product/{product}', [KeluarController::class, 'getJumlahProduct']);
});

require __DIR__ . '/auth.php';
