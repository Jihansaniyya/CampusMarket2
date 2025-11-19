<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HomepageSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Electronics'],
            ['name' => 'Fashion'],
            ['name' => 'Groceries'],
            ['name' => 'Home & Living'],
            ['name' => 'Health & Beauty'],
            ['name' => 'Sports'],
            ['name' => 'Automotive'],
            ['name' => 'Books'],
            ['name' => 'Toys'],
            ['name' => 'Gaming'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->updateOrInsert(
                ['slug' => Str::slug($category['name'])],
                ['name' => $category['name'], 'created_at' => now(), 'updated_at' => now()]
            );
        }

        $products = [
            [
                'name' => 'Wireless Earbuds Premium',
                'slug' => 'wireless-earbuds-premium',
                'description' => 'Noise cancelling earbuds dengan 24 jam baterai.',
                'price' => 1200000,
                'sale_price' => 990000,
                'category_id' => 1,
                'image_url' => 'https://via.placeholder.com/400x400?text=Earbuds',
            ],
            [
                'name' => 'Smartwatch Lite',
                'slug' => 'smartwatch-lite',
                'description' => 'Tracking kesehatan & notifikasi.',
                'price' => 1750000,
                'sale_price' => null,
                'category_id' => 1,
                'image_url' => 'https://via.placeholder.com/400x400?text=Smartwatch',
            ],
            [
                'name' => 'Organic Face Serum',
                'slug' => 'organic-face-serum',
                'description' => 'Serum Vitamin C pencerah kulit.',
                'price' => 320000,
                'sale_price' => 280000,
                'category_id' => 5,
                'image_url' => 'https://via.placeholder.com/400x400?text=Serum',
            ],
            [
                'name' => 'Minimalist Backpack',
                'slug' => 'minimalist-backpack',
                'description' => 'Tas anti air dengan kompartemen laptop.',
                'price' => 450000,
                'sale_price' => 399000,
                'category_id' => 2,
                'image_url' => 'https://via.placeholder.com/400x400?text=Backpack',
            ],
            [
                'name' => 'Adjustable Standing Desk',
                'slug' => 'adjustable-standing-desk',
                'description' => 'Meja kerja elektrik tinggi-rendah.',
                'price' => 4200000,
                'sale_price' => null,
                'category_id' => 4,
                'image_url' => 'https://via.placeholder.com/400x400?text=Desk',
            ],
            [
                'name' => 'RGB Gaming Mouse',
                'slug' => 'rgb-gaming-mouse',
                'description' => 'Gaming mouse 16000 DPI.',
                'price' => 520000,
                'sale_price' => 470000,
                'category_id' => 10,
                'image_url' => 'https://via.placeholder.com/400x400?text=Mouse',
            ],
        ];

        foreach ($products as $product) {
            DB::table('products')->updateOrInsert(
                ['slug' => $product['slug']],
                array_merge($product, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}