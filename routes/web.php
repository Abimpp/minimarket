<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::middleware(['auth'])->group(function () {
//     // Khusus Admin
//     Route::middleware('role:admin')->group(function () {
//         Route::get('/admin/dashboard', [
//             AdminController::class,
//             'dashboard'
//         ])->name('admin.dashboard');
//     });

//     // Khusus Kasir
//     Route::middleware('role:kasir')->group(function () {
//         Route::get('/kasir/dashboard', [
//             KasirController::class,
//             'dashboard'
//         ])->name('kasir.dashboard');
//     });

//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__.'/auth.php';


use Illuminate\Support\Facades\DB;

Route::get('/latihan19', function () {
    $keyword = 'Laptop';
    $kategori = 'Elektronik';
    $limit = 5;
    $page = 1;

    $offset = ($page - 1) * $limit;

    $produk = DB::table('produk')
        ->select('id', 'nama_produk', 'kategori', 'harga', 'stok')
        ->where('nama_produk', 'like', "%{$keyword}%")
        ->where('kategori', $kategori)
        ->orderBy('harga', 'desc')
        ->orderBy('id', 'asc')
        ->offset($offset)
        ->limit($limit)
        ->get();

    return view('latihan19', compact('produk'));
});

Route::get('/latihan20', function () {
    $pesanan = DB::table('pesanan')
        ->select('id', 'tanggal_pesan', 'status', 'catatan')
        ->whereIn('status', ['diproses', 'dikirim'])
        ->where('tanggal_pesan', '>=', '2025-10-10')
        ->whereNotNull('catatan')
        ->whereRaw("TRIM(catatan) <> ''")
        ->orderBy('tanggal_pesan', 'asc')
        ->orderBy('id', 'asc')
        ->get();

    return view('latihan20', compact('pesanan'));
});

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ChatController;

Route::post('/orders', [OrderController::class, 'store']);
Route::get('/test-order', function () {
    return view('test-order');
});

Route::get('/chat', [ChatController::class, 'index']);
Route::post('/chat', [ChatController::class, 'store']);
Route::post('/chat/clear', [ChatController::class, 'clear']);