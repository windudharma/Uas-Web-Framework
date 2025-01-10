<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MembershipController;
use Symfony\Component\HttpKernel\Profiler\Profile;

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






Route::get('/', [HomeController::class, 'index']);


Route::get('/search', [HomeController::class, 'search'])->name('search');


Route::get('/aset/{id}/{nama}', [HomeController::class, 'popup'])->name('aset.popup');

Route::get('/aset/{id}/{nama}', [HomeController::class, 'show'])->name('aset.show');





Route::middleware(['auth', 'is_admin'])->prefix('assets')->name('assets.')->group(function () {
    Route::get('/', [AssetController::class, 'index'])->name('index');
    Route::get('/create', [AssetController::class, 'create'])->name('create'); // Form tambah data
    Route::post('/store', [AssetController::class, 'store'])->name('store');  // Simpan data
    Route::get('/{asset}/edit', [AssetController::class, 'edit'])->name('edit');
    Route::put('/{asset}', [AssetController::class, 'update'])->name('update');
});

Route::get('/transaksi', [DashboardController::class, 'transaksi'])
->middleware(['auth', 'is_admin'])
->name('transaksi');

Route::get('/transaksi/export-pdf', [DashboardController::class, 'exportPdf'])->name('transaksi.export-pdf');


Route::post('/download', [AssetController::class, 'download'])
    ->middleware(['auth', 'check.download.limit'])
    ->name('assets.download');



Route::get('/dashboard', [DashboardController::class, 'download'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

    Route::get('/subscription', [DashboardController::class, 'subscription'])
    ->middleware(['auth', 'verified'])
    ->name('subscription');

    Route::middleware(['auth', 'is_admin'])->group(function () {
        Route::post('/update-role', [ProfileController::class, 'updateRole'])->name('update.role');
        Route::get('/update-role', [ProfileController::class, 'showUpdateRoleForm'])->name('update.role.form');
    });


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});



require __DIR__.'/auth.php';





// Route::get('/download/{id}', [DownloadController::class, 'download'])->middleware(['auth', 'check.membership']);



Route::get('/checkout/{membership}', [MembershipController::class, 'checkout'])->name('membership.checkout');
Route::post('/checkout/{membership}', [MembershipController::class, 'processCheckout'])->name('membership.processCheckout');
Route::get('/thank-you', [MembershipController::class, 'thankYou'])->name('membership.thankYou');
