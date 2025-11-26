<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('seller_id', auth()->id());

        // SEARCH
        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        // FILTER KATEGORI
        if ($request->category) {
            $query->where('category', $request->category);
        }

        // FILTER KONDISI
        if ($request->condition) {
            $query->where('condition', $request->condition);
        }

        // FILTER STATUS (publish/draft)
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // SORTING
        if ($request->sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort === 'price_desc') {
            $query->orderBy('price', 'desc');
        } elseif ($request->sort === 'stock_desc') {
            $query->orderBy('stock', 'desc');
        } else {
            // default newest
            $query->latest();
        }

        $products = $query->paginate(10);

        return view('seller.product-list', compact('products'));
    }

    public function create()
    {
        return view('seller.product'); // halaman upload produk
    }
}
