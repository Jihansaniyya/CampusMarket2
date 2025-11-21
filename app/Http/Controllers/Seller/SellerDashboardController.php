<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class SellerDashboardController extends Controller
{
    public function index()
    {
        $sellerId = Auth::id();

        // ============================
        // PRODUK SELLER
        // ============================
        $products = Product::where('seller_id', $sellerId)->get();
        $totalProducts  = $products->count();

        // ============================
        // TOTAL PESANAN MASUK
        // ============================
        $totalOrders = Order::where('seller_id', $sellerId)->count();

        // ============================
        // TOTAL RATING & TOTAL KOMENTAR
        // ============================
        $totalRatings = ProductReview::whereIn('product_id', $products->pluck('id'))->count();

        $totalComments = ProductReview::whereIn('product_id', $products->pluck('id'))
            ->whereNotNull('comment')
            ->count();

        // ============================
        // SEBARAN STOK PER PRODUK
        // ============================
        $stockDistribution = $products->map(function ($product) {
            return [
                'label' => $product->name,
                'value' => $product->stock,
            ];
        });

        // ============================
        // SEBARAN RATING PER PRODUK
        // ============================
        $ratingDistribution = $products->map(function ($product) {
            $avgRating = ProductReview::where('product_id', $product->id)->avg('rating');

            return [
                'label' => $product->name,
                'value' => round($avgRating ?? 0, 2),
            ];
        });

        // ============================
        // SEBARAN PROVINSI PEMBERI RATING
        // ============================
        $ratingProvinceStats = ProductReview::whereIn('product_id', $products->pluck('id'))
            ->selectRaw('IFNULL(province, "Tidak diketahui") as province, COUNT(*) as total')
            ->groupBy('province')
            ->get()
            ->map(function ($row) {
                return [
                    'label' => $row->province,
                    'value' => $row->total,
                ];
            });

        return view('seller.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalRatings',
            'totalComments',
            'stockDistribution',
            'ratingDistribution',
            'ratingProvinceStats'
        ));
    }
}
