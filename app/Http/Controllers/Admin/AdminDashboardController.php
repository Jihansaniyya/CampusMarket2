<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;

class AdminDashboardController extends Controller
{
    /**
     * Daftar 38 Provinsi di Indonesia.
     */
    private function getIndonesianProvinces(): array
    {
        return [
            'Aceh',
            'Sumatera Utara',
            'Sumatera Barat',
            'Riau',
            'Jambi',
            'Sumatera Selatan',
            'Bengkulu',
            'Lampung',
            'Kepulauan Bangka Belitung',
            'Kepulauan Riau',
            'DKI Jakarta',
            'Jawa Barat',
            'Jawa Tengah',
            'DI Yogyakarta',
            'Jawa Timur',
            'Banten',
            'Bali',
            'Nusa Tenggara Barat',
            'Nusa Tenggara Timur',
            'Kalimantan Barat',
            'Kalimantan Tengah',
            'Kalimantan Selatan',
            'Kalimantan Timur',
            'Kalimantan Utara',
            'Sulawesi Utara',
            'Sulawesi Tengah',
            'Sulawesi Selatan',
            'Sulawesi Tenggara',
            'Gorontalo',
            'Sulawesi Barat',
            'Maluku',
            'Maluku Utara',
            'Papua',
            'Papua Barat',
            'Papua Barat Daya',
            'Papua Tengah',
            'Papua Pegunungan',
            'Papua Selatan',
        ];
    }

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

        // Ambil data seller per provinsi dari database (langsung dari data yang ada)
        $sellerProvinceStats = User::query()
            ->selectRaw('provinsi as label, COUNT(*) as value')
            ->where('role', 'seller')
            ->whereNotNull('provinsi')
            ->where('provinsi', '!=', '')
            ->groupBy('provinsi')
            ->orderByDesc('value')
            ->get()
            ->map(fn ($row) => [
                'label' => ucwords(strtolower($row->label)), // Normalize ke Title Case
                'value' => (int) $row->value
            ]);

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

        // Aktivitas Terbaru - Gabungkan berbagai aktivitas
        $recentActivities = collect();

        // 1. Seller baru mendaftar (pending)
        $newSellers = User::where('role', 'seller')
            ->latest()
            ->take(10)
            ->get()
            ->map(fn ($user) => [
                'type' => 'seller_register',
                'icon' => 'fa-user-plus',
                'color' => 'blue',
                'message' => "<strong>{$user->store_name}</strong> mendaftar sebagai penjual",
                'time' => $user->created_at,
            ]);
        $recentActivities = $recentActivities->merge($newSellers);

        // 2. Seller di-approve
        $approvedSellers = User::where('role', 'seller')
            ->where('approval_status', 'approved')
            ->whereNotNull('approved_at')
            ->latest('approved_at')
            ->take(10)
            ->get()
            ->map(fn ($user) => [
                'type' => 'seller_approved',
                'icon' => 'fa-check-circle',
                'color' => 'green',
                'message' => "<strong>" . ($user->store_name ?? $user->name) . "</strong> telah disetujui",
                'time' => $user->approved_at,
            ]);
        $recentActivities = $recentActivities->merge($approvedSellers);

        // 3. Produk baru ditambahkan
        $newProducts = Product::with('seller')
            ->latest()
            ->take(10)
            ->get()
            ->map(fn ($product) => [
                'type' => 'product_added',
                'icon' => 'fa-box',
                'color' => 'purple',
                'message' => "Produk <strong>{$product->name}</strong> ditambahkan oleh " . ($product->seller->store_name ?? 'Seller'),
                'time' => $product->created_at,
            ]);
        $recentActivities = $recentActivities->merge($newProducts);

        // 4. Review baru (menggunakan visitor_name karena review dari pengunjung)
        $newReviews = ProductReview::with('product')
            ->whereHas('product')
            ->latest()
            ->take(10)
            ->get()
            ->filter(fn ($review) => $review->product)
            ->map(fn ($review) => [
                'type' => 'review_added',
                'icon' => 'fa-star',
                'color' => 'amber',
                'message' => "<strong>" . ($review->visitor_name ?? 'Pengunjung') . "</strong> memberi rating {$review->rating}⭐ untuk <strong>" . ($review->product->name ?? 'Produk') . "</strong>",
                'time' => $review->created_at,
            ]);
        $recentActivities = $recentActivities->merge($newReviews);

        // Sort by time descending dan ambil 10 terbaru
        $recentActivities = $recentActivities
            ->sortByDesc('time')
            ->take(10)
            ->values();


        return view('admin.dashboard', compact(
            'pendingSellersCount',
            'approvedSellersCount',
            'rejectedSellersCount',
            'totalUsers',
            'productCategoryStats',
            'sellerProvinceStats',
            'sellerActivityStats',
            'visitorEngagementStats',
            'recentActivities'
        ));
    }
}
