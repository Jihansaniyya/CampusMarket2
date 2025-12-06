<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductComment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories
        $categories = [
            ['name' => 'Electronics', 'slug' => 'electronics', 'icon' => '💻'],
            ['name' => 'Fashion', 'slug' => 'fashion', 'icon' => '👗'],
            ['name' => 'Groceries', 'slug' => 'groceries', 'icon' => '🛒'],
            ['name' => 'Home & Living', 'slug' => 'home-living', 'icon' => '🏠'],
            ['name' => 'Health & Beauty', 'slug' => 'health-beauty', 'icon' => '💄'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        // Get or create a seller
        $seller = User::where('role', 'seller')->first();
        if (!$seller) {
            $seller = User::create([
                'name' => 'Toko Elektronik Jaya',
                'email' => 'seller@example.com',
                'password' => bcrypt('password'),
                'role' => 'seller',
                'phone' => '081234567890',
                'address' => 'Jl. Merdeka No. 123',
                'store_name' => 'Toko Elektronik Jaya',
                'store_description' => 'Toko elektronik terpercaya dengan produk berkualitas',
                'pic_name' => 'Budi Santoso',
                'pic_phone' => '081234567890',
                'pic_address' => 'Jl. Merdeka No. 123',
                'kota_kab' => 'Jakarta',
                'provinsi' => 'DKI Jakarta',
                'approval_status' => 'approved',
                'email_verified_at' => now(),
            ]);
        }

        // Sample products
        $productsData = [
            [
                'name' => 'Wireless Earbuds Premium',
                'slug' => 'wireless-earbuds-premium',
                'description' => 'Earbuds nirkabel dengan noise cancelling, battery 24 jam, dan suara kristal jernih. Cocok untuk musik, panggilan, dan gaming.',
                'category_id' => 1,
                'seller_id' => $seller->id,
                'price' => 1200000,
                'sale_price' => 990000,
                'stock' => 50,
                'rating' => 4.8,
                'rating_count' => 125,
                'is_active' => true,
            ],
            [
                'name' => 'Smartwatch Lite',
                'slug' => 'smartwatch-lite',
                'description' => 'Jam tangan pintar dengan monitor detak jantung, pelacakan tidur, dan notifikasi real-time. Baterai tahan 7 hari.',
                'category_id' => 1,
                'seller_id' => $seller->id,
                'price' => 1750000,
                'sale_price' => null,
                'stock' => 35,
                'rating' => 4.5,
                'rating_count' => 89,
                'is_active' => true,
            ],
            [
                'name' => 'Organic Face Serum',
                'slug' => 'organic-face-serum',
                'description' => 'Serum wajah organik dengan vitamin C, collagen, dan ekstrak tumbuhan alami. Mencerahkan kulit dan mengurangi kerutan.',
                'category_id' => 5,
                'seller_id' => $seller->id,
                'price' => 320000,
                'sale_price' => 280000,
                'stock' => 100,
                'rating' => 4.9,
                'rating_count' => 256,
                'is_active' => true,
            ],
            [
                'name' => 'Minimalist Backpack',
                'slug' => 'minimalist-backpack',
                'description' => 'Tas punggung minimalis dengan desain modern, tahan air, dan punya kompartemen laptop. Material berkualitas tinggi.',
                'category_id' => 2,
                'seller_id' => $seller->id,
                'price' => 450000,
                'sale_price' => 399000,
                'stock' => 75,
                'rating' => 4.7,
                'rating_count' => 98,
                'is_active' => true,
            ],
            [
                'name' => 'Coffee Maker Otomatis',
                'slug' => 'coffee-maker-otomatis',
                'description' => 'Mesin kopi otomatis dengan timer, kapasitas 1.5L, dan pemanas stabil. Buat kopi premium di rumah dengan mudah.',
                'category_id' => 4,
                'seller_id' => $seller->id,
                'price' => 850000,
                'sale_price' => 750000,
                'stock' => 30,
                'rating' => 4.6,
                'rating_count' => 145,
                'is_active' => true,
            ],
            [
                'name' => 'Organic Green Tea Set',
                'slug' => 'organic-green-tea-set',
                'description' => 'Set teh hijau organik premium dari pegunungan dengan 30 sachet teh pilihan. Segar, sehat, dan tahan lama.',
                'category_id' => 3,
                'seller_id' => $seller->id,
                'price' => 180000,
                'sale_price' => 150000,
                'stock' => 200,
                'rating' => 4.4,
                'rating_count' => 67,
                'is_active' => true,
            ],
            [
                'name' => 'Laptop Stand Aluminum',
                'slug' => 'laptop-stand-aluminum',
                'description' => 'Stand laptop ergonomis dari aluminium dengan sudut adjustable. Mengurangi pegal leher saat kerja.',
                'category_id' => 1,
                'seller_id' => $seller->id,
                'price' => 250000,
                'sale_price' => 199000,
                'stock' => 60,
                'rating' => 4.6,
                'rating_count' => 142,
                'is_active' => true,
            ],
            [
                'name' => 'Kaos Polos Premium Cotton',
                'slug' => 'kaos-polos-premium-cotton',
                'description' => 'Kaos polos cotton combed 30s yang nyaman dan adem. Tersedia berbagai warna, cocok untuk daily wear.',
                'category_id' => 2,
                'seller_id' => $seller->id,
                'price' => 85000,
                'sale_price' => 65000,
                'stock' => 150,
                'rating' => 4.8,
                'rating_count' => 312,
                'is_active' => true,
            ],
            [
                'name' => 'Madu Murni 500ml',
                'slug' => 'madu-murni-500ml',
                'description' => 'Madu murni 100% asli dari hutan Indonesia. Tanpa campuran gula, kaya manfaat untuk kesehatan.',
                'category_id' => 3,
                'seller_id' => $seller->id,
                'price' => 120000,
                'sale_price' => 99000,
                'stock' => 80,
                'rating' => 4.9,
                'rating_count' => 198,
                'is_active' => true,
            ],
            [
                'name' => 'LED Desk Lamp',
                'slug' => 'led-desk-lamp',
                'description' => 'Lampu meja LED dengan 3 mode pencahayaan dan brightness control. Hemat energi dan tahan lama.',
                'category_id' => 4,
                'seller_id' => $seller->id,
                'price' => 175000,
                'sale_price' => null,
                'stock' => 45,
                'rating' => 4.5,
                'rating_count' => 76,
                'is_active' => true,
            ],
            [
                'name' => 'Sunscreen SPF 50+',
                'slug' => 'sunscreen-spf-50',
                'description' => 'Sunscreen broad spectrum SPF 50+ PA++++. Melindungi dari UVA & UVB, ringan dan tidak lengket.',
                'category_id' => 5,
                'seller_id' => $seller->id,
                'price' => 165000,
                'sale_price' => 145000,
                'stock' => 110,
                'rating' => 4.7,
                'rating_count' => 289,
                'is_active' => true,
            ],
            [
                'name' => 'Wireless Mouse Ergonomic',
                'slug' => 'wireless-mouse-ergonomic',
                'description' => 'Mouse wireless ergonomis dengan sensor presisi tinggi. Nyaman digunakan berjam-jam tanpa pegal.',
                'category_id' => 1,
                'seller_id' => $seller->id,
                'price' => 195000,
                'sale_price' => 165000,
                'stock' => 120,
                'rating' => 4.6,
                'rating_count' => 167,
                'is_active' => true,
            ],
            [
                'name' => 'Jaket Hoodie Unisex',
                'slug' => 'jaket-hoodie-unisex',
                'description' => 'Jaket hoodie fleece premium yang hangat dan nyaman. Cocok untuk pria dan wanita, berbagai size tersedia.',
                'category_id' => 2,
                'seller_id' => $seller->id,
                'price' => 320000,
                'sale_price' => 280000,
                'stock' => 55,
                'rating' => 4.8,
                'rating_count' => 203,
                'is_active' => true,
            ],
            [
                'name' => 'Almond Roasted 250gr',
                'slug' => 'almond-roasted-250gr',
                'description' => 'Kacang almond panggang premium tanpa garam. Cemilan sehat tinggi protein dan omega-3.',
                'category_id' => 3,
                'seller_id' => $seller->id,
                'price' => 95000,
                'sale_price' => 85000,
                'stock' => 200,
                'rating' => 4.7,
                'rating_count' => 134,
                'is_active' => true,
            ],
            [
                'name' => 'Aromatherapy Diffuser',
                'slug' => 'aromatherapy-diffuser',
                'description' => 'Diffuser aromaterapi dengan LED 7 warna dan auto shut-off. Ciptakan suasana rileks di rumah Anda.',
                'category_id' => 4,
                'seller_id' => $seller->id,
                'price' => 245000,
                'sale_price' => 199000,
                'stock' => 40,
                'rating' => 4.6,
                'rating_count' => 91,
                'is_active' => true,
            ],
            [
                'name' => 'Hair Serum Vitamin E',
                'slug' => 'hair-serum-vitamin-e',
                'description' => 'Serum rambut dengan vitamin E dan argan oil. Membuat rambut lebih lembut, berkilau, dan tidak kusut.',
                'category_id' => 5,
                'seller_id' => $seller->id,
                'price' => 135000,
                'sale_price' => 115000,
                'stock' => 95,
                'rating' => 4.8,
                'rating_count' => 178,
                'is_active' => true,
            ],
        ];

        // Sample review comments
        $reviewComments = [
            'Produk sangat bagus dan sesuai dengan deskripsi. Pengiriman cepat!',
            'Kualitas terbaik yang pernah saya beli. Sangat puas!',
            'Bagus banget, worth it!',
            'Ini adalah pembelian terbaik saya tahun ini. Recommended!',
            'Barangnya original dan packaging rapi. Top seller!',
            'Sesuai harapan, pengiriman cepat.',
            'Mantap! Sangat recommended.',
            'Kualitas premium dengan harga terjangkau.',
            'Best product! Highly recommended.',
            'Sangat memuaskan, terima kasih seller!',
            null,
        ];

        foreach ($productsData as $data) {
            $targetRating = $data['rating'];
            $targetReviewCount = $data['rating_count'];
            unset($data['rating'], $data['rating_count']);
            
            $product = Product::firstOrCreate(
                ['slug' => $data['slug']], 
                array_merge($data, ['rating' => 0, 'rating_count' => 0])
            );

            if ($product->reviews()->count() > 0) {
                continue;
            }

            // Indonesian provinces
            $provinces = [
                'Aceh', 'Sumatera Utara', 'Sumatera Barat', 'Riau', 'Kepulauan Riau',
                'Jambi', 'Sumatera Selatan', 'Kepulauan Bangka Belitung', 'Bengkulu', 'Lampung',
                'DKI Jakarta', 'Jawa Barat', 'Banten', 'Jawa Tengah', 'DI Yogyakarta', 'Jawa Timur',
                'Bali', 'Nusa Tenggara Barat', 'Nusa Tenggara Timur',
                'Kalimantan Barat', 'Kalimantan Tengah', 'Kalimantan Selatan', 'Kalimantan Timur', 'Kalimantan Utara',
                'Sulawesi Utara', 'Gorontalo', 'Sulawesi Tengah', 'Sulawesi Barat', 'Sulawesi Selatan', 'Sulawesi Tenggara',
                'Maluku', 'Maluku Utara', 'Papua', 'Papua Barat', 'Papua Tengah', 'Papua Pegunungan', 'Papua Selatan', 'Papua Barat Daya',
            ];

            // Generate reviews with rating distribution (70% target, 20% -1, 10% +1)
            for ($i = 0; $i < $targetReviewCount; $i++) {
                $rand = rand(1, 100);
                if ($rand <= 70) {
                    $rating = round($targetRating);
                } elseif ($rand <= 90) {
                    $rating = max(1, round($targetRating) - 1);
                } else {
                    $rating = min(5, round($targetRating) + 1);
                }

                \App\Models\ProductReview::create([
                    'product_id' => $product->id,
                    'visitor_name' => fake()->name(),
                    'visitor_email' => fake()->unique()->safeEmail(),
                    'province' => $provinces[array_rand($provinces)],
                    'rating' => $rating,
                    'comment' => $reviewComments[array_rand($reviewComments)],
                    'created_at' => now()->subDays(rand(1, 90)),
                ]);
            }

            // Calculate and update product rating
            $actualAvgRating = \App\Models\ProductReview::where('product_id', $product->id)->avg('rating');
            $actualCount = \App\Models\ProductReview::where('product_id', $product->id)->count();
            
            $product->update([
                'rating' => $actualAvgRating ? round($actualAvgRating, 1) : 0,
                'rating_count' => $actualCount,
            ]);

            echo "✓ Created {$product->name} with {$actualCount} reviews (rating: {$product->rating})\n";
        }
    }
}

