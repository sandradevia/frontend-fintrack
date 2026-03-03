<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;


Route::get('/signin', [LoginController::class, 'index'])->name('signin');
Route::post('/signin', [LoginController::class, 'authenticate'])->name('signin.authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Alias default Laravel auth middleware
Route::get('/login', fn () => redirect()->route('signin'))->name('login');

/*
|--------------------------------------------------------------------------
| DASHBOARD (PROTECTED)
|--------------------------------------------------------------------------
| Kita buat 2 route dashboard: admin & super admin
*/
Route::middleware('auth')->group(function () {

    // Default / -> arahkan sesuai role
    Route::get('/', function () {
        $user = Auth::user();

        // Kalau pakai kolom role
        if (($user->role ?? null) === 'super_admin') {
            return redirect()->route('super.dashboard');
        }

        return redirect()->route('admin.dashboard');
    })->name('dashboard');

    // Admin dashboard
    
});
Route::get('/admin', function () {
        return view('pages.dashboard.ecommerce', ['title' => 'Dashboard Admin']);
    })->name('admin.dashboard');

    // Super admin dashboard (bisa pakai view yang sama dulu)
    Route::get('/super', function () {
        return view('pages.dashboard.ecommerce', ['title' => 'Dashboard Super Admin']);
    })->name('super.dashboard');

    // Super admin only
    Route::get('/kelola-dapur', function () {
        return view('super_admin.kelola-dapur', ['title' => 'Kelola Dapur']);
    })->name('kelola-dapur')->middleware('role:super_admin'); // butuh Spatie
// // calender pages
// Route::get('/calendar', function () {
//     return view('pages.calender', ['title' => 'Calendar']);
// })->name('calendar');

// // profile pages
Route::get('/profile', function () {
    return view('pages.profile', ['title' => 'Profile']);
})->name('profile');

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





















