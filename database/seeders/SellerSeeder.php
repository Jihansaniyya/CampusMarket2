<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class SellerSeeder extends Seeder
{
    public function run()
    {
        // Create 5 sellers with different locations
        $sellers = [
            [
                'name' => 'Seller Demo',
                'email' => 'sellerdemo@gmail.com',
                'store_name' => 'Toko Demo',
                'kota_kab' => 'Jakarta',
                'provinsi' => 'DKI Jakarta',
            ],
            [
                'name' => 'Toko Elektronik Surabaya',
                'email' => 'seller1@campusmarket.com',
                'store_name' => 'ElectroHub Surabaya',
                'kota_kab' => 'Surabaya',
                'provinsi' => 'Jawa Timur',
            ],
            [
                'name' => 'Fashion Bandung Store',
                'email' => 'seller2@campusmarket.com',
                'store_name' => 'Fashion Bandung',
                'kota_kab' => 'Bandung',
                'provinsi' => 'Jawa Barat',
            ],
            [
                'name' => 'Grocer Medan',
                'email' => 'seller3@campusmarket.com',
                'store_name' => 'Pasar Segar Medan',
                'kota_kab' => 'Medan',
                'provinsi' => 'Sumatera Utara',
            ],
            [
                'name' => 'Beauty Palace Yogya',
                'email' => 'seller4@campusmarket.com',
                'store_name' => 'Kecantikan Istimewa',
                'kota_kab' => 'Yogyakarta',
                'provinsi' => 'DI Yogyakarta',
            ],
        ];

        foreach ($sellers as $sellerData) {
            $seller = User::firstOrCreate(
                ['email' => $sellerData['email']],
                [
                    'name' => $sellerData['name'],
                    'password' => Hash::make('seller123'),
                    'role' => 'seller',
                    'phone' => '08' . rand(100000000, 999999999),
                    'address' => 'Jl. ' . $sellerData['store_name'] . ' No. 1',
                    'store_name' => $sellerData['store_name'],
                    'store_description' => 'Toko terpercaya di ' . $sellerData['kota_kab'],
                    'pic_name' => 'Manager ' . $sellerData['store_name'],
                    'pic_phone' => '08' . rand(100000000, 999999999),
                    'pic_email' => $sellerData['email'],
                    'pic_address' => 'Jl. ' . $sellerData['store_name'] . ' No. 1',
                    'rt' => rand(1, 10),
                    'rw' => rand(1, 5),
                    'kelurahan' => 'Kelurahan ' . $sellerData['kota_kab'],
                    'kota_kab' => $sellerData['kota_kab'],
                    'provinsi' => $sellerData['provinsi'],
                    'no_ktp' => rand(1000000000000000, 9999999999999999),
                    'file_ktp' => 'ktp-' . Str::slug($sellerData['email']) . '.jpg',
                    'avatar' => 'avatar-' . Str::slug($sellerData['email']) . '.jpg',
                    'approval_status' => 'approved',
                    'approved_at' => now(),
                    'rejection_reason' => null,
                    'email_verified_at' => now(),
                ]
            );

            // Skip if products already exist for this seller
            if (Product::where('seller_id', $seller->id)->count() > 0) {
                continue;
            }

            // Add 10 products per seller with real images
            $products = $this->getProductsWithImages($sellerData['store_name'], $seller->id);
            
            foreach ($products as $productData) {
                Product::create($productData);
            }

            echo "✓ Created seller: {$seller->store_name} with 10 products\n";
        }
    }

    private function getProductsWithImages($storeName, $sellerId)
    {
        $baseProducts = [
            [
                'name' => 'Wireless Earbuds Premium',
                'category' => 'Electronics',
                'price' => 1200000,
                'sale_price' => 990000,
                'stock' => 50,
                'image' => 'https://picsum.photos/seed/earbuds' . $sellerId . '/400/400',
            ],
            [
                'name' => 'Smartwatch Lite',
                'category' => 'Electronics',
                'price' => 1750000,
                'sale_price' => null,
                'stock' => 35,
                'image' => 'https://picsum.photos/seed/smartwatch' . $sellerId . '/400/400',
            ],
            [
                'name' => 'Organic Face Serum',
                'category' => 'Health & Beauty',
                'price' => 320000,
                'sale_price' => 280000,
                'stock' => 100,
                'image' => 'https://picsum.photos/seed/serum' . $sellerId . '/400/400',
            ],
            [
                'name' => 'Minimalist Backpack',
                'category' => 'Fashion',
                'price' => 450000,
                'sale_price' => 399000,
                'stock' => 75,
                'image' => 'https://picsum.photos/seed/backpack' . $sellerId . '/400/400',
            ],
            [
                'name' => 'Coffee Maker Otomatis',
                'category' => 'Home & Living',
                'price' => 850000,
                'sale_price' => 750000,
                'stock' => 30,
                'image' => 'https://picsum.photos/seed/coffee' . $sellerId . '/400/400',
            ],
            [
                'name' => 'Organic Green Tea Set',
                'category' => 'Groceries',
                'price' => 180000,
                'sale_price' => 150000,
                'stock' => 200,
                'image' => 'https://picsum.photos/seed/tea' . $sellerId . '/400/400',
            ],
            [
                'name' => 'Laptop Stand Aluminum',
                'category' => 'Electronics',
                'price' => 250000,
                'sale_price' => 199000,
                'stock' => 60,
                'image' => 'https://picsum.photos/seed/laptop' . $sellerId . '/400/400',
            ],
            [
                'name' => 'Kaos Polos Premium Cotton',
                'category' => 'Fashion',
                'price' => 150000,
                'sale_price' => 120000,
                'stock' => 150,
                'image' => 'https://picsum.photos/seed/shirt' . $sellerId . '/400/400',
            ],
            [
                'name' => 'Aromatherapy Essential Oil',
                'category' => 'Health & Beauty',
                'price' => 200000,
                'sale_price' => 170000,
                'stock' => 80,
                'image' => 'https://picsum.photos/seed/oil' . $sellerId . '/400/400',
            ],
            [
                'name' => 'Premium Bed Sheets Set',
                'category' => 'Home & Living',
                'price' => 350000,
                'sale_price' => 299000,
                'stock' => 45,
                'image' => 'https://picsum.photos/seed/bedsheets' . $sellerId . '/400/400',
            ],
        ];

        $products = [];
        $categories = Category::all()->keyBy('name');

        foreach ($baseProducts as $index => $base) {
            $categoryId = $categories[$base['category']]->id ?? 1;
            
            $products[] = [
                'seller_id' => $sellerId,
                'category_id' => $categoryId,
                'name' => $base['name'],
                'slug' => Str::slug($base['name']) . '-' . Str::random(6),
                'description' => 'Produk berkualitas tinggi dari ' . $storeName . '. ' . $base['name'] . ' dengan standar internasional dan terjamin keasliannya.',
                'price' => $base['price'],
                'sale_price' => $base['sale_price'],
                'stock' => $base['stock'],
                'thumbnail' => $base['image'],
                'rating' => rand(35, 50) / 10,
                'rating_count' => rand(50, 300),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        return $products;
    }
}
