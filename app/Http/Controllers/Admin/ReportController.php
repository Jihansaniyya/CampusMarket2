<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class ReportController extends Controller
{
    /**
     * Laporan daftar akun penjual aktif dan tidak aktif (SRS-MartPlace-09).
     */
    public function sellerStatus(): Response
    {
        $sellers = User::query()
            ->where('role', 'seller')
            ->select([
                'name',
                'email',
                'phone',
                'store_name',
                'approval_status',
                'approved_at',
                'created_at',
            ])
            ->orderByRaw("FIELD(approval_status, 'approved', 'pending', 'rejected')")
            ->orderBy('store_name')
            ->get()
            ->groupBy(fn (User $seller) => $seller->approval_status === 'approved' ? 'Aktif' : 'Tidak Aktif');

        $payload = [
            'title' => 'Laporan Penjual Aktif & Tidak Aktif',
            'subtitle' => 'SRS-MartPlace-09',
            'generatedAt' => now(),
            'sellers' => $sellers,
        ];

        return $this->downloadPdf('admin.reports.seller-status', $payload, 'laporan-penjual-aktif-vs-tidak-aktif.pdf');
    }

    /**
     * Laporan daftar penjual per provinsi (SRS-MartPlace-10).
     */
    public function sellerProvince(): Response
    {
        $sellers = User::query()
            ->where('role', 'seller')
            ->whereNotNull('provinsi')
            ->select([ 'store_name', 'name', 'email', 'phone', 'provinsi', 'approval_status' ])
            ->orderBy('provinsi')
            ->orderBy('store_name')
            ->get()
            ->groupBy('provinsi');

        $payload = [
            'title' => 'Laporan Penjual per Provinsi',
            'subtitle' => 'SRS-MartPlace-10',
            'generatedAt' => now(),
            'sellers' => $sellers,
        ];

        return $this->downloadPdf('admin.reports.seller-province', $payload, 'laporan-penjual-per-provinsi.pdf');
    }

    /**
     * Laporan daftar produk dan ratingnya (SRS-MartPlace-11).
     */
    public function productRatings(): Response
    {
        $products = Product::query()
            ->with(['category:id,name', 'seller:id,store_name,name,provinsi'])
            ->select(['id', 'category_id', 'seller_id', 'name', 'price', 'sale_price', 'rating', 'rating_count'])
            ->orderByDesc('rating')
            ->orderByDesc('rating_count')
            ->orderBy('name')
            ->get();

        $averageRating = $products->avg('rating') ?: 0;
        $totalReviews = ProductReview::count();

        $payload = [
            'title' => 'Laporan Produk & Rating',
            'subtitle' => 'SRS-MartPlace-11',
            'generatedAt' => now(),
            'products' => $products,
            'averageRating' => round($averageRating, 2),
            'totalReviews' => $totalReviews,
        ];

        return $this->downloadPdf('admin.reports.product-ratings', $payload, 'laporan-produk-dan-rating.pdf');
    }

    /**
     * Helper untuk merender PDF dan mengirimkan respons download.
     */
    protected function downloadPdf(string $view, array $data, string $filename): Response
    {
        return Pdf::loadView($view, $data)
            ->setPaper('a4', 'portrait')
            ->download($filename);
    }
}
