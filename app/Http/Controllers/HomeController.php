<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // ================================
        // REDIRECT USER JIKA SUDAH LOGIN (kecuali jika ada filter kategori)
        // ================================
        if (auth()->check() && !$request->has('category')) {
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
        // HOMEPAGE UNTUK SEMUA (LANDING PAGE)
        // ================================

        // Ambil kategori dari database dengan icon SVG
        $iconMap = [
            'Electronics' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>',
            'Fashion' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 2C10.5 2 9.5 3 9.5 4.5c0 .5.1.9.3 1.3L4 9l2 2 4-2v9h4v-9l4 2 2-2-5.8-3.2c.2-.4.3-.8.3-1.3C14.5 3 13.5 2 12 2z"/></svg>',
            'Groceries' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>',
            'Home & Living' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>',
            'Health & Beauty' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>',
            'Sports' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
            'Automotive' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h8m-8 4h8m-6 4h4M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>',
            'Books' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>',
            'Toys' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"/></svg>',
            'Gaming' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>',
        ];

        $categories = Category::all()->map(function($cat) use ($iconMap) {
            return [
                'id' => $cat->id,
                'name' => $cat->name,
                'slug' => $cat->slug,
                'icon' => $iconMap[$cat->name] ?? '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>',
            ];
        });

        // Ambil produk featured dari database
        $featuredQuery = Product::with(['category', 'seller'])
            ->where('is_active', true)
            ->orderBy('rating', 'desc')
            ->take(6);
        
        // Filter berdasarkan kategori jika ada
        $selectedCategory = $request->get('category');
        if ($selectedCategory) {
            $featuredQuery->where('category_id', $selectedCategory);
        }

        $featuredProducts = $featuredQuery->get()->map(function($product) {
            $imageUrl = 'https://placehold.co/400x400/EEF2FF/4F46E5?text=' . urlencode(substr($product->name, 0, 20));
            if ($product->thumbnail) {
                $imageUrl = str_starts_with($product->thumbnail, 'http') 
                    ? $product->thumbnail 
                    : asset('storage/' . $product->thumbnail);
            }
            
            // Calculate actual rating from reviews
            $actualRating = $product->reviews()->avg('rating') ?? 0;
            $actualReviewsCount = $product->reviews()->count();
            
            return [
                'id' => $product->id,
                'slug' => $product->slug,
                'name' => $product->name,
                'short_description' => \Str::limit($product->description, 50),
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'rating' => round($actualRating, 1),
                'reviews_count' => $actualReviewsCount,
                'image_url' => $imageUrl,
                'category_id' => $product->category_id,
                'badge' => $product->sale_price ? 'Sale' : null,
                'location' => $product->seller->kota_kab ?? ($product->seller->provinsi ?? null),
            ];
        });

        // Ambil semua produk dengan pagination dan filter kategori
        $productsQuery = Product::with(['category', 'seller'])
            ->where('is_active', true)
            ->latest();
        
        if ($selectedCategory) {
            $productsQuery->where('category_id', $selectedCategory);
        }

        $productsDb = $productsQuery->paginate(8);
        
        // Transform untuk compatibility dengan view (menggunakan array, bukan object)
        $products = $productsDb;
        $products->getCollection()->transform(function($product) {
            $imageUrl = 'https://placehold.co/400x400/EEF2FF/4F46E5?text=' . urlencode(substr($product->name, 0, 20));
            if ($product->thumbnail) {
                $imageUrl = str_starts_with($product->thumbnail, 'http') 
                    ? $product->thumbnail 
                    : asset('storage/' . $product->thumbnail);
            }
            
            // Calculate actual rating from reviews
            $actualRating = $product->reviews()->avg('rating') ?? 0;
            $actualReviewsCount = $product->reviews()->count();
            
            return [
                'id' => $product->id,
                'slug' => $product->slug,
                'name' => $product->name,
                'short_description' => \Str::limit($product->description, 50),
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'rating' => round($actualRating, 1),
                'reviews_count' => $actualReviewsCount,
                'image_url' => $imageUrl,
                'category_id' => $product->category_id,
                'badge' => $product->sale_price ? 'Sale' : null,
                'location' => $product->seller->kota_kab ?? ($product->seller->provinsi ?? null),
            ];
        });

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

        // Get provinces and cities from sellers for search filter
        $provinces = User::where('role', 'seller')
            ->whereNotNull('provinsi')
            ->distinct()
            ->pluck('provinsi')
            ->toArray();

        $cities = User::where('role', 'seller')
            ->whereNotNull('kota_kab')
            ->distinct()
            ->pluck('kota_kab')
            ->toArray();

        return view('home', compact('categories', 'featuredProducts', 'products', 'banners', 'provinces', 'cities'));
    }
}
