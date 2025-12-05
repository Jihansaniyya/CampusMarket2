<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    /**
     * Store a new product review
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id'    => 'required|exists:products,id',
            'visitor_name'  => 'required|string|max:255',
            'visitor_email' => 'nullable|email|max:255',
            'province'      => 'required|string|max:255',
            'rating'        => 'required|integer|min:1|max:5',
            'comment'       => 'nullable|string|max:1000',
        ]);

        // Create review
        ProductReview::create([
            'product_id'    => $request->product_id,
            'visitor_name'  => $request->visitor_name,
            'visitor_email' => $request->visitor_email,
            'province'      => $request->province,
            'rating'        => $request->rating,
            'comment'       => $request->comment,
        ]);

        // Update product rating
        $this->updateProductRating($request->product_id);

        return redirect()->back()->with('success', 'Terima kasih! Review Anda telah disimpan.');
    }

    /**
     * Update product average rating
     */
    private function updateProductRating($productId)
    {
        $product = Product::findOrFail($productId);
        
        $avgRating = ProductReview::where('product_id', $productId)->avg('rating');
        $ratingCount = ProductReview::where('product_id', $productId)->count();

        $product->update([
            'rating' => round($avgRating, 1),
            'rating_count' => $ratingCount,
        ]);
    }
}
