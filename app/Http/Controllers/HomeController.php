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

        // Ambil kategori dari database dengan icon mapping
        $iconMap = [
            'Electronics' => '💻',
            'Fashion' => '👗',
            'Groceries' => '🛒',
            'Home & Living' => '🏠',
            'Health & Beauty' => '💄',
            'Sports' => '🏀',
            'Automotive' => '🚗',
            'Books' => '📚',
            'Toys' => '🧸',
            'Gaming' => '🎮',
        ];

        $categories = Category::all()->map(function($cat) use ($iconMap) {
            return [
                'id' => $cat->id,
                'name' => $cat->name,
                'slug' => $cat->slug,
                'icon' => $iconMap[$cat->name] ?? '📦',
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
