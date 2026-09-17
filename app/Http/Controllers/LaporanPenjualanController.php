<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanPenjualanController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $laporan = [
            'total_transaksi' => 120,
            'total_produk' => 350,
            'total_pendapatan' => 15750000,
            'produk_terlaris' => 'Laptop ThinkPad'
        ];

        return view('laporan', compact('laporan'));
    }
}
