<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function index()
    {
        $sellerId = Auth::id();

        $products = Product::where('seller_id', $sellerId)->pluck('id');

        $reviews = ProductReview::whereIn('product_id', $products)
            ->latest()
            ->get();

        return view('seller.rating', compact('reviews'));
    }
}
