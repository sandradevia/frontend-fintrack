<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnggaranController;
use App\Http\Controllers\AwalBukuController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DapurController;

// ================= AUTH =================
Route::get('/', function () {
    return redirect()->route('signin');
});

Route::get('/signin', [LoginController::class, 'index'])->name('signin');
Route::post('/signin', [LoginController::class, 'authenticate'])->name('signin.authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// ================= ADMIN =================
Route::middleware(['auth', 'role:admin|super_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'admin'])
            ->name('dashboard');

        Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
        Route::post('/profile', [AdminController::class, 'updateProfile'])->name('admin.update');

        Route::get('/anggaran/bahan', [AnggaranController::class, 'bahan'])->name('anggaran.bahan');
        Route::get('/anggaran/operasional', [AnggaranController::class, 'operasional'])->name('anggaran.operasional');
        Route::get('/anggaran/insentif', [AnggaranController::class, 'insentif'])->name('anggaran.insentif');

        Route::resource('/awal-buku', AwalBukuController::class);
        Route::resource('/transaksi', TransaksiController::class);

        // 🔥 KHUSUS SUPER ADMIN
        Route::middleware('role:super_admin')->group(function () {
            Route::get('/kelola-dapur', [DapurController::class, 'index'])
                ->name('kelola-dapur');
        });
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





















