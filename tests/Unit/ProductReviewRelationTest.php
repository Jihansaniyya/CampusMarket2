<?php

use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('has many reviews relation', function () {

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
        'visitor_name' => 'Visitor A',
        'rating' => 5
    ]);

    ProductReview::create([
        'product_id' => $product->id,
        'visitor_name' => 'Visitor B',
        'rating' => 4
    ]);

    expect($product->reviews)
        ->toHaveCount(2);
});