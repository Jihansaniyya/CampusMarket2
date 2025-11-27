<?php

namespace App\Http\Controllers;

use App\Models\ProductComment;
use App\Models\Product;
use App\Mail\CommentThankYouMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ProductCommentController extends Controller
{
    /**
     * Store a new product comment/rating from a visitor.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'visitor_name' => 'required|string|max:255',
            'visitor_phone' => 'required|string|max:20',
            'visitor_email' => 'required|email',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Create the comment
        $comment = ProductComment::create($validated);

        // Send thank-you email
        Mail::to($validated['visitor_email'])->send(new CommentThankYouMail($comment));

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih atas komentar Anda! Email konfirmasi telah dikirim.',
        ]);
    }

    /**
     * Get approved comments for a product (for display).
     */
    public function getProductComments($productId)
    {
        $comments = ProductComment::where('product_id', $productId)
            ->where('is_approved', true)
            ->latest()
            ->get();

        return response()->json($comments);
    }
}
