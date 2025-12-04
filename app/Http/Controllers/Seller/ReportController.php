<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf; // pastikan paket dompdf sudah terpasang

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
     * Laporan daftar stock produk yang diurutkan berdasarkan stock secara menurun.
     * Untuk setiap produk memuat:
     * - stok
     * - rating
     * - kategori produk
     * - harga
     * (format PDF)
     */
    public function stockDescPdf()
    {
        $products = $this->baseQueryWithRating()
            ->orderBy('products.stock', 'desc')
            ->get();

        $pdf = Pdf::loadView('seller.reports.pdf_stock_desc', [
            'products' => $products,
        ])->setPaper('A4', 'portrait');

        return $pdf->download('laporan_stok_produk_urut_stok_menurun.pdf');
    }

    /**
     * SRS-MartPlace-13
     * Laporan daftar stock produk yang diurutkan berdasarkan rating secara menurun.
     * Untuk setiap produk memuat:
     * - rating
     * - stok
     * - kategori produk
     * - harga
     * (format PDF)
     */
    public function ratingDescPdf()
    {
        $products = $this->baseQueryWithRating()
            ->orderBy('avg_rating', 'desc')
            ->get();

        $pdf = Pdf::loadView('seller.reports.pdf_rating_desc', [
            'products' => $products,
        ])->setPaper('A4', 'portrait');

        return $pdf->download('laporan_stok_produk_urut_rating_menurun.pdf');
    }

    /**
     * SRS-MartPlace-14
     * Laporan daftar stock barang yang harus segera dipesan
     * (stok produk yang segera dipesan jika stock < 2) dalam format PDF.
     */
    public function lowStockPdf()
    {
        $products = $this->baseQueryWithRating()
            ->where('products.stock', '<', 2)
            ->orderBy('products.stock', 'asc')
            ->get();

        $pdf = Pdf::loadView('seller.reports.pdf_low_stock', [
            'products' => $products,
        ])->setPaper('A4', 'portrait');

        return $pdf->download('laporan_barang_stok_kritis.pdf');
    }

    /**
     * Query dasar: produk + rata-rata rating
     * Asumsi:
     *  - tabel products
     *  - tabel product_reviews dengan kolom product_id dan rating
     * Silakan sesuaikan nama tabel/kolom kalau beda.
     */
    protected function baseQueryWithRating()
    {
        return Product::query()
            ->leftJoin('product_reviews', 'products.id', '=', 'product_reviews.product_id')
            ->select(
                'products.id',
                'products.name',
                'products.stock',
                'products.category',
                'products.price',
                DB::raw('COALESCE(AVG(product_reviews.rating), 0) as avg_rating')
            )
            ->groupBy(
                'products.id',
                'products.name',
                'products.stock',
                'products.category',
                'products.price'
            );
    }
}
