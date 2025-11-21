<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $sellerId = Auth::id();

        $orders = Order::where('seller_id', $sellerId)
            ->latest()
            ->get();

        return view('seller.orders.index', compact('orders'));
    }
}
