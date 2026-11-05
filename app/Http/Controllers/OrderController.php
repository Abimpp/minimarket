<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Events\OrderPlaced;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data pesanan
        $request->validate([
            'total' => 'required|numeric|min:0',
        ]);

        // Jika belum login, gunakan user yang ada atau buat user testing default
        $user = auth()->user() ?? User::first() ?? User::firstOrCreate(
            ['email' => 'tester@minimarket.test'],
            ['name' => 'Tester User', 'password' => bcrypt('password'), 'role' => 'admin']
        );

        // Menyimpan pesanan
        $order = Order::create([
            'user_id' => $user->id,
            'total' => $request->total,
        ]);

        // Memanggil event OrderPlaced
        event(new OrderPlaced($order, $user));

        return response()->json([
            'message' => 'Pesanan berhasil dibuat',
            'data' => $order
        ], 201);
    }
}