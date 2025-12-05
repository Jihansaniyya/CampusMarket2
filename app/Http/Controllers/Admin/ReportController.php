<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ReportController extends Controller
{
    /**
     * Halaman index laporan.
     */
    public function index(): View
    {
        return view('admin.reports.index');
    }

    /**
     * Laporan daftar akun penjual aktif dan tidak aktif.
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
            'generatedAt' => now(),
            'sellers' => $sellers,
        ];

        return $this->downloadPdf('admin.reports.seller-status', $payload, 'laporan-penjual-aktif-vs-tidak-aktif.pdf');
    }

    /**
     * Daftar 38 Provinsi di Indonesia.
     */
    private function getIndonesianProvinces(): array
    {
        return [
            'Aceh',
            'Sumatera Utara',
            'Sumatera Barat',
            'Riau',
            'Jambi',
            'Sumatera Selatan',
            'Bengkulu',
            'Lampung',
            'Kepulauan Bangka Belitung',
            'Kepulauan Riau',
            'DKI Jakarta',
            'Jawa Barat',
            'Jawa Tengah',
            'DI Yogyakarta',
            'Jawa Timur',
            'Banten',
            'Bali',
            'Nusa Tenggara Barat',
            'Nusa Tenggara Timur',
            'Kalimantan Barat',
            'Kalimantan Tengah',
            'Kalimantan Selatan',
            'Kalimantan Timur',
            'Kalimantan Utara',
            'Sulawesi Utara',
            'Sulawesi Tengah',
            'Sulawesi Selatan',
            'Sulawesi Tenggara',
            'Gorontalo',
            'Sulawesi Barat',
            'Maluku',
            'Maluku Utara',
            'Papua',
            'Papua Barat',
            'Papua Barat Daya',
            'Papua Tengah',
            'Papua Pegunungan',
            'Papua Selatan',
        ];
    }

    /**
     * Laporan daftar penjual per provinsi (SRS-MartPlace-10).
     */
    public function sellerProvince(): Response
    {
        // Ambil semua seller (tidak perlu filter email_verified_at untuk laporan)
        $allSellers = User::query()
            ->where('role', 'seller')
            ->whereNotNull('provinsi')
            ->where('provinsi', '!=', '')
            ->select(['store_name', 'name', 'email', 'phone', 'provinsi', 'approval_status'])
            ->orderBy('store_name')
            ->get();

        // Group by provinsi (normalized ke Title Case untuk matching)
        $sellersByProvince = $allSellers->groupBy(function ($seller) {
            return ucwords(strtolower($seller->provinsi));
        });

        // Buat struktur data dengan semua provinsi Indonesia
        $provinces = collect($this->getIndonesianProvinces())->mapWithKeys(function ($province) use ($sellersByProvince) {
            return [$province => $sellersByProvince->get($province, collect())];
        });

        // Tambahkan juga provinsi yang ada di database tapi tidak ada di daftar standar
        foreach ($sellersByProvince as $province => $sellers) {
            if (!$provinces->has($province)) {
                $provinces[$province] = $sellers;
            }
        }

        // Hitung statistik
        $totalSellers = $allSellers->count();
        $provincesWithSellers = $sellersByProvince->count();

        $payload = [
            'title' => 'Laporan Penjual per Provinsi Indonesia',
            'subtitle' => 'SRS-MartPlace-10',
            'generatedAt' => now(),
            'provinces' => $provinces,
            'totalSellers' => $totalSellers,
            'provincesWithSellers' => $provincesWithSellers,
            'totalProvinces' => count($this->getIndonesianProvinces()),
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
