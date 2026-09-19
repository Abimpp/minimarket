<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class ProductController extends Controller{
    public function index(){
        return "Menampilkan semua produk";
    }
    public function show($id){
        return "Menampilkan produk dengan ID: " . $id;
    }
    public function create(){
        return "Form tambah produk";
    }
    public function store(Request $request){
        return "Menyimpan produk baru";
    }
    public function edit($id){
        return "Form edit produk dengan ID: " . $id;
    }
    public function update(Request $request, $id){
        return "Mengupdate produk dengan ID: " . $id;
    }
    public function destroy($id){
        return "Menghapus produk dengan ID: " . $id;
    }
}