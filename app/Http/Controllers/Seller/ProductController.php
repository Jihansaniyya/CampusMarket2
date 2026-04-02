<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
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
            'sale_price'  => 'nullable|numeric|min:0|lt:price',
            'stock'       => 'required|integer|min:0',
            'thumbnails'  => 'required|array|min:1',
            'thumbnails.*' => 'image|mimes:jpeg,jpg,png|max:2048',
        ], [
            'thumbnails.required' => 'Minimal upload 1 foto produk.',
            'thumbnails.min' => 'Minimal upload 1 foto produk.',
            'thumbnails.*.image' => 'File yang diupload harus berupa gambar.',
            'thumbnails.*.mimes' => 'Format foto harus JPG atau PNG.',
            'thumbnails.*.max' => 'Ukuran setiap foto maksimal 2MB.',
        ]);

        DB::transaction(function () use ($request) {
            $uploadedPaths = [];

            foreach ($request->file('thumbnails', []) as $file) {
                $uploadedPaths[] = $file->store('products', 'public');
            }

            $product = Product::create([
                'seller_id'     => auth()->id(),
                'category_id'   => $request->category_id,
                'name'          => $request->name,
                'slug'          => Str::slug($request->name) . '-' . Str::random(6),
                'description'   => $request->description,
                'price'         => $request->price,
                'sale_price'    => $request->sale_price ?: null,
                'stock'         => $request->stock,
                'thumbnail'     => $uploadedPaths[0] ?? null,
                'is_active'     => $request->submit_type == 'publish' ? true : false,
            ]);

            foreach ($uploadedPaths as $index => $path) {
                $product->images()->create([
                    'path' => $path,
                    'sort_order' => $index,
                ]);
            }
        });

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
            'sale_price'  => 'nullable|numeric|min:0|lt:price',
            'stock'       => 'required|integer|min:0',
            'thumbnails'  => 'nullable|array|min:1',
            'thumbnails.*' => 'image|mimes:jpeg,jpg,png|max:2048',
            'remove_existing_images' => 'nullable|array',
            'remove_existing_images.*' => 'integer|exists:product_images,id',
        ], [
            'thumbnails.min' => 'Minimal upload 1 foto produk.',
            'thumbnails.*.image' => 'File yang diupload harus berupa gambar.',
            'thumbnails.*.mimes' => 'Format foto harus JPG atau PNG.',
            'thumbnails.*.max' => 'Ukuran setiap foto maksimal 2MB.',
        ]);

        DB::transaction(function () use ($request, $product) {
            $updatePayload = [
                'name'        => $request->name,
                'category_id' => $request->category_id,
                'slug'        => Str::slug($request->name) . '-' . Str::random(6),
                'description' => $request->description,
                'price'       => $request->price,
                'sale_price'  => $request->sale_price ?: null,
                'stock'       => $request->stock,
                'is_active'   => $request->submit_type == 'publish' ? true : false,
            ];

            $removedPaths = [];
            $removeImageIds = array_map('intval', $request->input('remove_existing_images', []));
            $removeImageIds = array_values(array_unique($removeImageIds));

            if (!empty($removeImageIds)) {
                $imagesToRemove = $product->images()->whereIn('id', $removeImageIds)->get(['id', 'path']);
                $removedPaths = $imagesToRemove->pluck('path')->filter()->values()->all();

                if (!empty($removedPaths)) {
                    Storage::disk('public')->delete($removedPaths);
                }

                if ($imagesToRemove->isNotEmpty()) {
                    $product->images()->whereIn('id', $imagesToRemove->pluck('id'))->delete();
                }
            }

            if ($request->hasFile('thumbnails')) {
                $lastOrder = (int) $product->images()->max('sort_order');
                $nextOrder = $product->images()->exists() ? $lastOrder + 1 : 0;

                $newPaths = [];
                foreach ($request->file('thumbnails', []) as $file) {
                    $path = $file->store('products', 'public');
                    $newPaths[] = $path;

                    $product->images()->create([
                        'path' => $path,
                        'sort_order' => $nextOrder++,
                    ]);
                }
            }

            $remainingPaths = $product->images()->pluck('path')->filter()->values()->all();

            if ($product->thumbnail && in_array($product->thumbnail, $removedPaths, true)) {
                $updatePayload['thumbnail'] = $remainingPaths[0] ?? null;
            } elseif (!$product->thumbnail && !empty($remainingPaths)) {
                $updatePayload['thumbnail'] = $remainingPaths[0];
            }

            $product->update($updatePayload);
        });

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

        $imagePaths = $product->images()->pluck('path')->toArray();
        if ($product->thumbnail) {
            $imagePaths[] = $product->thumbnail;
        }

        $imagePaths = array_values(array_unique(array_filter($imagePaths)));
        if (!empty($imagePaths)) {
            Storage::disk('public')->delete($imagePaths);
        }

        $product->images()->delete();
        $product->delete();

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
