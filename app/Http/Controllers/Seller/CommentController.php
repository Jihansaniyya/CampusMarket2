<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductComment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index()
    {
        // Ambil ID seller yang login
        $sellerId = Auth::id();

        // Ambil semua ID produk milik seller
        $productIds = Product::where('seller_id', $sellerId)->pluck('id');

        // Ambil semua komentar yang masuk ke produk tersebut
        $comments = ProductComment::whereIn('product_id', $productIds)
            ->latest()
            ->get();

        return view('seller.comment', compact('comments'));
    }
}
