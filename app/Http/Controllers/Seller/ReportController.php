<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display reports page
     */
    public function index()
    {
        return view('seller.reports.index');
    }

    /**
     * Generate stock report (descending order)
     */
    public function stockDescPdf()
    {
        $products = $this->baseQueryWithRating()
            ->orderByDesc('stock')
            ->orderBy('name')
            ->get();

        return Pdf::loadView('seller.reports.pdf-stock-desc', [
                'title'       => 'Laporan Stok Produk (Urut Stok Menurun)',
                'generatedAt' => now(),
                'products'    => $products,
            ])
            ->setPaper('a4', 'portrait')
            ->download('laporan_stok_produk_urut_stok_menurun.pdf');
    }

    /**
     * Generate rating report (descending order)
     */
    public function ratingDescPdf()
    {
        $products = $this->baseQueryWithRating()
            ->orderByDesc('avg_rating')    // alias dari kolom rating
            ->orderByDesc('rating_count')
            ->orderBy('name')
            ->get();

        return Pdf::loadView('seller.reports.pdf-rating-desc', [
                'title'       => 'Laporan Stok Produk (Urut Rating Menurun)',
                'generatedAt' => now(),
                'products'    => $products,
            ])
            ->setPaper('a4', 'portrait')
            ->download('laporan_stok_produk_urut_rating_menurun.pdf');
    }

    /**
     * Generate low stock report (stock < 2)
     */
    public function lowStockPdf()
    {
        $products = $this->baseQueryWithRating()
            ->where('stock', '<', 2)
            ->orderBy('stock')
            ->orderBy('name')
            ->get();

        return Pdf::loadView('seller.reports.pdf-low-stock', [
                'title'       => 'Laporan Barang yang Harus Segera Dipesan (Stok < 2)',
                'generatedAt' => now(),
                'products'    => $products,
            ])
            ->setPaper('a4', 'portrait')
            ->download('laporan_barang_stok_kritis.pdf');
    }

    /**
     * Base query for products with ratings
     */
    protected function baseQueryWithRating()
    {
        return Product::query()
            ->with(['category:id,name'])          
            ->where('seller_id', Auth::id())      
            ->select([
                'id',
                'category_id',
                'seller_id',
                'name',
                'stock',
                'price',
                'rating as avg_rating',         
                'rating_count',
            ]);
    }
}
