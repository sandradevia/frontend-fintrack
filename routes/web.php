<?php

use App\Http\Controllers\BpKasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnggaranController;
use App\Http\Controllers\AwalBukuController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DapurController;
use App\Http\Controllers\BkuController;
use App\Http\Controllers\BpOperasionalController;
use App\Http\Controllers\BpInsentifController;
use App\Http\Controllers\LpAnggaranController;
use App\Http\Controllers\SpTanggungjawabController;
use App\Http\Controllers\BapSisadanaController;
use App\Http\Controllers\DaftarNominatifController;
use App\Http\Controllers\CatatanPengeluaranController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\InputBarangController;
use App\Http\Controllers\PenerimaanBarangController;
use App\Http\Controllers\PengeluaranBarangController;
use App\Http\Controllers\LaporanStockController;
use App\Http\Controllers\KelolaDapurController;
use App\Http\Controllers\NotificationController;

// ================= AUTH =================
Route::get('/', function () {
    return redirect()->route('signin');
});

Route::get('/notifications', [NotificationController::class, 'index'])
    ->name('notifications.index');

Route::get('/notifications/read/{id}', [NotificationController::class, 'read'])
    ->name('notifications.read');

Route::get('/signin', [LoginController::class, 'index'])->name('signin');
Route::post('/signin', [LoginController::class, 'authenticate'])->name('signin.authenticate');

Route::post('/pilih-dapur/utama', [LoginController::class, 'dapurUtama'])
    ->name('dapur.utama');

Route::post('/pilih-dapur/{id}', [LoginController::class, 'pilihDapur'])
    ->whereNumber('id')
    ->name('pilih.dapur');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ================= ADMIN =================
