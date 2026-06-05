<?php

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('filters products by category', function () {

    $categoryA = Category::create([
        'name' => 'Category A',
        'slug' => 'category-a'
    ]);

    $categoryB = Category::create([
        'name' => 'Category B',
        'slug' => 'category-b'
    ]);

    $seller = User::create([
        'name' => 'Seller Test',
        'email' => 'seller@example.com',
        'password' => Hash::make('password123'),
        'role' => 'seller'
    ]);

    Product::create([
        'name' => 'Product A',
        'slug' => 'product-a',
        'price' => 100000,
        'category_id' => $categoryA->id,
        'seller_id' => $seller->id
    ]);

    Product::create([
        'name' => 'Product B',
        'slug' => 'product-b',
        'price' => 200000,
        'category_id' => $categoryB->id,
        'seller_id' => $seller->id
    ]);

    $result = Product::byCategory($categoryA->id)->get();

    expect($result)
        ->toHaveCount(1);
});