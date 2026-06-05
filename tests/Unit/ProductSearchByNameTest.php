<?php

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('searches product by name', function () {

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

    Product::create([
        'name' => 'Laptop Asus',
        'slug' => 'laptop-asus',
        'price' => 5000000,
        'category_id' => $category->id,
        'seller_id' => $seller->id
    ]);

    Product::create([
        'name' => 'Mouse Logitech',
        'slug' => 'mouse-logitech',
        'price' => 150000,
        'category_id' => $category->id,
        'seller_id' => $seller->id
    ]);

    $result = Product::byProductName('Laptop')->get();

    expect($result)
        ->toHaveCount(1);
});