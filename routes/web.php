<?php

// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\AdminController;
// use App\Http\Controllers\UmumController;
// use App\Http\Controllers\LoginController;
// use App\Http\Middleware\RoleMiddleware;

// Route::get('', function () {
//     return redirect('/login');
// });


// Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
// Route::post('/login', [LoginController::class, 'login']);


// Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth');


// Route::get('/admin', [AdminController::class, 'index'])
//     ->middleware(['auth', RoleMiddleware::class . ':admin']);


// Route::get('/umum', [UmumController::class, 'index'])
//     ->middleware(['auth', RoleMiddleware::class . ':umum']);



// use Illuminate\Support\Facades\Route;
// // Rute untuk Halaman Utama / Dashboard POS
// Route::get('/', function () {
//     // Mengirim data ke view menggunakan array asosiatif
//     return view('dashboard_pos', [
//         'nama_pegawai' => 'Budi Santoso',
//         'shift' => 'Pagi (08:00 - 15:00)'
//     ]);
// });
// // Rute dengan Parameter Wajib (Melihat detail produk berdasarkan ID)
// Route::get('/produk/{id}', function ($id) {
//     return 'Menampilkan data produk dengan ID: ' . $id;
// });
// // Rute dengan Parameter Opsional (Mencari produk berdasarkan nama)
// Route::get('/produk/cari/{nama?}', function ($nama = null) {
//     if ($nama) {
//         return 'Hasil pencarian produk: ' . $nama;
//     }
//     return 'Silakan masukkan kata kunci pencarian pada URL 
//     (contoh: /produk/cari/sabun)';
// });

// // Group Rute untuk Fitur Admin (Manajemen Data)
// Route::prefix('admin')->group(function () {
//     Route::get('/produk', function () {
//         return 'Halaman Kelola Produk (Hanya Admin)';
//     })->name('admin.produk');
//     Route::get('/kategori', function () {
//         return 'Halaman Kelola Kategori Produk (Hanya Admin)';
//     })->name('admin.kategori');
// });
// // Group Rute untuk Fitur Kasir (Transaksi)
// Route::prefix('kasir')->group(function () {
//     Route::get('/transaksi', function () {
//         return 'Halaman Input Transaksi Penjualan (Kasir)';
//     })->name('kasir.transaksi');
// });


// Route::get('/produk-toko', function () {
//     $produk = [
//         [
//             'nama' => 'Beras',
//             'sku' => 'BR001',
//             'harga' => 75000,
//             'gambar' => 'https://www.pastisania.com/storage/app/media/Product%20Images/beras-premium-sania-10-kg.webp',
//             'stok' => 20
//         ],
//         [
//             'nama' => 'Minyak Goreng',
//             'sku' => 'MG001',
//             'harga' => 18000,
//             'gambar' => 'https://cdn.bormadago.com/media/images/products/2021/06/5444a.jpg',
//             'stok' => 30
//         ],
//         [
//             'nama' => 'Gula',
//             'sku' => 'GL001',
//             'harga' => 16000,
//             'gambar' => 'https://cdn.bormadago.com/media/images/products/2021/11/DSC_0569.JPG',
//             'stok' => 25
//         ]
//     ];
//     return view('daftar_produk', compact('produk'));
// });

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\LaporanPenjualanController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
 return view('welcome');
});
// Routing menuju Controller
// Route::get('/produk', [ProdukController::class, 'index']);
// Route::get('/produk/{id}', [ProdukController::class, 'show']);
// Route::get('/laporan', LaporanPenjualanController::class);
Route::resource('product', ProductController::class);

