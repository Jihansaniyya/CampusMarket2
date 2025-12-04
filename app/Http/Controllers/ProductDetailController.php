<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductDetailController extends Controller
{
    /**
     * Show the product detail page with comments and ratings.
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with([
                'category', 
                'seller', 
                'reviews' => function ($query) {
                    $query->latest();
                },
                'comments' => function ($query) {
                    $query->where('is_approved', true)->latest();
                }
            ])
            ->firstOrFail();

        return view('product-detail', compact('product'));
    }
}