Route::middleware(['auth', 'role:admin|super_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'admin'])
            ->name('dashboard');

        Route::get('/profile', [DapurController::class, 'index'])->name('profile.profile');
        Route::put('/profile/{id}/update', [DapurController::class, 'update'])->name('profile.update');

        Route::get('/anggaran/bahan', [AnggaranController::class, 'bahan'])->name('anggaran.bahan');
        Route::get('/anggaran/operasional', [AnggaranController::class, 'operasional'])->name('anggaran.operasional');
        Route::get('/anggaran/insentif', [AnggaranController::class, 'insentif'])->name('anggaran.insentif');

        Route::resource('/awal-buku', AwalBukuController::class);
        Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.transaksi');
        Route::post('/transaksi/store', [TransaksiController::class, 'store'])->name('transaksi.store');
        Route::get('/transaksi/search-akun', [TransaksiController::class, 'searchAkun'])->name('transaksi.search-akun');

        Route::get('/bku', [BkuController::class, 'index'])->name('bku.index');
        Route::get('/admin/bku/export-excel', [BkuController::class, 'exportExcel'])->name('bku.export.excel');

        Route::get('/bpkas', [BpkasController::class, 'index'])->name('bp-kas.index');

        // BP OPERASIONAL
        Route::get('/bp-operasional', [BpOperasionalController::class, 'index'])->name('bp-operasional.index');

        // BP INSENTIF
        Route::get('/bp-insentif', [BpInsentifController::class, 'index'])->name('bp-insentif.index');

        // LP ANGGARAN
        Route::get('/lp-anggaran', [LpAnggaranController::class, 'index'])->name('lp-anggaran.index');

        // SP TANGGUNG JAWAB
        Route::get('/sp-tanggungjawab', [SpTanggungjawabController::class, 'index'])->name('sp-tanggungjawab.index');

        // BAP SISA DANA
        Route::get('/bap-sisadana', [BapSisadanaController::class, 'index'])->name('bap-sisadana.index');

        // DAFTAR NOMINATIF
        Route::get('/daftar-nominatif', [DaftarNominatifController::class, 'index'])->name('daftar-nominatif.index');

        // CATATAN PENGELUARAN
        Route::get('/catatan-pengeluaran', [CatatanPengeluaranController::class, 'index'])->name('catatan-pengeluaran.index');
        Route::get('/catatan-pengeluaran/export', [CatatanPengeluaranController::class, 'export'])->name('catatan-pengeluaran.export');

        // INPUT BARANG
        Route::get('/input-barang', [InputBarangController::class, 'index'])->name('input-barang.index');
        Route::post('/input-barang', [InputBarangController::class, 'store'])->name('input-barang.store');
        Route::delete('/input-barang/{id}', [InputBarangController::class, 'destroy'])->name('input-barang.destroy');
        Route::put('/input-barang/{id}', [InputBarangController::class, 'update'])->name('input-barang.update');


        // PENERIMAAN BARANG
        Route::prefix('penerimaan-barang')->name('penerimaan-barang.')->group(function () {

            Route::get('/', [PenerimaanBarangController::class, 'index'])->name('index');
            Route::post('/', [PenerimaanBarangController::class, 'store'])->name('store');

            Route::get('/{id}/edit', [PenerimaanBarangController::class, 'edit'])->name('edit');
            Route::put('/{id}', [PenerimaanBarangController::class, 'update'])->name('update');
            Route::delete('/{id}', [PenerimaanBarangController::class, 'destroy'])->name('destroy');

        });

        Route::prefix('pengeluaran-barang')->name('pengeluaran-barang.')->group(function () {
            Route::get('/', [PengeluaranBarangController::class, 'index'])->name('index');
            Route::post('/', [PengeluaranBarangController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [PengeluaranBarangController::class, 'edit'])->name('edit');
            Route::get('/stok/{barang_id}', [PengeluaranBarangController::class, 'getStok']);
            Route::put('/{id}', [PengeluaranBarangController::class, 'update'])->name('update');
            Route::delete('/{id}', [PengeluaranBarangController::class, 'destroy'])->name('destroy');
        });

        // LAPORAN STOCK
        Route::get('/laporan-stock', [LaporanStockController::class, 'index'])->name('laporan-stock.index');
        Route::get('/laporan-stock/export', [LaporanStockController::class, 'exportStok'])->name('laporan.stock.export');

        // LIST ANGGOTA

        Route::prefix('petugas')->group(function () {

            Route::get('/', [AnggotaController::class, 'index'])->name('petugas.index');

            Route::post('/store', [AnggotaController::class, 'store'])->name('petugas.store');

            Route::put('/update/{id}', [AnggotaController::class, 'update'])->name('petugas.update');

            Route::delete('/delete/{id}', [AnggotaController::class, 'destroy'])->name('petugas.destroy');

        });

});


// ================= SUPER ADMIN =================
Route::middleware(['auth', 'role:super_admin'])
    ->prefix('super')
    ->name('super.')
    ->group(function () {

        // DASHBOARD
        Route::get('/dashboard', [DashboardController::class, 'superAdmin'])
            ->name('dashboard');

        // INDEX
        Route::get('/kelola-dapur', [KelolaDapurController::class, 'index'])
            ->name('kelola-dapur.index');

        // CREATE PAGE
        Route::get('/kelola-dapur/create', [KelolaDapurController::class, 'create'])
            ->name('kelola-dapur.create');

        // STORE
        Route::post('/kelola-dapur', [KelolaDapurController::class, 'store'])
            ->name('kelola-dapur.store');

        // SHOW (DETAIL)
        Route::get('/kelola-dapur/{id}', [KelolaDapurController::class, 'show'])
            ->name('kelola-dapur.show');

        // EDIT PAGE
        Route::get('/kelola-dapur/{id}/edit', [KelolaDapurController::class, 'edit'])
            ->name('kelola-dapur.edit');

        // UPDATE
        Route::put('/kelola-dapur/{id}', [KelolaDapurController::class, 'update'])
            ->name('kelola-dapur.update');

        // DELETE
        Route::delete('/kelola-dapur/{id}', [KelolaDapurController::class, 'destroy'])
            ->name('kelola-dapur.destroy');
    });

















