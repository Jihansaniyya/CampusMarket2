<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductReviewSeeder extends Seeder
{
    /**
     * Seed product reviews for all products.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        // List of Indonesian provinces
        $provinces = [
            'DKI Jakarta', 'Jawa Barat', 'Jawa Tengah', 'Jawa Timur', 'Banten',
            'DI Yogyakarta', 'Bali', 'Sumatera Utara', 'Sumatera Barat', 'Sumatera Selatan',
            'Kalimantan Timur', 'Kalimantan Selatan', 'Sulawesi Selatan', 'Sulawesi Utara',
            'Kepulauan Riau', 'Lampung', 'Aceh', 'Riau', 'Bengkulu', 'Jambi',
            'Kalimantan Barat', 'Kalimantan Tengah', 'Kalimantan Utara', 'Sulawesi Tengah',
            'Sulawesi Tenggara', 'Gorontalo', 'Sulawesi Barat', 'Maluku', 'Maluku Utara',
            'Papua', 'Papua Barat', 'Papua Tengah', 'Papua Pegunungan', 'Papua Selatan',
            'Papua Barat Daya', 'Nusa Tenggara Barat', 'Nusa Tenggara Timur', 'Bangka Belitung'
        ];

        // Get all products
        $products = Product::all();
        
        echo "Starting to seed reviews for " . $products->count() . " products...\n";
        
        foreach ($products as $product) {
            // Random number of reviews per product (between 3 to 15)
            $reviewCount = rand(3, 15);
            
            echo "Adding {$reviewCount} reviews for: {$product->name}\n";
            
            for ($i = 0; $i < $reviewCount; $i++) {
                ProductReview::create([
                    'product_id' => $product->id,
                    'visitor_name' => $faker->name(),
                    'visitor_email' => $faker->unique()->safeEmail(),
                    'rating' => $this->getWeightedRating(), // Mostly 4-5 stars
                    'comment' => $this->getRandomReview($faker),
                    'province' => $faker->randomElement($provinces),
                ]);
            }
            
            // Update product rating based on reviews
            $avgRating = ProductReview::where('product_id', $product->id)->avg('rating');
            $ratingCount = ProductReview::where('product_id', $product->id)->count();
            
            $product->update([
                'rating' => round($avgRating, 1),
                'rating_count' => $ratingCount,
            ]);
        }
        
        $totalReviews = ProductReview::count();
        echo "\n✓ Successfully created {$totalReviews} reviews for {$products->count()} products!\n";
    }

    /**
     * Get weighted rating (more likely to be 4-5 stars)
     */
    private function getWeightedRating(): int
    {
        $random = rand(1, 100);
        
        if ($random <= 50) {
            return 5; // 50% chance
        } elseif ($random <= 80) {
            return 4; // 30% chance
        } elseif ($random <= 90) {
            return 3; // 10% chance
        } elseif ($random <= 97) {
            return 2; // 7% chance
        } else {
            return 1; // 3% chance
        }
    }

    /**
     * Get random review text
     */
    private function getRandomReview($faker): string
    {
        $positiveReviews = [
            'Produk sangat bagus! Sesuai dengan deskripsi dan kualitas memuaskan.',
            'Pengiriman cepat, packaging rapi. Produk original dan berkualitas tinggi.',
            'Recommended banget! Harga sebanding dengan kualitas yang didapat.',
            'Seller responsif dan ramah. Produk sesuai ekspektasi, puas banget!',
            'Kualitas produk sangat baik, pelayanan juga memuaskan. Will order again!',
            'Produk berkualitas premium, worth it! Pengiriman juga cepat dan aman.',
            'Sangat puas dengan pembelian ini. Produk original dan packaging bagus.',
            'Excellent product! Kualitas top, harga bersaing. Highly recommended.',
            'Produk sesuai gambar, kualitas oke banget. Seller juga fast response.',
            'Best purchase ever! Produk berkualitas tinggi dengan harga terjangkau.',
        ];

        $neutralReviews = [
            'Produk oke, sesuai harga. Pengiriman standar, tidak terlalu cepat.',
            'Kualitas lumayan bagus, tapi packaging bisa lebih rapi lagi.',
            'Produk sesuai deskripsi. Secara keseluruhan cukup memuaskan.',
            'Tidak jelek, tidak terlalu istimewa juga. Overall oke lah.',
            'Produk standar, sesuai dengan yang diharapkan. Pengiriman agak lama.',
        ];

        $negativeReviews = [
            'Produk kurang sesuai ekspektasi. Kualitas di bawah harga yang dibayar.',
            'Packaging kurang rapi, untung produk tidak rusak. Agak kecewa.',
            'Pengiriman lama banget. Produk sih oke, tapi pelayanan kurang memuaskan.',
            'Produk tidak sesuai gambar. Kualitas kurang bagus untuk harga segini.',
            'Kecewa dengan pembelian ini. Tidak sesuai deskripsi yang dijanjikan.',
        ];

        $rating = $this->getWeightedRating();
        
        if ($rating >= 4) {
            return $faker->randomElement($positiveReviews);
        } elseif ($rating == 3) {
            return $faker->randomElement($neutralReviews);
        } else {
            return $faker->randomElement($negativeReviews);
        }
    }
}
