<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display product list
     */
    public function index(Request $request)
    {
        $query = Product::where('seller_id', auth()->id())->with('category');

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->is_active !== null && $request->is_active !== '') {
            $query->where('is_active', $request->is_active);
        }

        if ($request->sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort === 'price_desc') {
            $query->orderBy('price', 'desc');
        } elseif ($request->sort === 'stock_desc') {
            $query->orderBy('stock', 'desc');
        } else {
            $query->latest();
        }

        $products = $query->paginate(10);
        $categories = Category::all();

        return view('seller.product-list', compact('products', 'categories'));
    }


    /**
     * Show product creation form
     */
    public function create()
    {
        $categories = Category::all();
        return view('seller.product', compact('categories'));
    }


    /**
     * Store new product
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'thumbnail'   => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        // Upload thumbnail if provided
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('products', 'public');
        }

        Product::create([
            'seller_id'     => auth()->id(),
            'category_id'   => $request->category_id,
            'name'          => $request->name,
            'slug'          => Str::slug($request->name) . '-' . Str::random(6),
            'description'   => $request->description,
            'price'         => $request->price,
            'stock'         => $request->stock,
            'thumbnail'     => $thumbnailPath,
            'is_active'     => $request->submit_type == 'publish' ? true : false,
        ]);

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }


    /**
     * Show product edit form
     */
    public function edit($id)
    {
        $product = Product::where('id', $id)
                          ->where('seller_id', auth()->id())
                          ->firstOrFail();
        
        $categories = Category::all();
        return view('seller.product-edit', compact('product', 'categories'));
    }


    /**
     * Update product
     */
    public function update(Request $request, $id)
    {
        $product = Product::where('id', $id)
                          ->where('seller_id', auth()->id())
                          ->firstOrFail();

        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'thumbnail'   => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($product->thumbnail) {
                Storage::disk('public')->delete($product->thumbnail);
            }
            $thumbnailPath = $request->file('thumbnail')->store('products', 'public');
            $product->thumbnail = $thumbnailPath;
        }

        $product->update([
            'name'          => $request->name,
            'category_id'   => $request->category_id,
            'slug'          => Str::slug($request->name) . '-' . Str::random(6),
            'description'   => $request->description,
            'price'         => $request->price,
            'stock'         => $request->stock,
            'is_active'     => $request->submit_type == 'publish' ? true : false,
        ]);

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }


    /**
     * Delete product
     */
    public function destroy($id)
    {
        $product = Product::where('id', $id)
                          ->where('seller_id', auth()->id())
                          ->firstOrFail();

        Storage::disk('public')->delete($product->thumbnail);
        $product->delete();

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
