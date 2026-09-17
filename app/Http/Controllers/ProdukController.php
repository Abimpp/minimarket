<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(){
    $kategori = "Elektronik";
    $daftarProduk = [
        ['id' => 1, 'nama' => 'Laptop ThinkPad', 'harga' => 12500000],
        ['id' => 2, 'nama' => 'Mouse Wireless', 'harga' => 250000],
        ['id' => 3, 'nama' => 'Mechanical Keyboard', 'harga' => 850000],
        ];
        return view('index', compact('kategori', 'daftarProduk'));
    }

    public function show($id){
        return view('detail', ['id' => $id]);
    }
}
