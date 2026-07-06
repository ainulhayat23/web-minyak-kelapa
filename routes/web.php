<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman Publik
|--------------------------------------------------------------------------
*/

// Beranda
Route::get('/', [HomeController::class, 'index'])
    ->name('home');

/*
|--------------------------------------------------------------------------
| Katalog Produk
|--------------------------------------------------------------------------
*/

// Daftar produk
Route::get('/produk', [CatalogController::class, 'index'])
    ->name('catalog.index');

// Detail produk berdasarkan slug
Route::get('/produk/{product:slug}', [CatalogController::class, 'show'])
    ->name('catalog.show');

/*
|--------------------------------------------------------------------------
| Blog dan Kegiatan
|--------------------------------------------------------------------------
*/

// Daftar kegiatan
Route::get('/kegiatan', [BlogController::class, 'index'])
    ->name('blog.index');

// Detail kegiatan berdasarkan slug
Route::get('/kegiatan/{post:slug}', [BlogController::class, 'show'])
    ->name('blog.show');

/*
|--------------------------------------------------------------------------
| Keranjang dan Checkout Khusus Pengunjung
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Keranjang Belanja
    |--------------------------------------------------------------------------
    */

    // Menampilkan isi keranjang
    Route::get('/keranjang', [CartController::class, 'index'])
        ->name('cart.index');

    // Menambahkan produk ke keranjang
    Route::post('/keranjang/tambah/{product}', [CartController::class, 'add'])
        ->name('cart.add');

    // Memperbarui jumlah produk
    Route::patch('/keranjang/{product}', [CartController::class, 'update'])
        ->name('cart.update');

    // Menghapus satu produk
    Route::delete('/keranjang/{product}', [CartController::class, 'remove'])
        ->name('cart.remove');

    // Mengosongkan seluruh keranjang
    Route::delete('/keranjang', [CartController::class, 'clear'])
        ->name('cart.clear');

    /*
    |--------------------------------------------------------------------------
    | Checkout Pelanggan
    |--------------------------------------------------------------------------
    */

    // Menampilkan formulir checkout
    Route::get('/checkout', [CheckoutController::class, 'create'])
        ->name('checkout.create');

    // Menyimpan pesanan pelanggan
    Route::post('/checkout', [CheckoutController::class, 'store'])
        ->name('checkout.store');
});

/*
|--------------------------------------------------------------------------
| Dashboard Admin
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Halaman yang Memerlukan Login Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Profil Admin
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Pengelolaan Admin
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin')
        ->name('admin.')
        ->group(function () {

            /*
            |--------------------------------------------------------------------------
            | Pengelolaan Produk
            |--------------------------------------------------------------------------
            */

            Route::resource('products', ProductController::class);

            /*
            |--------------------------------------------------------------------------
            | Pengelolaan Blog dan Kegiatan
            |--------------------------------------------------------------------------
            */

            Route::resource('posts', PostController::class);

            /*
            |--------------------------------------------------------------------------
            | Pengelolaan Pesanan
            |--------------------------------------------------------------------------
            */

            // Menampilkan pesanan aktif
            Route::get('/orders', [OrderController::class, 'index'])
                ->name('orders.index');

            /*
            |--------------------------------------------------------------------------
            | Route khusus harus diletakkan sebelum /orders/{order}
            |--------------------------------------------------------------------------
            |
            | Hal ini mencegah kata "history" atau "notifications" dianggap
            | sebagai ID pesanan.
            |
            */

            // Menampilkan riwayat pesanan selesai dan dibatalkan
            Route::get('/orders/history', [OrderController::class, 'history'])
                ->name('orders.history');

            // Mengambil ringkasan notifikasi pesanan belum dibaca
            Route::get(
                '/orders/notifications/summary',
                [OrderController::class, 'notificationSummary']
            )->name('orders.notifications.summary');

            // Menampilkan detail pesanan
            Route::get('/orders/{order}', [OrderController::class, 'show'])
                ->whereNumber('order')
                ->name('orders.show');

            // Mengubah status pesanan
            Route::patch(
                '/orders/{order}/status',
                [OrderController::class, 'updateStatus']
            )
                ->whereNumber('order')
                ->name('orders.update-status');
        });
});

/*
|--------------------------------------------------------------------------
| Route Autentikasi Laravel Breeze
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';