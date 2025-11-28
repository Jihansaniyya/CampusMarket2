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
        ];

        // Create products
        foreach ($productsData as $data) {
            Product::firstOrCreate(['slug' => $data['slug']], $data);
        }

        // Create sample comments
        $products = Product::all();
        $commentTexts = [
            'Produk sangat bagus dan sesuai dengan deskripsi. Pengiriman cepat!',
            'Kualitas terbaik yang pernah saya beli. Sangat puas!',
            'Bagus banget, tapi sedikit lebih mahal dari tempat lain.',
            'Ini adalah pembelian terbaik saya tahun ini. Recommended!',
            'Barangnya original dan packaging rapi. Top seller!',
            'Sesuai harapan, tapi proses pengiriman lumayan lama.',
            'Wow, product ini benar-benar mengubah hidup saya!',
            'Kualitas premium dengan harga terjangkau. Mantap!',
        ];

        foreach ($products as $product) {
            // Add 3-5 comments per product
            $commentCount = rand(3, 5);
            for ($i = 0; $i < $commentCount; $i++) {
                ProductComment::firstOrCreate(
                    [
                        'product_id' => $product->id,
                        'visitor_email' => 'visitor' . $i . '@example.com',
                    ],
                    [
                        'visitor_name' => 'Pembeli ' . fake()->firstName(),
                        'visitor_phone' => '08' . rand(10000000, 99999999),
                        'rating' => rand(4, 5),
                        'comment' => $commentTexts[array_rand($commentTexts)],
                        'is_approved' => true,
                        'created_at' => now()->subDays(rand(1, 30)),
                    ]
                );
            }
        }
    }
}

