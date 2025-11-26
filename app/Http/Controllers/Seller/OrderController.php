<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $sellerId = Auth::id();

        $query = Order::where('seller_id', $sellerId);

        // =============================
        // SEARCH
        // =============================
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('order_code', 'like', "%{$request->search}%")
                  ->orWhere('buyer_name', 'like', "%{$request->search}%");
            });
        }

        // =============================
        // FILTER STATUS
        // =============================
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // =============================
        // FILTER METODE PEMBAYARAN
        // =============================
        if ($request->payment) {
            $query->where('payment_method', $request->payment);
        }

        // =============================
        // SORT
        // =============================
        if ($request->sort == 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Ambil data
        $orders = $query->paginate(10);

        // ================
        // PANGGIL VIEW SESUAI FOLDER KAMU
        // ================
        return view('seller.order-list', compact('orders'));
    }
}
