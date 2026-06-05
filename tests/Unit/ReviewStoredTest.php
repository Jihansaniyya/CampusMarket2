<?php

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('stores review successfully', function () {

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

    $this->post('/product/review', [
        'product_id' => $product->id,
        'visitor_name' => 'Algi',
        'province' => 'Jawa Tengah',
        'rating' => 5
    ]);

    $this->assertDatabaseHas('product_reviews', [
        'visitor_name' => 'Algi',
        'rating' => 5
    ]);
});