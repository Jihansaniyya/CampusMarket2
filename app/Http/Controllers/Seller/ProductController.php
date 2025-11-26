<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * LIST PRODUK
     */
    public function index(Request $request)
    {
        $query = Product::where('seller_id', auth()->id());

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->category) {
            $query->where('category', $request->category);
        }

        if ($request->condition) {
            $query->where('condition', $request->condition);
        }

        if ($request->status) {
            $query->where('status', $request->status);
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

        return view('seller.product-list', compact('products'));
    }


    /**
     * HALAMAN UPLOAD PRODUK
     */
    public function create()
    {
        return view('seller.product');
    }


    /**
     * SIMPAN PRODUK BARU
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string',
            'category'    => 'required|string',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:1',
            'stock'       => 'required|numeric|min:1',
            'weight'      => 'required|numeric|min:1',
            'thumbnail'   => 'required|image|max:2048',
            'condition'   => 'required|string',
        ]);

        $thumbnailPath = $request->file('thumbnail')->store('products', 'public');

        Product::create([
            'seller_id'     => auth()->id(),
            'name'          => $request->name,
            'category'      => $request->category,
            'sku'           => $request->sku,
            'description'   => $request->description,
            'price'         => $request->price,
            'stock'         => $request->stock,
            'min_order'     => $request->min_order ?? 1,
            'weight'        => $request->weight,
            'length'        => $request->length,
            'width'         => $request->width,
            'height'        => $request->height,
            'preorder'      => $request->preorder ?? 0,
            'preorder_days' => $request->preorder_days,
            'condition'     => $request->condition,
            'status'        => $request->submit_type == 'publish' ? 'publish' : 'draft',
            'thumbnail'     => $thumbnailPath,
        ]);

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }


    /**
     * HALAMAN EDIT PRODUK
     */
    public function edit($id)
    {
        $product = Product::where('id', $id)
                          ->where('seller_id', auth()->id())
                          ->firstOrFail();

        return view('seller.product-edit', compact('product'));
    }


    /**
     * UPDATE PRODUK
     */
    public function update(Request $request, $id)
    {
        $product = Product::where('id', $id)
                          ->where('seller_id', auth()->id())
                          ->firstOrFail();

        $request->validate([
            'name'        => 'required',
            'category'    => 'required',
            'description' => 'required',
            'price'       => 'required|numeric',
            'stock'       => 'required|numeric',
            'weight'      => 'required|numeric',
            'condition'   => 'required',
        ]);

        if ($request->hasFile('thumbnail')) {
            Storage::disk('public')->delete($product->thumbnail);
            $thumbnailPath = $request->file('thumbnail')->store('products', 'public');
        } else {
            $thumbnailPath = $product->thumbnail;
        }

        $product->update([
            'name'          => $request->name,
            'category'      => $request->category,
            'sku'           => $request->sku,
            'description'   => $request->description,
            'price'         => $request->price,
            'stock'         => $request->stock,
            'min_order'     => $request->min_order,
            'weight'        => $request->weight,
            'length'        => $request->length,
            'width'         => $request->width,
            'height'        => $request->height,
            'preorder'      => $request->preorder,
            'preorder_days' => $request->preorder_days,
            'condition'     => $request->condition,
            'status'        => $request->submit_type == 'publish' ? 'publish' : 'draft',
            'thumbnail'     => $thumbnailPath,
        ]);

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }


    /**
     * HAPUS PRODUK
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
