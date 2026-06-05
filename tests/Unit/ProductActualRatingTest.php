<?php

use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('calculates average rating correctly', function () {

    $category = Category::create([
        'name' => 'Electronic',
        'slug' => 'electronic'
    ]);

    $seller = User::create([
        'name' => 'Seller Test',
        'email' => 'seller@example.com',
        'password' => Hash::make('password123'),
        'role' => 'seller'
    ]);

    $product = Product::create([
        'name' => 'Laptop Asus',
        'slug' => 'laptop-asus',
        'price' => 5000000,
        'category_id' => $category->id,
        'seller_id' => $seller->id
    ]);

    ProductReview::create([
        'product_id' => $product->id,
        'visitor_name' => 'Algi',
        'rating' => 4
    ]);

    ProductReview::create([
        'product_id' => $product->id,
        'visitor_name' => 'Farhan',
        'rating' => 5
    ]);

    expect($product->fresh()->actual_rating)
        ->toBe(4.5);
});