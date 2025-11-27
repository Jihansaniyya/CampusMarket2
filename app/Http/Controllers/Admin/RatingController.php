<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductComment;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * Display list of product ratings/comments for admin moderation.
     */
    public function index()
    {
        $comments = ProductComment::with(['product', 'product.seller'])
            ->latest()
            ->paginate(15);

        return view('admin.ratings.index', compact('comments'));
    }
}
