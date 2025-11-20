<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class HomeController extends Controller
{
    public function index()
    {
        // ================================
        // REDIRECT USER JIKA SUDAH LOGIN
        // ================================
        if (auth()->check()) {
            $user = auth()->user();

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            if ($user->role === 'seller') {
                return $user->approval_status === 'approved'
                    ? redirect()->route('seller.dashboard')
                    : redirect()->route('waiting.approval');
            }

            return redirect()->route('buyer.dashboard');
        }

        // ================================
        // HOMEPAGE UNTUK GUEST (LANDING PAGE)
        // ================================

        $categories = collect([
            ['id' => 1, 'name' => 'Electronics', 'icon' => '💻'],
            ['id' => 2, 'name' => 'Fashion', 'icon' => '👗'],
            ['id' => 3, 'name' => 'Groceries', 'icon' => '🛒'],
            ['id' => 4, 'name' => 'Home & Living', 'icon' => '🏠'],
            ['id' => 5, 'name' => 'Health & Beauty', 'icon' => '💄'],
            ['id' => 6, 'name' => 'Sports', 'icon' => '🏀'],
            ['id' => 7, 'name' => 'Automotive', 'icon' => '🚗'],
            ['id' => 8, 'name' => 'Books', 'icon' => '📚'],
            ['id' => 9, 'name' => 'Toys', 'icon' => '🧸'],
            ['id' => 10, 'name' => 'Gaming', 'icon' => '🎮'],
        ]);

        $featuredProducts = collect([
            [
                'id' => 101,
                'slug' => 'wireless-earbuds-premium',
                'name' => 'Wireless Earbuds Premium',
                'short_description' => 'Noise cancelling, 24h battery.',
                'price' => 1200000,
                'sale_price' => 990000,
                'rating' => 4.8,
                'reviews_count' => 512,
                'image_url' => 'https://picsum.photos/400/400?random=1',
                'category_id' => 1,
                'badge' => 'Sale',
            ],
            [
                'id' => 102,
                'slug' => 'smartwatch-lite',
                'name' => 'Smartwatch Lite',
                'short_description' => 'Track health & notifications.',
                'price' => 1750000,
                'sale_price' => null,
                'rating' => 4.5,
                'reviews_count' => 318,
                'image_url' => 'https://picsum.photos/400/400?random=2',
                'category_id' => 1,
                'badge' => 'New',
            ],
            [
                'id' => 103,
                'slug' => 'organic-face-serum',
                'name' => 'Organic Face Serum',
                'short_description' => 'Brightening formula with Vitamin C.',
                'price' => 320000,
                'sale_price' => 280000,
                'rating' => 4.9,
                'reviews_count' => 221,
                'image_url' => 'https://picsum.photos/400/400?random=3',
                'category_id' => 5,
                'badge' => 'Sale',
            ],
        ]);

        $productsData = [
            [
                'id' => 201,
                'slug' => 'minimalist-backpack',
                'name' => 'Minimalist Backpack',
                'short_description' => 'Water-resistant with laptop sleeve.',
                'price' => 450000,
                'sale_price' => 399000,
                'rating' => 4.7,
                'reviews_count' => 189,
                'image_url' => 'https://picsum.photos/400/400?random=4',
                'category_id' => 2,
                'badge' => 'Sale',
            ],
            // ... (LANJUT sesuai punyamu, tidak aku potong)
        ];

        $perPage = 8;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $productsCollection = collect($productsData);
        $currentItems = $productsCollection
            ->slice(($currentPage - 1) * $perPage, $perPage)
            ->values();

        $products = new LengthAwarePaginator(
            $currentItems,
            $productsCollection->count(),
            $perPage,
            $currentPage,
            ['path' => url('/')]
        );

        $banners = [
            [
                'title' => 'Mega Elektronik Day',
                'subtitle' => 'Hemat hingga 60% + voucher khusus.',
                'image_url' => 'https://picsum.photos/1200/450?random=21',
                'cta_text' => 'Belanja Sekarang',
                'cta_link' => '#featured',
            ],
            [
                'title' => 'Fashion Weekend Deals',
                'subtitle' => 'Mix & match outfit kekinian.',
                'image_url' => 'https://picsum.photos/1200/450?random=22',
                'cta_text' => 'Lihat Koleksi',
                'cta_link' => '#categories',
            ],
            [
                'title' => 'Fresh Market Picks',
                'subtitle' => 'Bahan segar antar sampai rumah.',
                'image_url' => 'https://picsum.photos/1200/450?random=23',
                'cta_text' => 'Pesan Sekarang',
                'cta_link' => '#recommended',
            ],
        ];

        return view('home', compact('categories', 'featuredProducts', 'products', 'banners'));
    }
}
