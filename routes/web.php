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
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\InputBarangController;
use App\Http\Controllers\PenerimaanBarangController;
use App\Http\Controllers\PengeluaranBarangController;
use App\Http\Controllers\LaporanStockController;
use App\Http\Controllers\KelolaDapurController;
use App\Http\Controllers\NotificationController;

// ================= AUTH =================
Route::get('/', function () {
    return view('landingpage');
})->name('landingpage');

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
Route::middleware(['auth', 'role:admin_dapur|super_admin'])
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

        Route::get('/awal-buku', [AwalBukuController::class, 'index'])->name('awal-buku.saldo');
        Route::any('/awal-buku/update', [AwalBukuController::class, 'updateSaldo'])->name('awal-buku.update');

        // Modul Manajemen Periode
        Route::get('/periode', [PeriodeController::class, 'index'])->name('periode.index');
        Route::post('/periode/store', [PeriodeController::class, 'store'])->name('periode.store');
        
        Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.transaksi');
        Route::post('/transaksi/store', [TransaksiController::class, 'store'])->name('transaksi.store');
        Route::put('/transaksi/update/{id}', [TransaksiController::class, 'update'])->name('transaksi.update');
        Route::get('/transaksi/search-akun', [TransaksiController::class, 'searchAkun'])->name('transaksi.search-akun');

        Route::get('/bku', [BkuController::class, 'index'])->name('bku.index');
        Route::get('/admin/bku/export-excel', [BkuController::class, 'exportExcel'])->name('bku.export.excel');

        Route::get('/bpkas', [BpkasController::class, 'index'])->name('bp-kas.index');

        // BP OPERASIONAL
        Route::get('/bp-operasional', [BpOperasionalController::class, 'index'])->name('bp-operasional.index');
        Route::get('/bp-operasional/export', [BpOperasionalController::class, 'export'])->name('bp-operasional.export');

        // BP INSENTIF
        Route::get('/bp-insentif', [BpInsentifController::class, 'index'])->name('bp-insentif.index');
        Route::get('/bp-insentif/export', [BpInsentifController::class, 'export'])->name('bp-insentif.export');

        // LP ANGGARAN
        Route::get('/lp-anggaran', [LpAnggaranController::class, 'index'])->name('lp-anggaran.index');
        Route::get('/lp-anggaran/export/pdf', [LpAnggaranController::class, 'exportPdf'])->name('lp-anggaran.pdf');

        Route::get('/lp-anggaran/export/word', [LpAnggaranController::class, 'exportWord'])->name('lp-anggaran.word');

        // SP TANGGUNG JAWAB
        Route::get('/sp-tanggungjawab', [SpTanggungjawabController::class, 'index'])->name('sp-tanggungjawab.index');

        // BAP SISA DANA
        Route::get('/bap-sisadana', [BapSisadanaController::class, 'index'])->name('bap-sisadana.index');
        Route::get('/bap-sisadana/pdf', [BapSisadanaController::class, 'exportPdf'])->name('bp-sisadana.pdf');
        Route::get('/bap-sisadana/word', [BapSisadanaController::class, 'exportWord'])->name('bp-sisadana.word');

        // DAFTAR NOMINATIF
        Route::get('/daftar-nominatif', [DaftarNominatifController::class, 'index'])->name('daftar-nominatif.index');
        Route::post('/daftar-nominatif', [DaftarNominatifController::class, 'store'])->name('daftar-nominatif.store');
        Route::put('/daftar-nominatif/{id}', [DaftarNominatifController::class, 'update'])->name('daftar-nominatif.update');
        Route::delete('/daftar-nominatif/{id}', [DaftarNominatifController::class, 'destroy'])->name('daftar-nominatif.destroy');
        Route::get('/daftar-nominatif/export/excel', [DaftarNominatifController::class, 'exportExcel'])->name('daftar-nominatif.export.excel');

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

        Route::get('/awal-buku', [AwalBukuController::class, 'superIndex'])->name('awal-buku.index');
        Route::any('/awal-buku/update', [AwalBukuController::class, 'updateSaldo'])->name('awal-buku.update');

        Route::get('/anggaran/bahan', [AnggaranController::class, 'SuperBahan'])->name('anggaran.index');

        // BP OPERASIONAL
        Route::get('/bp-operasional', [BpOperasionalController::class, 'superIndex'])->name('bp-operasional.index');
        Route::get('/bp-operasional/export', [BpOperasionalController::class, 'export'])->name('bp-operasional.export');

        // BP INSENTIF
        Route::get('/bp-insentif', [BpInsentifController::class, 'superIndex'])->name('bp-insentif.index');
        Route::get('/bp-insentif/export', [BpInsentifController::class, 'export'])->name('bp-insentif.export');

        // LP ANGGARAN
        Route::get('/lp-anggaran', [LpAnggaranController::class, 'superIndex'])->name('lp-anggaran.index');
        Route::get('/lp-anggaran/export/pdf', [LpAnggaranController::class, 'exportPdf'])->name('lp-anggaran.pdf');

        Route::get('/lp-anggaran/export/word', [LpAnggaranController::class, 'exportWord'])->name('lp-anggaran.word');

        Route::get('/transaksi', [TransaksiController::class, 'superIndex'])->name('transaksi.index');
        Route::post('/transaksi/store', [TransaksiController::class, 'store'])->name('transaksi.store');
        Route::put('/transaksi/update/{id}', [TransaksiController::class, 'update'])->name('transaksi.update');
        Route::get('/transaksi/search-akun', [TransaksiController::class, 'searchAkun'])->name('transaksi.search-akun');

        //bku
        Route::get('/bku', [BkuController::class, 'superIndex'])->name('bku.index');
        Route::get('/admin/bku/export-excel', [BkuController::class, 'exportExcel'])->name('bku.export.excel');

        Route::get('/bpkas', [BpkasController::class, 'superIndex'])->name('bp-kas.index');

        // DAFTAR NOMINATIF
        Route::get('/daftar-nominatif', [DaftarNominatifController::class, 'superIndex'])->name('daftar-nominatif.index');

        // CATATAN PENGELUARAN
        Route::get('/catatan-pengeluaran', [CatatanPengeluaranController::class, 'superIndex'])->name('catatan-pengeluaran.index');
        Route::get('/catatan-pengeluaran/export', [CatatanPengeluaranController::class, 'export'])->name('catatan-pengeluaran.export');

        // PENERIMAAN BARANG
        Route::prefix('penerimaan-barang')->name('penerimaan-barang.')->group(function () {

            Route::get('/', [PenerimaanBarangController::class, 'superIndex'])->name('index');
            Route::post('/', [PenerimaanBarangController::class, 'store'])->name('store');

            Route::get('/{id}/edit', [PenerimaanBarangController::class, 'edit'])->name('edit');
            Route::put('/{id}', [PenerimaanBarangController::class, 'update'])->name('update');
            Route::delete('/{id}', [PenerimaanBarangController::class, 'destroy'])->name('destroy');

        });

        Route::prefix('pengeluaran-barang')->name('pengeluaran-barang.')->group(function () {
            Route::get('/', [PengeluaranBarangController::class, 'superIndex'])->name('index');
            Route::post('/', [PengeluaranBarangController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [PengeluaranBarangController::class, 'edit'])->name('edit');
            Route::get('/stok/{barang_id}', [PengeluaranBarangController::class, 'getStok']);
            Route::put('/{id}', [PengeluaranBarangController::class, 'update'])->name('update');
            Route::delete('/{id}', [PengeluaranBarangController::class, 'destroy'])->name('destroy');
        });

        // LAPORAN STOCK
        Route::get('/laporan-stock', [LaporanStockController::class, 'superIndex'])->name('laporan-stock.index');
        Route::get('/laporan-stock/export', [LaporanStockController::class, 'exportStok'])->name('laporan.stock.export');

        // LIST ANGGOTA

        Route::prefix('petugas')->group(function () {

            Route::get('/', [AnggotaController::class, 'index'])->name('petugas.index');

            Route::post('/store', [AnggotaController::class, 'store'])->name('petugas.store');

            Route::put('/update/{id}', [AnggotaController::class, 'update'])->name('petugas.update');

            Route::delete('/delete/{id}', [AnggotaController::class, 'destroy'])->name('petugas.destroy');

        });
    });

















