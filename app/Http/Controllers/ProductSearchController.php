<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductSearchController extends Controller
{
    /**
     * Display search results for products.
     */
    public function search(Request $request)
    {
        $query = Product::query()->where('is_active', true);

        // Get search parameters
        $storeName = $request->query('store_name');
        $categoryId = $request->query('category_id');
        $productName = $request->query('product_name');
        $province = $request->query('province');
        $city = $request->query('city');

        // Apply filters
        $query->byStoreName($storeName)
              ->byCategory($categoryId)
              ->byProductName($productName)
              ->byProvince($province)
              ->byCity($city);

        // Get all categories for filter options
        $categories = Category::all();

        // Get unique provinces and cities from sellers for filter options
        $provinces = \App\Models\User::where('role', 'seller')
            ->whereNotNull('provinsi')
            ->distinct()
            ->pluck('provinsi');

        $cities = \App\Models\User::where('role', 'seller')
            ->whereNotNull('kota_kab')
            ->distinct()
            ->pluck('kota_kab');

        // Paginate results
        $products = $query->with(['category', 'seller'])->paginate(12);

        return view('search', compact('products', 'categories', 'provinces', 'cities', 'storeName', 'categoryId', 'productName', 'province', 'city'));
    }
}
