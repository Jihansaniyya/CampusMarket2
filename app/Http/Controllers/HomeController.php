<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class HomeController extends Controller
{
    public function index()
    {
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
                'image_url' => 'https://via.placeholder.com/400x400?text=Earbuds',
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
                'image_url' => 'https://via.placeholder.com/400x400?text=Smartwatch',
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
                'image_url' => 'https://via.placeholder.com/400x400?text=Serum',
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
                'image_url' => 'https://via.placeholder.com/400x400?text=Backpack',
                'category_id' => 2,
                'badge' => 'Sale',
            ],
            [
                'id' => 202,
                'slug' => 'adjustable-standing-desk',
                'name' => 'Adjustable Standing Desk',
                'short_description' => 'Electric lift, solid wood top.',
                'price' => 4200000,
                'sale_price' => null,
                'rating' => 4.6,
                'reviews_count' => 97,
                'image_url' => 'https://via.placeholder.com/400x400?text=Desk',
                'category_id' => 4,
                'badge' => 'New',
            ],
            [
                'id' => 203,
                'slug' => 'rgb-gaming-mouse',
                'name' => 'RGB Gaming Mouse',
                'short_description' => '16000 DPI, programmable buttons.',
                'price' => 520000,
                'sale_price' => 470000,
                'rating' => 4.4,
                'reviews_count' => 342,
                'image_url' => 'https://via.placeholder.com/400x400?text=Mouse',
                'category_id' => 10,
                'badge' => 'Sale',
            ],
            [
                'id' => 204,
                'slug' => 'chef-knife-set',
                'name' => 'Chef Knife Set (3 pcs)',
                'short_description' => 'Japanese steel, ergonomic handle.',
                'price' => 780000,
                'sale_price' => null,
                'rating' => 4.9,
                'reviews_count' => 141,
                'image_url' => 'https://via.placeholder.com/400x400?text=Knife+Set',
                'category_id' => 4,
                'badge' => 'New',
            ],
            [
                'id' => 205,
                'slug' => 'magsafe-wireless-charger',
                'name' => 'MagSafe Wireless Charger',
                'short_description' => '15W fast charge for iOS/Android.',
                'price' => 350000,
                'sale_price' => 299000,
                'rating' => 4.3,
                'reviews_count' => 210,
                'image_url' => 'https://via.placeholder.com/400x400?text=Charger',
                'category_id' => 1,
                'badge' => 'Sale',
            ],
            [
                'id' => 206,
                'slug' => 'sneakers-airlite',
                'name' => 'Sneakers AirLite',
                'short_description' => 'Lightweight knit, all-day comfort.',
                'price' => 890000,
                'sale_price' => 790000,
                'rating' => 4.5,
                'reviews_count' => 265,
                'image_url' => 'https://via.placeholder.com/400x400?text=Sneakers',
                'category_id' => 2,
                'badge' => 'Sale',
            ],
            [
                'id' => 207,
                'slug' => 'dslr-camera-bundle',
                'name' => 'DSLR Camera Bundle',
                'short_description' => '24MP body + kit lens + bag.',
                'price' => 8200000,
                'sale_price' => null,
                'rating' => 4.8,
                'reviews_count' => 75,
                'image_url' => 'https://via.placeholder.com/400x400?text=Camera',
                'category_id' => 1,
                'badge' => 'New',
            ],
            [
                'id' => 208,
                'slug' => 'kids-building-blocks',
                'name' => 'Kids Building Blocks',
                'short_description' => '120 pieces, BPA-free plastic.',
                'price' => 260000,
                'sale_price' => 220000,
                'rating' => 4.6,
                'reviews_count' => 198,
                'image_url' => 'https://via.placeholder.com/400x400?text=Blocks',
                'category_id' => 9,
                'badge' => 'Sale',
            ],
            [
                'id' => 209,
                'slug' => 'fitness-smart-scale',
                'name' => 'Fitness Smart Scale',
                'short_description' => 'Tracks 13 body metrics via app.',
                'price' => 490000,
                'sale_price' => null,
                'rating' => 4.2,
                'reviews_count' => 116,
                'image_url' => 'https://via.placeholder.com/400x400?text=Scale',
                'category_id' => 6,
                'badge' => 'New',
            ],
            [
                'id' => 210,
                'slug' => 'artisan-coffee-beans',
                'name' => 'Artisan Coffee Beans',
                'short_description' => 'Single origin, medium roast 500g.',
                'price' => 185000,
                'sale_price' => 165000,
                'rating' => 4.9,
                'reviews_count' => 411,
                'image_url' => 'https://via.placeholder.com/400x400?text=Coffee',
                'category_id' => 3,
                'badge' => 'Sale',
            ],
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
                'image_url' => 'https://via.placeholder.com/1200x450?text=Banner+1',
                'cta_text' => 'Belanja Sekarang',
                'cta_link' => '#featured',
            ],
            [
                'title' => 'Fashion Weekend Deals',
                'subtitle' => 'Mix & match outfit kekinian.',
                'image_url' => 'https://via.placeholder.com/1200x450?text=Banner+2',
                'cta_text' => 'Lihat Koleksi',
                'cta_link' => '#categories',
            ],
            [
                'title' => 'Fresh Market Picks',
                'subtitle' => 'Bahan segar antar sampai rumah.',
                'image_url' => 'https://via.placeholder.com/1200x450?text=Banner+3',
                'cta_text' => 'Pesan Sekarang',
                'cta_link' => '#recommended',
            ],
        ];

        return view('home', compact('categories', 'featuredProducts', 'products', 'banners'));
    }
}