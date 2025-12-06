<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Halaman daftar laporan seller (SRS-MartPlace-12, 13, 14)
     */
    public function index()
    {
        return view('seller.reports.index');
    }

    /**
     * SRS-MartPlace-12
     * Laporan stok produk diurutkan berdasarkan stok menurun.
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
     * SRS-MartPlace-13
     * Laporan stok produk diurutkan berdasarkan rating menurun.
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
     * SRS-MartPlace-14
     * Laporan barang yang harus segera dipesan (stok < 2).
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
     * Query dasar: produk + rating + kategori
     * Mengikuti struktur yang dipakai di ReportController Admin.
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
