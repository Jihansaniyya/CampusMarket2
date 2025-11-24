<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('seller.product');
    }

    public function create()
    {
        return view('seller.product'); // sesuai file product.blade.php
    }

    public function store(Request $request)
    {
        // sementara biar tidak error
        return back()->with('success', 'Produk berhasil disimpan!');
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
