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
use App\Http\Controllers\InputBarangController;
use App\Http\Controllers\PenerimaanBarangController;
use App\Http\Controllers\PengeluaranBarangController;
use App\Http\Controllers\LaporanStockController;
use App\Http\Controllers\KelolaDapurController;

// ================= AUTH =================
Route::get('/', function () {
    return redirect()->route('signin');
});

Route::get('/signin', [LoginController::class, 'index'])->name('signin');
Route::post('/signin', [LoginController::class, 'authenticate'])->name('signin.authenticate');

Route::post('/pilih-dapur/{id}', [LoginController::class, 'pilihDapur']);

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

        Route::get('/bku', [BkuController::class, 'index'])->name('bku.index');

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


        // // 🔥 KHUSUS SUPER ADMIN
        // Route::middleware('role:super_admin')->group(function () {
        //     Route::get('/kelola-dapur', [KelolaDapurController::class, 'index'])
        //         ->name('super.kelola-dapur.index');
        // });
});


// ================= SUPER ADMIN =================
Route::middleware(['auth', 'role:super_admin'])
    ->prefix('super')
    ->name('super.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'superAdmin'])
            ->name('dashboard');
});
    // Route::middleware('auth', 'admin')->group(function () {

    // Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Route::get('/dashboard/admin', [DashboardController::class, 'admin'])
    //     ->name('admin.dashboard');

    // Route::get('/dashboard/super-admin', [DashboardController::class, 'superAdmin'])
    //     ->name('super.dashboard');
        
// ====== TAMBAHAN ADMIN ======

    // // Anggaran Admin
    // Route::get('/admin/anggaran', [AnggaranController::class, 'index'])
    //     ->name('admin.anggaran');

    // Route::get('/admin/anggaran/create', [AnggaranController::class, 'create'])
    //     ->name('admin.anggaran.create');

    // Route::post('/admin/anggaran', [AnggaranController::class, 'store'])
    //     ->name('admin.anggaran.store');



// // // profile pages
// Route::get('/profile', function () {
//     return view('pages.profile', ['title' => 'Profile']);
// })->name('profile');

// Route::get('/saldo-awal-buku', function () {
//     return view('pages.saldo', ['title' => 'Saldo Awal Buku']);
// })->name('saldo-awal-buku');

// Route::prefix('anggaran')->group(function () {
//     Route::get('/bahan', [AnggaranController::class, 'bahan'])->name('anggaran-bahan');
//     Route::get('/operasional', [AnggaranController::class, 'operasional'])->name('anggaran-operasional');
//     Route::get('/insentif', [AnggaranController::class, 'insentif'])->name('anggaran-insentif');
// });
// // form pages
// Route::get('/form-elements', function () {
//     return view('pages.form.form-elements', ['title' => 'Form Elements']);
// })->name('form-elements');

// // tables pages
// Route::get('/basic-tables', function () {
//     return view('pages.tables.basic-tables', ['title' => 'Basic Tables']);
// })->name('basic-tables');

// // pages

// Route::get('/blank', function () {
//     return view('pages.blank', ['title' => 'Blank']);
// })->name('blank');

// // error pages
// Route::get('/error-404', function () {
//     return view('pages.errors.error-404', ['title' => 'Error 404']);
// })->name('error-404');

// // chart pages
// Route::get('/line-chart', function () {
//     return view('pages.chart.line-chart', ['title' => 'Line Chart']);
// })->name('line-chart');

// Route::get('/bar-chart', function () {
//     return view('pages.chart.bar-chart', ['title' => 'Bar Chart']);
// })->name('bar-chart');


// // authentication pages


// Route::get('/signup', function () {
//     return view('pages.auth.signup', ['title' => 'Sign Up']);
// })->name('signup');

// // ui elements pages
// Route::get('/alerts', function () {
//     return view('pages.ui-elements.alerts', ['title' => 'Alerts']);
// })->name('alerts');

// Route::get('/avatars', function () {
//     return view('pages.ui-elements.avatars', ['title' => 'Avatars']);
// })->name('avatars');

// Route::get('/badge', function () {
//     return view('pages.ui-elements.badges', ['title' => 'Badges']);
// })->name('badges');

// Route::get('/buttons', function () {
//     return view('pages.ui-elements.buttons', ['title' => 'Buttons']);
// })->name('buttons');

// Route::get('/image', function () {
//     return view('pages.ui-elements.images', ['title' => 'Images']);
// })->name('images');

// Route::get('/videos', function () {
//     return view('pages.ui-elements.videos', ['title' => 'Videos']);
// })->name('videos');

// Route::middleware(['auth'])->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// });

// Route::prefix('admin')->middleware(['auth'])->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
// });





















