<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $pendingSellersCount = User::where('role', 'seller')
            ->where('approval_status', 'pending')
            ->count();
            
        $approvedSellersCount = User::where('role', 'seller')
            ->where('approval_status', 'approved')
            ->count();
            
        $rejectedSellersCount = User::where('role', 'seller')
            ->where('approval_status', 'rejected')
            ->count();
            
        $totalUsers = User::count();
        
        $productCategoryStats = Product::selectRaw('categories.name as label, COUNT(products.id) as value')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->groupBy('categories.name')
            ->orderByDesc('value')
            ->get()
            ->map(fn ($row) => ['label' => $row->label, 'value' => (int) $row->value]);

        $sellerProvinceStats = User::query()
            ->selectRaw('provinsi as label, COUNT(*) as value')
            ->where('role', 'seller')
            ->whereNotNull('provinsi')
            ->groupBy('provinsi')
            ->orderByDesc('value')
            ->get()
            ->map(fn ($row) => ['label' => $row->label, 'value' => (int) $row->value]);

        $sellerActivityStats = [
            'active' => $approvedSellersCount,
            'inactive' => $pendingSellersCount + $rejectedSellersCount,
        ];

        $totalReviews = ProductReview::count();

        $ratingBreakdown = ProductReview::selectRaw('rating as label, COUNT(*) as value')
            ->groupBy('rating')
            ->orderByDesc('rating')
            ->get()
            ->map(fn ($row) => ['label' => (string) $row->label, 'value' => (int) $row->value]);

        $monthlyEngagement = ProductReview::orderBy('created_at')
            ->get()
            ->groupBy(fn ($review) => $review->created_at->format('M Y'))
            ->map(fn ($items, $label) => ['label' => $label, 'value' => $items->count()])
            ->values();

        $visitorEngagementStats = [
            'total_reviews' => $totalReviews,
            'rating_breakdown' => $ratingBreakdown,
            'monthly' => $monthlyEngagement,
        ];


        return view('admin.dashboard', compact(
            'pendingSellersCount',
            'approvedSellersCount',
            'rejectedSellersCount',
            'totalUsers',
            'productCategoryStats',
            'sellerProvinceStats',
            'sellerActivityStats',
            'visitorEngagementStats'
        ));
    }
}
